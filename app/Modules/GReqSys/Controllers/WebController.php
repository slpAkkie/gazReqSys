<?php

namespace Modules\GReqSys\Controllers;

use Illuminate\Contracts\View\View;

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
     * Страница входа в панель
     *
     * @return View
     */
    public function showLogin()
    {
        return view('GReqSys::login');
    }
}
