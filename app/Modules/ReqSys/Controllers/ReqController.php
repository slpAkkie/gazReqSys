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
use Illuminate\Support\Facades\Auth;
use Modules\ReqSys\Requests\ShowReqRequest;

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
            'reqs' => (
                Auth::user()->admin
                    ? Req::select()
                    : Req::where('author_id', Auth::id())
                )->paginate(18),
        ]);
    }

    /**
     * Страница с выводом всех заявок
     *
     * @return View
     */
    public function indexForMe()
    {
        return view('ReqSys::index', [
            'reqs' => Req::whereHas('req_staff_meta', fn($q) => $q->where('gaz_staff_id', Auth::user()->staff->id))->paginate(18),
        ]);
    }

    /**
     * Страница с информацией по заявкe
     * TODO: Gate для проверки доступа к просмотру заявки
     *
     * @return View
     */
    public function show(ShowReqRequest $request, Req $req)
    {
        $maySeeAllStaff = Auth::user()->admin || $req->author_id === Auth::id();
        $req_staff = $req->reqStaff();

        if (!$maySeeAllStaff) $req_staff->where('id', Auth::user()->staff->id);

        return view('ReqSys::Req.show', [
            'req' => $req,
            'req_staff' => $req_staff->get(),
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

        $req->req_staff_meta()->createMany(
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
        $staffCollection->each(fn($staff) => $staff->wt_account()->exists() && $staff->wt_account->delete());

        return response()->json($req->id);
    }

    /**
     * Деактивация учетных записей сотрудников
     *
     * @param Collection<Staff> $staffCollection
     * @param Req $req
     * @return JsonResponse
     */
    private function deactivateStaff(Collection $staffCollection, Req $req)
    {
        $staffCollection->each(fn($staff) => $staff->delete());

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
        $query = Staff::selectRaw('staff.*');

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
                ])
            )
        );

        $query = $query->leftJoin(
            'staff_history',
            'staff_history.staff_id', 'staff.id'
        )->where('staff_history.organization_id', $organization_id);

        if (!Auth::user()->admin) $query->where(fn($q) => $q->where('staff.manager_id', Auth::user()->staff->id)->orWhere('staff.id', Auth::user()->staff->id));

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
                $errors['staff.'.$i] = [ 'Сотрудника с такими данными не существует или вы не являетесь его руководителем' ];

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
            3 => $this->deactivateStaff($staffCollection, $req),

            // Если тип заявки еще не был написан, вызываем ошибку
            default => throw ValidationException::withMessages([
                'type_id' => [ 'Выбранный тип заявки еще не сделан' ],
            ])
        };
    }
}
