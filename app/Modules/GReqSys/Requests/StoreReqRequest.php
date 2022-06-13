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
            'staff.required'            => 'Список Сотрудников должен быть заполнен',
            'staff.array'               => 'Список сотрудников должен быть массивом',
            'staff.min'                 => 'Список сотрудников должен содержать хотя бы одну запись',

            'staff.*.first_name.required'       => 'Поле Имя сотрудника должно быть заполнено',
            'staff.*.last_name.required'        => 'Поле Фамилия сотрудника должно быть заполнено',
            'staff.*.second_name.required'      => 'Поле Отчество должно быть заполнено',
            'staff.*.emp_number.required'       => 'Поле Табельный номер должно быть заполнено',
            'staff.*.emp_number.regex'          => 'Табельный номер должен состоять из 6 цифр',
            'staff.*.email.required'            => 'Поле Email должно быть заполнено',
            'staff.*.email.email'               => 'Поле Email должно быть валидным адресом электронной почты',
            'staff.*.insurance_number.required' => 'Поле СНИЛС должно быть заполнено',
            'staff.*.insurance_number.regex'    => 'СНИЛС должен соответствовать формату 000-000-000 00',
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
            'staff'         => 'required|array|min:1',

            'staff.*.first_name'        => 'required',
            'staff.*.last_name'         => 'required',
            'staff.*.second_name'       => 'required',
            'staff.*.emp_number'        => 'bail|required|regex:/^\d{6}$/',
            'staff.*.email'             => 'bail|required|email',
            'staff.*.insurance_number'  => 'bail|required|regex:/^\d{3}-\d{3}-\d{3}\s\d{2}$/',
        ];
    }
}
