<?php

namespace Modules\Gaz\Seeders;

use Illuminate\Database\Seeder;
use Modules\Gaz\Models\Staff;
use Modules\ReqSys\Models\User;

class StaffSeeder extends Seeder
{
    /**
     * Строки для вставки
     *
     * @var array
     */
    public static $rows = [
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
            'manager_id'        => 1,
            'email'             => 'dryagin.zhenia@yandex.ru',
            'insurance_number'  => '111-111-111 11',
        ],
        [
            'last_name'         => 'Трешина',
            'first_name'        => 'Вероника',
            'second_name'       => 'Сергеевна',
            'emp_number'        => '222222',
            'manager_id'        => 1,
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
        foreach (self::$rows as $r)
            (new Staff($r))->save();

        for ($i = 1; $i <= 47; $i++) {
            $f = Staff::factory();
            if (!rand(0, 8)) $f = $f->trashed();

            ($s = $f->make([
                'manager_id' => ($user = Staff::inRandomOrder()->first()) ? $user->id : 1,
            ]))->save();

            (new User([
                'login' => 'root'.$i + 3,
                'staff_id' => $i + 3,
                'password' => 'root'
            ]))->save();
        }
    }
}
