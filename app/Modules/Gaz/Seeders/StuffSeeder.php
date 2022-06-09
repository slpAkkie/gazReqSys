<?php

namespace Modules\Gaz\Seeders;

use Illuminate\Database\Seeder;
use Modules\Gaz\Models\Stuff;

class StuffSeeder extends Seeder
{
    /**
     * Строки для вставки
     *
     * @var array
     */
    protected $rows = [
        [
            'last_name'         => 'Шаманин',
            'first_name'        => 'Александр',
            'second_name'       => 'Сергеевич',
            'emp_number'        => '000000',
            'email'             => 'slpgservice@gmail.com',
            'insurance_number'  => '000-000-000 00',
        ],
        [
            'last_name'         => 'Дрягин',
            'first_name'        => 'Евгений',
            'second_name'       => 'Анатольевич',
            'emp_number'        => '111111',
            'email'             => 'dryagin.zhenia@yandex.ru',
            'insurance_number'  => '111-111-111 11',
        ],
        [
            'last_name'         => 'Трешина',
            'first_name'        => 'Вероника',
            'second_name'       => 'Сергеевна',
            'emp_number'        => '222222',
            'email'             => 'bekkerveronica@yandex.ru',
            'insurance_number'  => '222-222-222 22',
        ],
    ];

    /**
     * Заполнение таблицы
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->rows as $r)
            (new Stuff($r))->save();
    }
}
