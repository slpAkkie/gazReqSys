<?php

namespace Modules\Gaz\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class GazDatabaseInit extends Command
{
    /**
     * Название и сигнатура команды
     *
     * @var string
     */
    protected $signature = 'gaz:db';

    /**
     * Описание команды
     *
     * @var string
     */
    protected $description = 'Создать таблицы в БД Gaz и заполнить данными';

    /**
     * Выполнение команды
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Создание таблиц для БД Gaz');
        $migrateInt = Artisan::call('migrate', [
            '--path' => 'Modules/Gaz/Migrations',
        ]);

        if ($migrateInt) {
            $this->error('Ошибка при создании таблиц для БД Gaz');
            return $migrateInt;
        }


        $this->info('Загрузка данных в БД Gaz');
        $seedInt = Artisan::call('db:seed', [
            '--class' => '\\Modules\\Gaz\\Seeders\\DatabaseSeeder',
        ]);

        if ($seedInt) {
            $this->error('Ошибка при загрузке данных в БД Gaz');
            return $seedInt;
        }


        return 0;
    }
}
