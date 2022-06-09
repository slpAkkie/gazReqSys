<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'Вы должны принять :attribute.',
    'accepted_if'          => ':attribute должно быть принято, когда :other соответствует :value.',
    'active_url'           => ':attribute содержит недействительный URL.',
    'after'                => 'В поле :attribute должна быть дата больше :date.',
    'after_or_equal'       => 'В поле :attribute должна быть дата больше или равняться :date.',
    'alpha'                => ':attribute может содержать только буквы.',
    'alpha_dash'           => ':attribute может содержать только буквы, цифры, дефис и нижнее подчеркивание.',
    'alpha_num'            => ':attribute может содержать только буквы и цифры.',
    'array'                => ':attribute должно быть массивом.',
    'attached'             => ':attribute уже прикреплено.',
    'before'               => 'В поле :attribute должна быть дата раньше :date.',
    'before_or_equal'      => 'В поле :attribute должна быть дата раньше или равняться :date.',
    'between'              => [
        'array'   => 'Количество элементов в поле :attribute должно быть между :min и :max.',
        'file'    => 'Размер файла в поле :attribute должен быть между :min и :max Килобайт(а).',
        'numeric' => ':attribute должно быть между :min и :max.',
        'string'  => 'Количество символов в поле :attribute должно быть между :min и :max.',
    ],
    'boolean'              => ':attribute должно иметь значение логического типа.',
    'confirmed'            => ':attribute не совпадает с подтверждением.',
    'current_password'     => ':attribute содержит некорректный пароль.',
    'date'                 => ':attribute не является датой.',
    'date_equals'          => ':attribute должно быть датой равной :date.',
    'date_format'          => ':attribute не соответствует формату :format.',
    'different'            => ':attribute и :other должны различаться.',
    'digits'               => 'Длина цифрового поля :attribute должна быть :digits.',
    'digits_between'       => 'Длина цифрового поля :attribute должна быть между :min и :max.',
    'dimensions'           => ':attribute имеет недопустимые размеры изображения.',
    'distinct'             => ':attribute содержит повторяющееся значение.',
    'email'                => ':attribute должно быть действительным электронным адресом.',
    'ends_with'            => ':attribute должно заканчиваться одним из следующих значений: :values',
    'exists'               => 'Выбранное значение для :attribute некорректно.',
    'file'                 => ':attribute должно быть файлом.',
    'filled'               => ':attribute обязательно для заполнения.',
    'gt'                   => [
        'array'   => 'Количество элементов в поле :attribute должно быть больше :value.',
        'file'    => 'Размер файла в поле :attribute должен быть больше :value Килобайт(а).',
        'numeric' => ':attribute должно быть больше :value.',
        'string'  => 'Количество символов в поле :attribute должно быть больше :value.',
    ],
    'gte'                  => [
        'array'   => 'Количество элементов в поле :attribute должно быть :value или больше.',
        'file'    => 'Размер файла в поле :attribute должен быть :value Килобайт(а) или больше.',
        'numeric' => ':attribute должно быть :value или больше.',
        'string'  => 'Количество символов в поле :attribute должно быть :value или больше.',
    ],
    'image'                => ':attribute должно быть изображением.',
    'in'                   => 'Выбранное значение для :attribute ошибочно.',
    'in_array'             => ':attribute не существует в :other.',
    'integer'              => ':attribute должно быть целым числом.',
    'ip'                   => ':attribute должно быть действительным IP-адресом.',
    'ipv4'                 => ':attribute должно быть действительным IPv4-адресом.',
    'ipv6'                 => ':attribute должно быть действительным IPv6-адресом.',
    'json'                 => ':attribute должно быть JSON строкой.',
    'lt'                   => [
        'array'   => 'Количество элементов в поле :attribute должно быть меньше :value.',
        'file'    => 'Размер файла в поле :attribute должен быть меньше :value Килобайт(а).',
        'numeric' => ':attribute должно быть меньше :value.',
        'string'  => 'Количество символов в поле :attribute должно быть меньше :value.',
    ],
    'lte'                  => [
        'array'   => 'Количество элементов в поле :attribute должно быть :value или меньше.',
        'file'    => 'Размер файла в поле :attribute должен быть :value Килобайт(а) или меньше.',
        'numeric' => ':attribute должно быть :value или меньше.',
        'string'  => 'Количество символов в поле :attribute должно быть :value или меньше.',
    ],
    'max'                  => [
        'array'   => 'Количество элементов в поле :attribute не может превышать :max.',
        'file'    => 'Размер файла в поле :attribute не может быть больше :max Килобайт(а).',
        'numeric' => ':attribute не может быть больше :max.',
        'string'  => 'Количество символов в поле :attribute не может превышать :max.',
    ],
    'mimes'                => ':attribute должно быть файлом одного из следующих типов: :values.',
    'mimetypes'            => ':attribute должно быть файлом одного из следующих типов: :values.',
    'min'                  => [
        'array'   => 'Количество элементов в поле :attribute должно быть не меньше :min.',
        'file'    => 'Размер файла в поле :attribute должен быть не меньше :min Килобайт(а).',
        'numeric' => ':attribute должно быть не меньше :min.',
        'string'  => 'Количество символов в поле :attribute должно быть не меньше :min.',
    ],
    'multiple_of'          => 'Значение поля :attribute должно быть кратным :value',
    'not_in'               => 'Выбранное значение для :attribute ошибочно.',
    'not_regex'            => 'Выбранный формат для :attribute ошибочный.',
    'numeric'              => ':attribute должно быть числом.',
    'password'             => 'Неверный пароль.',
    'present'              => ':attribute должно присутствовать.',
    'prohibited'           => ':attribute запрещено.',
    'prohibited_if'        => ':attribute запрещено, когда :other равно :value.',
    'prohibited_unless'    => ':attribute запрещено, если :other не входит в :values.',
    'prohibits'            => ':attribute запрещает присутствие :other.',
    'regex'                => ':attribute имеет ошибочный формат.',
    'relatable'            => ':attribute не может быть связано с этим ресурсом.',
    'required'             => ':attribute обязательно для заполнения.',
    'required_if'          => ':attribute обязательно для заполнения, когда :other равно :value.',
    'required_unless'      => ':attribute обязательно для заполнения, когда :other не равно :values.',
    'required_with'        => ':attribute обязательно для заполнения, когда :values указано.',
    'required_with_all'    => ':attribute обязательно для заполнения, когда :values указано.',
    'required_without'     => ':attribute обязательно для заполнения, когда :values не указано.',
    'required_without_all' => ':attribute обязательно для заполнения, когда ни одно из :values не указано.',
    'same'                 => 'Значения полей :attribute и :other должны совпадать.',
    'size'                 => [
        'array'   => 'Количество элементов в поле :attribute должно быть равным :size.',
        'file'    => 'Размер файла в поле :attribute должен быть равен :size Килобайт(а).',
        'numeric' => ':attribute должно быть равным :size.',
        'string'  => 'Количество символов в поле :attribute должно быть равным :size.',
    ],
    'starts_with'          => ':attribute должно начинаться из одного из следующих значений: :values',
    'string'               => ':attribute должно быть строкой.',
    'timezone'             => ':attribute должно быть действительным часовым поясом.',
    'unique'               => 'Такое значение поля :attribute уже существует.',
    'uploaded'             => 'Загрузка поля :attribute не удалась.',
    'url'                  => ':attribute имеет ошибочный формат URL.',
    'uuid'                 => ':attribute должно быть корректным UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'address'               => 'Адрес',
        'age'                   => 'Возраст',
        'available'             => 'Доступно',
        'city'                  => 'Город',
        'content'               => 'Контент',
        'country'               => 'Страна',
        'current_password'      => 'Текущий пароль',
        'date'                  => 'Дата',
        'day'                   => 'День',
        'description'           => 'Описание',
        'email'                 => 'E-Mail адрес',
        'excerpt'               => 'Выдержка',
        'first_name'            => 'Имя',
        'gender'                => 'Пол',
        'hour'                  => 'Час',
        'last_name'             => 'Фамилия',
        'login'                 => 'Логин',
        'minute'                => 'Минута',
        'mobile'                => 'Моб. номер',
        'month'                 => 'Месяц',
        'name'                  => 'Имя',
        'password'              => 'Пароль',
        'password_confirmation' => 'Подтверждение пароля',
        'phone'                 => 'Телефон',
        'phone_number'          => 'Номер телефона',
        'second'                => 'Секунда',
        'second_name'           => 'Отчество',
        'sex'                   => 'Пол',
        'size'                  => 'Размер',
        'time'                  => 'Время',
        'title'                 => 'Наименование',
        'username'              => 'Никнейм',
        'year'                  => 'Год',
    ],

];
