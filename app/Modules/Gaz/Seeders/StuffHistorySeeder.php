<?php

namespace Modules\Gaz\Seeders;

use Illuminate\Database\Seeder;
use Modules\Gaz\Models\StuffHistory;

class StuffHistorySeeder extends Seeder
{
    /**
     * Строки для вставки
     *
     * @var array
     */
    protected $rows = [
        [
            'stuff_id' => 1,
            'hired_at' => '2022.04.11',
            'post_id' => 1,
            'department_id' => 4,
        ],
        [
            'stuff_id' => 2,
            'post_id' => 1,
            'department_id' => 4,
        ],
        [
            'stuff_id' => 3,
            'post_id' => 1,
            'department_id' => 4,
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
            (new StuffHistory($r))->save();
    }
}
