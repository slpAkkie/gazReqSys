<?php

namespace Modules\GReqSys\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReqRequest extends FormRequest
{
    /**
     * Список описания ошибок
     *
     * @return array
     */
    public function messages()
    {
        return [
            'type_id.required'          => 'Поле Тип заявки должно быть заполнено',
            'type_id.exists'            => 'Некорректное значение для Тип заявки',
            'city_id.required'          => 'Поле Область должно быть заполнено',
            'city_id.exists'            => 'Некорректное значение для Область',
            'department_id.required'    => 'Поле Организация должно быть заполнено',
            'department_id.exists'      => 'Некорректное значение для Организация',
            'stuff.required'            => 'Список Сотрудников должен быть заполнен',
            'stuff.array'               => 'Список сотрудников должен быть массивом',
            'stuff.min'                 => 'Список сотрудников должен содержать хотя бы одну запись',

            'stuff.*.first_name.required'       => 'Поле Имя сотрудника должно быть заполнено',
            'stuff.*.last_name.required'        => 'Поле Фамилия сотрудника должно быть заполнено',
            'stuff.*.second_name.required'      => 'Поле Отчество должно быть заполнено',
            'stuff.*.emp_number.required'       => 'Поле Табельный номер должно быть заполнено',
            'stuff.*.emp_number.regex'          => 'Табельный номер должен состоять из 6 цифр',
            'stuff.*.emp_number.exists'         => 'Сотрудника с таким Табельным номером не существует',
            'stuff.*.email.required'            => 'Поле Email должно быть заполнено',
            'stuff.*.email.exists'              => 'Сотрудника с таким Email не существует',
            'stuff.*.email.email'               => 'Поле Email должно быть валидным адресом электронной почты',
            'stuff.*.insurance_number.required' => 'Поле СНИЛС должно быть заполнено',
            'stuff.*.insurance_number.regex'    => 'СНИЛС должен соответствовать формату 000-000-000 00',
            'stuff.*.insurance_number.exists'   => 'Сотрудника с таким СНИЛС не существует',
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
            'type_id'       => 'required|exists:Modules\GReqSys\Models\ReqType,id',
            'city_id'       => 'required|exists:Modules\Gaz\Models\City,id',
            'department_id' => 'required|exists:Modules\Gaz\Models\Department,id',
            'stuff'         => 'required|array|min:1',

            'stuff.*.first_name'        => 'required',
            'stuff.*.last_name'         => 'required',
            'stuff.*.second_name'       => 'required',
            'stuff.*.emp_number'        => 'bail|required|regex:/^\d{6}$/|exists:Modules\Gaz\Models\Stuff,emp_number',
            'stuff.*.email'             => 'bail|required|email|exists:Modules\Gaz\Models\Stuff,email',
            'stuff.*.insurance_number'  => 'bail|required|regex:/^\d{3}-\d{3}-\d{3}\s\d{2}$/|exists:Modules\Gaz\Models\Stuff,insurance_number',
        ];
    }
}
