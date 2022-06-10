<?php

namespace Modules\GReqSys\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Modules\GReqSys\Models\User;
use Modules\GReqSys\Requests\LoginRequest;

class AuthController extends Controller
{
    private function returnFailedLogin()
    {
        return Response::back()->withErrors([
            'login' => [ 'Логин или пароль указан не верно' ],
        ]);
    }

    public function login(LoginRequest $request)
    {
        // TODO: Вход в систему
        $foundUser = User::where('login', $request->get('login'))->first();
        if (!$foundUser) return $this->returnFailedLogin();

        if (!$foundUser->checkPassword($request->get('password'))) return $this->returnFailedLogin();

        Auth::login($foundUser);

        return response()->redirectToRoute('index');
    }

    public function logout()
    {
        // TODO: Выход из системы
        Auth::logout();

        return response()->redirectToRoute('login');
    }
}
