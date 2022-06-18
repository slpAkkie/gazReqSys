<?php

namespace Modules\ReqSys\Seeders;

use Illuminate\Database\Seeder;
use Modules\ReqSys\Models\ReqStatus;

class ReqStatusSeeder extends Seeder
{
    /**
     * Строки для вставки
     *
     * @var array
     */
    public static $rows = [
        [ 'slug' => 'waiting', 'title' => 'На рассмотрении' ],
        [ 'slug' => 'confirmed', 'title' => 'Подтверждена' ],
        [ 'slug' => 'denied', 'title' => 'Отклонена' ],
    ];

    /**
     * Заполнение таблицы
     *
     * @return void
     */
    public function run()
    {
        foreach (self::$rows as $r)
            (new ReqStatus($r))->save();
    }
}
