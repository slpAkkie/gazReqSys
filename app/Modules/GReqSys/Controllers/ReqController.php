<?php

namespace Modules\GReqSys\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Modules\Gaz\Models\City;
use Modules\Gaz\Models\Staff;
use Modules\GReqSys\Models\InvolvedStaff;
use Modules\GReqSys\Models\Req;
use Modules\GReqSys\Models\ReqType;
use Modules\GReqSys\Requests\StoreReqRequest;

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
     * Создать заявку и сохранить вовлеченных пользователей
     * TODO: Перенаправлять запрос в модуль WT на создание аккаунтов,
     * при этом нужно проверять тех, у кого аккаунт уже есть и,
     * наверное, пропускать их
     *
     * @return JsonResponse
     */
    public function store(StoreReqRequest $request) {
        ($req = new Req($request->only([
            'type_id',
            'department_id',
        ])))->save();

        $emp_numbers = Collection::make($request->get('staff'))->reduce(function ($r, $v) {
            $r[] = $v['emp_number'];

            return $r;
        } ,[]);

        $req->involved_staff_records()->createMany(
            Staff::select('staff.id')->whereIn('emp_number', $emp_numbers)->whereHas('departments', function ($q) use ($request) {
                $q->where('departments.id', $request->get('department_id'));
            })->get()->reduce(function ($r, $v) {
                $r[] = [
                    'gaz_staff_id' => $v['id'],
                ];

                return $r;
            }, [])
        )->each(function ($model) {
            $model->save();
        });

        return response()->json();
    }
}
