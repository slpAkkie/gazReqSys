<?php

namespace Modules\GReqSys\Seeders;

use Illuminate\Database\Seeder;
use Modules\GReqSys\Models\InvolvedStaff;

class InvolvedStaffSeeder extends Seeder
{
    /**
     * Строки для вставки
     *
     * @var array
     */
    protected $rows = [
        //
    ];

    /**
     * Заполнение таблицы
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->rows as $r)
            (new InvolvedStaff($r))->save();
    }
}
