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
        [ 'title' => 'Московская область' ],
        [ 'title' => 'Ярославская область' ],
        [ 'title' => 'Нижегородская область' ],
        [ 'title' => 'Курганская область' ],
        [ 'title' => 'Ульяновская область' ],
        [ 'title' => 'Республика Мордовия' ],
        [ 'title' => 'Республика Чувашия' ],
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
