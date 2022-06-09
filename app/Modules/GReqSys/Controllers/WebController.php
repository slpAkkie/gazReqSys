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


    /**
     * Вход в панель
     *
     * @return View
     */
    public function loginPage()
    {
        return view('GReqSys::login');
    }

    /**
     * Вывод статус кодов
     *
     * @return View
     */
    public function statusPage()
    {
        return view('GReqSys::status');
    }
}
