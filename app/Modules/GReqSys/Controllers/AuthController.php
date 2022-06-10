<?php

namespace Modules\GReqSys\Controllers;

use App\Http\Controllers\Controller;
use Modules\GReqSys\Requests\LoginRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        // TODO: Вход в систему
        return abort(403, 'Доступ временно запрещен');
    }

    public function logout()
    {
        // TODO: Выход из системы

        return abort(403, 'Доступ временно запрещен');
    }
}
