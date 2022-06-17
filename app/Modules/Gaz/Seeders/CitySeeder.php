<?php

namespace Modules\Gaz\Seeders;

use Illuminate\Database\Seeder;
use Modules\Gaz\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Строки для вставки
     *
     * @var array
     */
    protected $rows = [
        [ 'title' => 'Москва' ],
        [ 'title' => 'Ярославль' ],
        [ 'title' => 'Ликино-Дулево' ],
        [ 'title' => 'Курган' ],
        [ 'title' => 'Нижний Новгород' ],
        [ 'title' => 'Канаш' ],
        [ 'title' => 'Ульяновск' ],
        [ 'title' => 'Саранск' ],
        [ 'title' => 'Чебоксары' ],
    ];

    /**
     * Заполнение таблицы
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->rows as $r)
            (new City($r))->save();
    }
}
