<?php

namespace Modules\ReqSys\Controllers;

use Illuminate\Support\Facades\Auth;

class UserController extends \App\Http\Controllers\Controller
{
    public function profile()
    {
        return view('ReqSys::User.profile', [
            'user' => Auth::user(),
        ]);
    }
}
