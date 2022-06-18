<?php

namespace Modules\Gaz\Controllers;

use Illuminate\Http\Request;
use Modules\Gaz\APIResources\OrganizationResource;
use Modules\Gaz\Models\Organization;

class OrganizationController extends \App\Http\Controllers\Controller
{
    /**
     * Получить список организаций
     *
     * @param  \Illuminate\Http\Request $request
     * @return OrganizationResource
     */
    public function index(Request $request) {
        return OrganizationResource::collection(
            Organization::where('city_id', $request->get('city_id'))->get()
        );
    }
}
