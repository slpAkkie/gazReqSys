<?php

namespace Modules\Gaz\Controllers;

use Illuminate\Http\Request;
use Modules\Gaz\Models\City;
use Modules\Gaz\LaravelResources\OrganizationResource;
use Modules\Gaz\LaravelResources\StuffResource;
use Modules\Gaz\Models\Stuff;

class StuffController extends \App\Http\Controllers\Controller
{
    /**
     * Получить список организаций.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return OrganizationResource
     */
    public function organizations(Request $request) {
        $orgs = City::find($request->id)->departments;
        return OrganizationResource::collection($orgs);
    }

    /**
     * Получить список сотрудников.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return StuffResource
     */
    public function stuff(Request $request) {
        $stuff = Stuff::where('emp_number', $request->emp_number)->first();
        return StuffResource::make($stuff);
    }
}
