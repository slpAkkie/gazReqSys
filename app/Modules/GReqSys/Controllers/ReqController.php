<?php

namespace Modules\GReqSys\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Modules\Gaz\Models\City;
use Modules\Gaz\Models\Staff;
use Modules\GReqSys\Models\Req;
use Modules\GReqSys\Models\ReqType;
use Modules\GReqSys\Requests\StoreReqRequest;
use Modules\GWT\Controllers\BackController;

class ReqController extends Controller
{
    /**
     * Страница списка заявок
     *
     * @return View
     */
    public function index()
    {
        return view('GReqSys::index', [
            'reqs' => Req::paginate(18),
        ]);
    }

    /**
     * Страница заявки
     *
     * @return View
     */
    public function show(Req $req)
    {
        return view('GReqSys::Req.show', [
            'req' => $req,
            'involved_staff' => $req->getInvolvedStaff(),
        ]);
    }

    /**
     * Страница для создания новой заявки
     *
     * @return View
     */
    public function create()
    {
        return view('GReqSys::Req.create', [
            'req_types' => ReqType::all(),
            'cities' => City::all(),
        ]);
    }

    /**
     * Создаем саму заявку и сохраняем сотрудников, вовлеченных в нее
     *
     * @param Request $request
     * @param Collection $staffCollection
     * @return Req
     */
    private function storeReqAndInvolvedStaff(Request $request, Collection $staffCollection)
    {
        // Создаем заявку
        ($req = new Req($request->only([
            'type_id',
            'department_id',
        ])))->save();

        // Создаем записи о вовлеченных сотрудниках
        $req->involved_staff_records()->createMany(
            $staffCollection->map(function ($v) {
                return [ 'gaz_staff_id' => $v['id'] ];
            })
        )->each(function ($model) {
            $model->save();
        });

        return $req;
    }

    /**
     * Создать заявку на создание аккаунта сотруднику в системе WT
     *
     * @param Collection<Staff> $staffCollection
     * @param Req $req
     * @return JsonResponse
     */
    private function storeReqCreateWTAccounts(Collection $staffCollection, Req $req)
    {
        /**
         * Не самый лучший вариант, из-за связности
         * Но по другому у меня не получилось
         * Хотел передавать управление в другой контроллер,
         * но что-то не пошло, да будет так
         */
        app(BackController::class)->createAccounts($staffCollection);

        return response()->json($req->id);
    }

    /**
     * Проверить корректность данных о сотрудниках, отправленных с клиента
     *
     * @param array $staff
     * @return Collection<Staff>
     */
    private function validateStaff(array $staff) {
        $query = Staff::select();

        $staffDataColection = Collection::make($staff)->each(function ($s) use ($query) {
            $query->orWhere(function ($query) use ($s) {
                $query->where([
                    'first_name' => $s['first_name'],
                    'last_name' => $s['last_name'],
                    'second_name' => $s['second_name'],
                    'emp_number' => $s['emp_number'],
                    'email' => $s['email'],
                    'insurance_number' => $s['insurance_number'],
                ])->whereHas('departments', function($q) use ($s) {
                    $q->where('departments.id', $s['department_id']);
                });
            });
        });

        $staffModelCollection = $query->get();
        $wrongStaffIndexes = Collection::make();

        if ($staffDataColection->count() !== $staffModelCollection->count()) {
            $emp_numbers = $staffModelCollection->pluck('emp_number');

            $staffDataColection->each(function ($v, $k) use ($wrongStaffIndexes, $emp_numbers) {
                if (!$emp_numbers->some(function ($emp_number) use ($v) { return $v['emp_number'] === $emp_number; }))
                    $wrongStaffIndexes->push($k);
            });

            throw ValidationException::withMessages((array) $wrongStaffIndexes->reduce(function ($errors, $i) {
                $errors['staff.'.$i] = [ 'Сотрудника с такими данными не существует' ];

                return $errors;
            }, []));
        }

        return $staffModelCollection;
    }

    /**
     * Создать заявку и сохранить вовлеченных пользователей
     *
     * @throws ValidationException
     * @return JsonResponse
     */
    public function store(StoreReqRequest $request) {
        /**
         * Проверка корректности введеных данных сотрудниках
         */
        $staffCollection = $this->validateStaff($request->get('staff'));

        /**
         * Создаем саму заявку и сохраняем сотрудников, вовлеченных в нее
         */
        $req = $this->storeReqAndInvolvedStaff($request, $staffCollection);

        /**
         * Проверяем тип заявки и вызываем соответствующтий метод
         */
        if ($request->get('type_id') == 1) return $this->storeReqCreateWTAccounts($staffCollection, $req);

        /**
         * Если тип заявки еще не был написан, вызываем ошибку
         */
        throw ValidationException::withMessages([
            'type_id' => [ 'Выбранный тип заявки еще не сделан' ],
        ]);
    }
}
