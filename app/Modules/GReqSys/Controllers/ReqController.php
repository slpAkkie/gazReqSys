<?php

namespace Modules\GReqSys\Controllers;

use App\Http\Controllers\Controller;

class ReqController extends Controller
{
    public function index()
    {
        // TODO: Вывод всех заявок

        return view('GReqSys::index');
    }

    public function create()
    {
        // TODO: Создание новой заявки

        return view('GReqSys::Req.create');
    }
}
