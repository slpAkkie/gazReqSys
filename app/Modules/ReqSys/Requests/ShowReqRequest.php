<?php

namespace Modules\ReqSys\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Modules\ReqSys\Models\Req;

class ShowReqRequest extends FormRequest
{
    /**
     * Определяет может ли пользователь выполнить запрос
     *
     * @return bool
     */
    public function authorize()
    {
        $req = $this->route('req');
        return $req->author_id === Auth::id() || $req->req_staff_meta()->where('gaz_staff_id', Auth::user()->staff->id)->exists();
    }

    /**
     * Список описания ошибок
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
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
            //
        ];
    }
}
