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
    protected $rows = [
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
        foreach ($this->rows as $r)
            (new ReqType($r))->save();
    }
}
