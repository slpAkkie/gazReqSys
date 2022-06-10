<?php

namespace Modules\GWT\Seeders;

use Illuminate\Database\Seeder;
use Modules\GWT\Models\UserCourse;

class UserCourseSeeder extends Seeder
{
    /**
     * Строки для вставки
     *
     * @var array
     */
    protected $rows = [
        [ 'user_id' => 1, 'course_id' => 1 ],
    ];

    /**
     * Заполнение таблицы
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->rows as $r)
            (new UserCourse($r))->save();
    }
}
