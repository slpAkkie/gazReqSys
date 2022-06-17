<?php

namespace Modules\ReqSys\Controllers;

use Illuminate\Contracts\View\View;

class WebController extends \App\Http\Controllers\Controller
{

    /**
     * Страница входа в панель
     *
     * @return View
     */
    public function login()
    {
        return view('ReqSys::login');
    }

}
