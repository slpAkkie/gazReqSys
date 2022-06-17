<?php

namespace Modules\ReqSys\Seeders;

use Illuminate\Database\Seeder;

/**
 * Класс для заполнения всех таблиц для БД Gaz
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Заполнение таблиц
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ReqTypeSeeder::class,
            ReqSeeder::class,
            ReqSeeder::class,
            ReqStaffSeeder::class,
        ]);
    }
}
