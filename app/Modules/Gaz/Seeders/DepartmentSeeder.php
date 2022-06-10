<?php

namespace Modules\Gaz\Seeders;

use Illuminate\Database\Seeder;
use Modules\Gaz\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Строки для вставки
     *
     * @var array
     */
    protected $rows = [
        [ 'title' => 'Ликинский автобусный завод', 'city_id' => 1 ],
        [ 'title' => 'Ярославский моторный завод', 'city_id' => 2 ],
        [ 'title' => 'Ярославский завод дизельной аппаратуры', 'city_id' => 2 ],
        [ 'title' => 'Горьковский автомобильный завод', 'city_id' => 3 ],
        [ 'title' => 'Павловский автобусный завод', 'city_id' => 3 ],
        [ 'title' => 'Завод штампов и пресс-форм "Нижегородские моторы"', 'city_id' => 3 ],
        [ 'title' => 'Курганский автобусный завод', 'city_id' => 4 ],
        [ 'title' => 'Ульяновский автобусный завод', 'city_id' => 5 ],
        [ 'title' => 'Саранский завод автосамосвалов', 'city_id' => 6 ],
        [ 'title' => 'Канашский автоагрегатный завод', 'city_id' => 7 ],
    ];

    /**
     * Заполнение таблицы
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->rows as $r)
            (new Department($r))->save();
    }
}
