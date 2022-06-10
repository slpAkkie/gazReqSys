<?php

namespace Modules\GReqSys\Seeders;

use Illuminate\Database\Seeder;
use Modules\GReqSys\Models\Req;

class ReqSeeder extends Seeder
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
            (new Req($r))->save();
    }
}
