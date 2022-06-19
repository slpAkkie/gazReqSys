<?php

namespace Modules\Gaz\Seeders;

use Illuminate\Database\Seeder;
use Modules\Gaz\Models\Organization;

class OrganizationSeeder extends Seeder
{
    /**
     * Строки для вставки
     *
     * @var array
     */
    public static $rows = [
        [ 'title' => 'Ликинский автобусный завод', 'city_id' => 3 ],
        [ 'title' => 'Ярославский моторный завод', 'city_id' => 2 ],
        [ 'title' => 'Ярославский завод дизельной аппаратуры', 'city_id' => 2 ],
        [ 'title' => 'Горьковский автомобильный завод', 'city_id' => 5 ],
        [ 'title' => 'Павловский автобусный завод', 'city_id' => 5 ],
        [ 'title' => 'Завод штампов и пресс-форм "Нижегородские моторы"', 'city_id' => 5 ],
        [ 'title' => 'Курганский автобусный завод', 'city_id' => 4 ],
        [ 'title' => 'Ульяновский автобусный завод', 'city_id' => 7 ],
        [ 'title' => 'Саранский завод автосамосвалов', 'city_id' => 8 ],
        [ 'title' => 'Канашский автоагрегатный завод', 'city_id' => 9 ],
    ];

    public static $common = [
        'ГАЗ-IT сервис',
        'Консалтинговый центр',
        'Управляющая компания',
        'Объединенный инженерный центр',
    ];

    /**
     * Заполнение таблицы
     *
     * @return void
     */
    public function run()
    {
        foreach (self::$rows as $r)
            (new Organization($r))->save();

        for ($i = 1; $i <= count(CitySeeder::$rows); $i++)
            foreach (self::$common as $r)
                (new Organization([
                    'title' => $r,
                    'city_id' => $i,
                ]))->save();
    }
}
