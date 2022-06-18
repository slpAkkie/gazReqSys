<?php

namespace Modules\Gaz\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Gaz\APIResources\StaffResource;
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
        $organization_id = $request->get('organization_id');
        $emp_numbers = $request->get('emp_numbers');

        if (!$organization_id) return abort(422, 'Для поиска нужно указать организацию');
        if (!$emp_numbers) return abort(422, 'Табельные номера не переданы');

        $query = Staff::whereIn('emp_number', explode(',', $emp_numbers))->leftJoin(
            'staff_history',
            'staff_history.staff_id', 'staff.id'
        )->whereNull('staff_history.fired_at')
        ->where('staff_history.organization_id', $organization_id)->with('job_meta');

        if (!Auth::user()->admin) $query->where(fn($q) => $q->where('manager_id', Auth::id())->orWhere('staff.id', Auth::user()->staff->id));

        $foundStaff = $query->get();

        if ($foundStaff->count()) return StaffResource::collection($foundStaff);

        return abort(404, 'Сотрудники с переданными табельными номерами не найдены в указанной организации или вы не являетесь их руководителем');
    }
}
