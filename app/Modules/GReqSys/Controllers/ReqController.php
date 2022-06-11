<?php

namespace Modules\GReqSys\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Modules\Gaz\Models\City;
use Modules\GReqSys\Models\Req;
use Modules\GReqSys\Models\ReqType;

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
}
