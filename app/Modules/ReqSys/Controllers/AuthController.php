<?php

namespace Modules\ReqSys\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\ReqSys\Models\User;
use Modules\ReqSys\Requests\LoginRequest;

class AuthController extends Controller
{
    /**
     * Отправить пользователя назад с пояснением ошибки
     *
     * @return RedirectResponse
     */
    private function returnFailedLogin()
    {
        return redirect()->back()->withErrors([
            'login' => [ 'Логин или пароль указан не верно' ],
        ])->withInput();
    }

    /**
     * Handle POST login request
     *
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        $foundUser = User::where('login', $request->get('login'))->first();
        if (!$foundUser) return $this->returnFailedLogin();

        if (!$foundUser->checkPassword($request->get('password'))) return $this->returnFailedLogin();

        Auth::login($foundUser, !!$request->get('remember_me'));
        $request->session()->regenerate();

        return response()->redirectToRoute('index');
    }

    /**
     * Handle PUT logout request
     *
     * @return RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->regenerate();

        return response()->redirectToRoute('login');
    }
}
