<?php

namespace Modules\Gaz\Seeders;

use Illuminate\Database\Seeder;
use Modules\Gaz\Models\StaffHistory;

class StaffHistorySeeder extends Seeder
{
    /**
     * Строки для вставки
     *
     * @var array
     */
    protected $rows = [
        [
            'staff_id' => 1,
            'post_id' => 1,
            'department_id' => 4,
        ],
        [
            'staff_id' => 2,
            'post_id' => 1,
            'department_id' => 4,
        ],
        [
            'staff_id' => 3,
            'post_id' => 1,
            'department_id' => 4,
        ],
        [
            'staff_id' => 4,
            'post_id' => 2,
            'department_id' => 4,
        ],
        [
            'staff_id' => 5,
            'post_id' => 2,
            'department_id' => 4,
        ],
        [
            'staff_id' => 6,
            'post_id' => 3,
            'department_id' => 4,
        ],
        [
            'staff_id' => 7,
            'post_id' => 2,
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
            (new StaffHistory($r))->save();
    }
}
