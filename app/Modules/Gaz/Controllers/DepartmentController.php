<?php

namespace Modules\Gaz\Controllers;

use Illuminate\Http\Request;
use Modules\Gaz\LaravelResources\DepartmentResource;
use Modules\Gaz\Models\Department;

class DepartmentController extends \App\Http\Controllers\Controller
{
    /**
     * Получить список организаций
     *
     * @param  \Illuminate\Http\Request $request
     * @return DepartmentResource
     */
    public function index(Request $request) {
        return DepartmentResource::collection(
            Department::where('city_id', $request->get('city_id'))->get()
        );
    }
}
