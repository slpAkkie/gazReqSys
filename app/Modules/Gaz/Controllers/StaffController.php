<?php

namespace Modules\Gaz\Controllers;

use Illuminate\Http\Request;
use Modules\Gaz\Resources\StaffResource;
use Modules\Gaz\Models\Staff;

class StaffController extends \App\Http\Controllers\Controller
{
    /**
     * Получить список сотрудников по их табельному номеру в указаной организации
     *
     * @param  \Illuminate\Http\Request $request
     * @return StaffResource
     */
    public function index(Request $request) {
        $department_id = $request->get('department_id');
        $emp_numbers = $request->get('emp_numbers');

        if (!$department_id) return abort(404, 'Для поиска нужно указать организацию');
        if (!$emp_numbers) return abort(404, 'Табельные номера не переданы');

        $foundStaff = Staff::whereIn('emp_number', explode(',', $emp_numbers))->whereHas('departments', function($q) use ($department_id) {
            $q->where('departments.id', $department_id)->whereNull('staff_history.fired_at');
        })->get();

        if ($request->has('is_wt')) $foundStaff->map(function ($s) {
            $s->showWTInfo = true;
        });

        // TODO: REVIEW
        if ($foundStaff) return StaffResource::collection($foundStaff);

        return abort(404, 'Сотрудник не найден');
    }
}
