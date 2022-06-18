<?php

namespace Modules\Gaz\Seeders;

use Illuminate\Database\Seeder;
use Modules\Gaz\Models\Organization;
use Modules\Gaz\Models\Post;
use Modules\Gaz\Models\Staff;
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

        for ($i = 4; $i <= Staff::orderBy('id', 'DESC')->first()->id; $i++) {
            $notTrashed = 1;
            do {
                $notTrashed = !rand(0, 2);

                $f = StaffHistory::factory();
                if (!$notTrashed) $f = $f->trashed();

                $f->make([
                    'staff_id' => $i,
                    'post_id' => Post::inRandomOrder()->first()->id,
                    'organization_id' => Organization::inRandomOrder()->first()->id,
                ])->save();
            } while (!$notTrashed) ;
        }
    }
}
