<?php

namespace Modules\WT\Seeders;

use Illuminate\Database\Seeder;
use Modules\WT\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Строки для вставки
     *
     * @var array
     */
    public static $rows = [
        [ 'title' => 'C# для новичков', 'description' => 'Изучение основ C# для самых маленьких' ],
        [ 'title' => 'Контруирование кузовов', 'description' => 'Изучение основ по конструированию кузовов легковых и грузовых автомобилей' ],
        [ 'title' => 'Управление персоналом', 'description' => 'Курс для начальников отдела, о том, как правильно руководить персоналом' ],
    ];

    /**
     * Заполнение таблицы
     *
     * @return void
     */
    public function run()
    {
        foreach (self::$rows as $r)
            (new Course($r))->save();
    }
}
