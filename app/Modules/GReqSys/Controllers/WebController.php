<?php

namespace Modules\GReqSys\Controllers;

class WebController extends \App\Http\Controllers\Controller
{
    /**
     * Вывод главной страницы
     *
     * @return View
     */
    public function index()
    {
        return view('GReqSys::index');
    }
}
