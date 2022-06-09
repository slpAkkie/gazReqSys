<?php

namespace Modules\Gaz\Seeders;

use Illuminate\Database\Seeder;
use Modules\Gaz\Seeders\CitySeeder as SeedersCitySeeder;

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
            SeedersCitySeeder::class,
            DepartmentSeeder::class,
            PostSeeder::class,
            StuffSeeder::class,
            StuffHistorySeeder::class,
        ]);
    }
}
