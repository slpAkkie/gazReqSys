<?php

namespace Modules\Gaz\Seeders;

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
            CitySeeder::class,
            DepartmentSeeder::class,
            PostSeeder::class,
            StaffSeeder::class,
            StaffHistorySeeder::class,
        ]);
    }
}
