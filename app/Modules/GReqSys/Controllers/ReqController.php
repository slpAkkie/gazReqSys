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
            'reqs' => Req::cursorPaginate(25),
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
     * Создать заявку на создание аккаунта сотруднику в системе WT
     *
     * @param Request $request
     * @return JsonResponse
     */
    private function storeReqCreateWTAccounts(Request $request)
    {
        // Создаем заявку
        ($req = new Req($request->only([
            'type_id',
            'department_id',
        ])))->save();

        // Создаем список сотрудников и отдельно список их табельных номеров
        $staff = Collection::make();
        $emp_numbers = Collection::make($request->get('staff'))->reduce(function ($r, $v) use ($staff) {
            $r[] = $v['emp_number'];
            $staff->push($v);

            return $r;
        } ,[]);

        // Создаем записи о вовлеченных сотрудниках
        $req->involved_staff_records()->createMany(
            // Нужно выбрать все id сотрудников,
            // табельные номера которых были переданы
            // (В соответствии с указанной организацией)
            Staff::select('staff.id')->whereIn('emp_number', $emp_numbers)->whereHas('departments', function ($q) use ($request) {
                $q->where('departments.id', $request->get('department_id')); // TODO: REVIEW
            })->get()
            // Преобразуем данные о id в вид
            // принимаемый функцией createMany
            ->reduce(function ($r, $v) {
                $r[] = [
                    'gaz_staff_id' => $v['id'],
                ];

                return $r;
            }, [])
        )
        // Сохраняем все созданные модели
        // записей о вовлеченных сотрудниках в БД
        ->each(function ($model) {
            $model->save();
        });

        /**
         * Не самый лучший вариант, из-за связности
         * Но по другому у меня не получилось
         * Хотел передавать управление в другой контроллер,
         * но что-то не пошло, да будет так
         */
        app(BackController::class)->createAccounts($staff);

        return response()->json();
    }

    /**
     * Создать заявку и сохранить вовлеченных пользователей
     *
     * @throws ValidationException
     * @return JsonResponse
     */
    public function store(StoreReqRequest $request) {
        /**
         * Проверяем тип заявки и вызываем соответствующтий метод
         */
        if ($request->get('type_id') == 1) return $this->storeReqCreateWTAccounts($request);

        /**
         * Если тип заявки еще не был написан, вызываем ошибку
         */
        throw ValidationException::withMessages([
            'type_id' => [ 'Этот тип заявки еще не сделан' ],
        ]);
    }
}
