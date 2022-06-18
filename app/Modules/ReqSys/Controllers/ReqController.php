<?php

namespace Modules\ReqSys\Controllers;

use App\Http\Controllers\Controller;
use Modules\WT\Controllers\BackController;
use Illuminate\Http\Request;
use Modules\ReqSys\Requests\StoreReqRequest;
use Modules\Gaz\Models\City;
use Modules\Gaz\Models\Staff;
use Modules\ReqSys\Models\Req;
use Modules\ReqSys\Models\ReqType;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;

class ReqController extends Controller
{
    /**
     * Страница с выводом всех заявок
     *
     * @return View
     */
    public function index()
    {
        return view('ReqSys::index', [
            'reqs' => Req::paginate(18),
        ]);
    }

    /**
     * Страница с информацией по заявкe
     * TODO: Gate для проверки доступа к просмотру заявки
     *
     * @return View
     */
    public function show(Req $req)
    {
        return view('ReqSys::Req.show', [
            'req' => $req,
            'req_staff' => $req->getReqStaff(),
        ]);
    }

    /**
     * Страница с формой создания новой заявки
     *
     * @return View
     */
    public function create()
    {
        return view('ReqSys::Req.create', [
            'req_types' => ReqType::all()->sortBy('id'),
            'cities' => City::all()->sortBy('title'),
        ]);
    }

    /**
     * Создаем заявку и записываем сотрудников в нее
     *
     * @param Request $request
     * @param Collection $staffCollection
     * @return Req
     */
    private function storeReqAndStaff(Request $request, Collection $staffCollection)
    {
        ($req = new Req($request->only([
            'type_id',
            'organization_id',
        ])))->save();

        $req->req_staff_records()->createMany(
            $staffCollection->map(fn($v) => [ 'gaz_staff_id' => $v['id'] ])
        )->each(fn($model) => $model->save());

        return $req;
    }

    /**
     * Создать аккаунты сотрудникам в системе WT
     *
     * @param Collection<Staff> $staffCollection
     * @param Req $req
     * @return JsonResponse
     */
    private function createWTAccounts(Collection $staffCollection, Req $req)
    {
        // REVIEW: Такой вызов другого контроллера плохой тон
        // Если есть вариант лучше, надо переделать
        app(BackController::class)->createAccounts($staffCollection);

        return response()->json($req->id);
    }

    /**
     * Отключение аккаунтов сотрудникам в системе WT
     *
     * @param Collection<Staff> $staffCollection
     * @param Req $req
     * @return JsonResponse
     */
    private function disableWTAccounts(Collection $staffCollection, Req $req)
    {
        $staffCollection->each(fn($staff) => $staff->wt_account->disable());

        return response()->json($req->id);
    }

    /**
     * Деактивация учетных записей сотрудников
     *
     * @param Collection<Staff> $staffCollection
     * @param Req $req
     * @return JsonResponse
     */
    private function fireStaff(Collection $staffCollection, Req $req)
    {
        $staffCollection->each(fn($staff) => $staff->fire());

        return response()->json($req->id);
    }

    /**
     * Проверить корректность данных о сотрудниках, отправленных с клиента
     *
     * @param Request $request
     * @return Collection<Staff>
     */
    private function validateStaff(Request $request) {
        $staff = $request->get('staff');
        $organization_id = $request->get('organization_id');
        $query = Staff::select();

        // Запрос на получение всех сотрудников, которые полностью совпадают данным из запроса
        // TODO: Делать проверку на разрешение пользователю создавать заявки на этого сотрудника
        $staffDataColection = Collection::make($staff)->each(fn($s) => $query->orWhere(
            fn($query) => $query->where(
                [
                    'first_name' => $s['first_name'],
                    'last_name' => $s['last_name'],
                    'second_name' => $s['second_name'],
                    'emp_number' => $s['emp_number'],
                    'email' => $s['email'],
                    'insurance_number' => $s['insurance_number'],
                ])->whereHas('organizations', fn($q) => $q->where('organizations.id', $organization_id))
            )
        );

        $staffModels = $query->get();
        $wrongStaffIndexes = Collection::make();

        // Нашлись не все сотрудники из запроса
        if ($staffDataColection->count() !== $staffModels->count()) {
            $insurance_numbers = $staffModels->pluck('insurance_number');

            // Если итерируемого СНИЛС нет в списке полученных сотрудников,
            // то записываем соответствующего сотрудника как не найденного
            $staffDataColection->each(
                fn($v, $k) => (!$insurance_numbers->some(
                    fn($insurance_number) => $v['insurance_number'] === $insurance_number
                )) && $wrongStaffIndexes->push($k)
            );

            // Бросаем исключение об ошибке в валидации данных запроса
            throw ValidationException::withMessages((array) $wrongStaffIndexes->reduce(function ($errors, $i) {
                $errors['staff.'.$i] = [ 'Сотрудника с такими данными не существует' ];

                return $errors;
            }, []));
        }

        return $staffModels;
    }

    /**
     * Обработчик создания заявки
     *
     * @throws ValidationException
     * @return JsonResponse
     */
    public function store(StoreReqRequest $request) {
        // Проверка корректности введеных данных сотрудниках
        $staffCollection = $this->validateStaff($request);

        // Создаем саму заявку и сохраняем сотрудников, вовлеченных в нее
        $req = $this->storeReqAndStaff($request, $staffCollection);

        // Проверяем тип заявки и вызываем соответствующтий метод
        return match($request->get('type_id')) {
            1 => $this->createWTAccounts($staffCollection, $req),
            2 => $this->disableWTAccounts($staffCollection, $req),
            3 => $this->fireStaff($staffCollection, $req),

            // Если тип заявки еще не был написан, вызываем ошибку
            default => throw ValidationException::withMessages([
                'type_id' => [ 'Выбранный тип заявки еще не сделан' ],
            ])
        };
    }
}
