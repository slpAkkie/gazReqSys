<?php

namespace Modules\GReqSys\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function messages()
    {
        return [
            'login.required'     => 'Поле Логин должно быть заполнено',
            'password.required'  => 'Поле Пароль должно быть заполнено',
        ];
    }

    /**
     * Список правил валидации
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'login'     => 'required',
            'password'  => 'required',
        ];
    }
}
