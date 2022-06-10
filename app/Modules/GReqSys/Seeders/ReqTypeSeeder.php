<?php

namespace Modules\GReqSys\Seeders;

use Illuminate\Database\Seeder;
use Modules\GReqSys\Models\ReqType;

class ReqTypeSeeder extends Seeder
{
    /**
     * Строки для вставки
     *
     * @var array
     */
    protected $rows = [
        [ 'title' => 'ИС WebTutor: создать аккаунт для сотрудника' ],
        [ 'title' => 'ИС WebTutor: деактивировать аккаунты' ],
        [ 'title' => 'Сотрудники: увольнение' ],
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
