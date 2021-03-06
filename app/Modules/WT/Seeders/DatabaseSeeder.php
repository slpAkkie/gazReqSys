<?php

namespace Modules\WT\Seeders;

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
            CourseSeeder::class,
            UserCourseSeeder::class,
        ]);
    }
}
