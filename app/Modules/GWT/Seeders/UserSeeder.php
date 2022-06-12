<?php

namespace Modules\GWT\Seeders;

use Illuminate\Database\Seeder;
use Modules\GWT\Models\User;

class UserSeeder extends Seeder
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
            'login'             => 'root',
            'email'             => 'slpgservice@gmail.com',
            'insurance_number'  => '000-000-000 00',
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
            (User::new($r))->save();
    }
}
