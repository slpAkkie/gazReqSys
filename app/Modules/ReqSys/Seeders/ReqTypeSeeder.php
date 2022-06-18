<?php

namespace Modules\ReqSys\Seeders;

use Illuminate\Database\Seeder;
use Modules\ReqSys\Models\ReqType;

class ReqTypeSeeder extends Seeder
{
    /**
     * Строки для вставки
     *
     * @var array
     */
    public static $rows = [
        [ 'title' => 'ИС WebTutor: Создать аккаунт для сотрудника' ],
        [ 'title' => 'ИС WebTutor: Деактивировать аккаунты' ],
        [ 'title' => 'Сотрудники: Деактивация учетной записи' ],
    ];

    /**
     * Заполнение таблицы
     *
     * @return void
     */
    public function run()
    {
        foreach (self::$rows as $r)
            (new ReqType($r))->save();
    }
}
