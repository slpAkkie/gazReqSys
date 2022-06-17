<?php

namespace Modules\ReqSys\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\ReqSys\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Строки для вставки
     *
     * @var array
     */
    protected $rows = [
        [
            'login' => 'root',
            'gaz_staff_id' => 1,
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
        foreach ($this->rows as $r) {
            $user = User::new($r);
            $user->password_salt = Str::random(255);
            $user->save();
        }
    }
}
