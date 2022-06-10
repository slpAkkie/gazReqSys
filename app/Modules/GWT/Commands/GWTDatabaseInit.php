<?php

namespace Modules\GWT\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class GWTDatabaseInit extends Command
{
    /**
     * Название и сигнатура команды
     *
     * @var string
     */
    protected $signature = 'gwt:db';

    /**
     * Описание команды
     *
     * @var string
     */
    protected $description = 'Создать таблицы в БД GWT и заполнить данными';

    /**
     * Выполнение команды
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Создание таблиц для БД GWT');
        $migrateInt = Artisan::call('migrate', [
            '--path' => 'Modules/GWT/Migrations',
        ]);

        if ($migrateInt) {
            $this->error('Ошибка при создании таблиц для БД GWT');
            return $migrateInt;
        }


        $this->info('Загрузка данных в БД GWT');
        $seedInt = Artisan::call('db:seed', [
            '--class' => '\\Modules\\GWT\\Seeders\\DatabaseSeeder',
        ]);

        if ($seedInt) {
            $this->error('Ошибка при загрузке данных в БД GWT');
            return $seedInt;
        }


        return 0;
    }
}
