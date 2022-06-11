<?php

namespace Modules\Gaz\Controllers;

use Illuminate\Http\Request;
use Modules\Gaz\LaravelResources\StuffResource;
use Modules\Gaz\Models\Stuff;

class StuffController extends \App\Http\Controllers\Controller
{
    /**
     * Получить список сотрудников по их табельному номеру в указаной организации
     *
     * @param  \Illuminate\Http\Request $request
     * @return StuffResource
     */
    public function show(Request $request) {
        $department_id = $request->get('department_id');

        if (!$department_id) return abort(404, 'Для поиска нужно указать организацию');

        $foundStuff = Stuff::whereIn('emp_number', explode(',', $request->get('emp_number')))->whereHas('departments', function($q) use ($department_id) {
            $q->where('departments.id', $department_id)->whereNull('stuff_history.fired_at');
        })->get();

        if ($foundStuff) return StuffResource::collection($foundStuff);

        return abort(404, 'Сотрудник не найден');
    }
}
