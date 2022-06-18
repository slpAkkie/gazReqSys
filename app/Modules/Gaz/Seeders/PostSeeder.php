<?php

namespace Modules\Gaz\Seeders;

use Illuminate\Database\Seeder;
use Modules\Gaz\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Строки для вставки
     *
     * @var array
     */
    public static $rows = [
        [ 'title' => 'Инженер-программист' ],
        [ 'title' => 'Системный администратоа' ],
        [ 'title' => 'Начальник отдела' ],
        [ 'title' => 'Руководитель отдела' ],
        [ 'title' => 'Администратор' ],
        [ 'title' => 'HR' ],
        [ 'title' => 'Инженер' ],
        [ 'title' => 'Слесарь' ],
        [ 'title' => 'Бухгалтер' ],
    ];

    /**
     * Заполнение таблицы
     *
     * @return void
     */
    public function run()
    {
        foreach (self::$rows as $r)
            (new Post($r))->save();
    }
}
