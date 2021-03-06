<?php

namespace Modules\ReqSys\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Список описания ошибок
     *
     * @return array
     */
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
