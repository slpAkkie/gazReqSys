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
    public static $rows = [
        [
            'staff_id' => 1,
            'post_id' => 1,
            'organization_id' => 27,
        ],
        [
            'staff_id' => 2,
            'post_id' => 1,
            'organization_id' => 27,
        ],
        [
            'staff_id' => 3,
            'post_id' => 1,
            'organization_id' => 27,
        ],
        [
            'staff_id' => 4,
            'post_id' => 2,
            'organization_id' => 27,
        ],
        [
            'staff_id' => 5,
            'post_id' => 2,
            'organization_id' => 27,
        ],
        [
            'staff_id' => 6,
            'post_id' => 3,
            'organization_id' => 27,
        ],
        [
            'staff_id' => 7,
            'post_id' => 2,
            'organization_id' => 27,
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
            (new StaffHistory($r))->save();
    }
}
