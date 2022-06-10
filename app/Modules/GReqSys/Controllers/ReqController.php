<?php

namespace Modules\GReqSys\Controllers;

use App\Http\Controllers\Controller;
use Modules\GReqSys\Models\Req;

class ReqController extends Controller
{
    /**
     * Страница списка заявок
     *
     * @return View
     */
    public function index()
    {
        $reqs = Req::paginate(25);

        return view('GReqSys::index',[
            'reqs' => $reqs
        ]);
    }

    public function create()
    {
        // TODO: Создание новой заявки

        return view('GReqSys::Req.create');
    }
}
