<?php

namespace Modules\ReqSys\Seeders;

use Illuminate\Database\Seeder;
use Modules\ReqSys\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Строки для вставки
     *
     * @var array
     */
    public static $rows = [
        [
            'login' => 'root',
            'staff_id' => 1,
            'password' => 'root'
        ],
        [
            'login' => 'root2',
            'staff_id' => 2,
            'password' => 'root'
        ],
        [
            'login' => 'root3',
            'staff_id' => 3,
            'password' => 'root'
        ],
    ];

    /**
     * Заполнение таблицы
     *
     * @return void
     */
    public function run()
    {
        foreach (self::$rows as $r) {
            $user = new User($r);
            $user->admin = true;
            $user->save();
        }
    }
}
