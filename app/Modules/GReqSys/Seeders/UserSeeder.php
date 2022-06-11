<?php

namespace Modules\GReqSys\Seeders;

use Illuminate\Database\Seeder;
use Modules\GReqSys\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Строки для вставки
     *
     * @var array
     */
    protected $rows = [
        [ 'login' => 'root', 'gaz_stuff_id' => 1, 'password' => 'root' ],
    ];

    /**
     * Заполнение таблицы
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->rows as $r)
            (new User($r))->save();
    }
}