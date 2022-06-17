<?php

namespace Modules\WT\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class GWTDatabaseInit extends Command
{
    /**
     * Название и сигнатура команды
     *
     * @var string
     */
    protected $signature = 'wt:db';

    /**
     * Описание команды
     *
     * @var string
     */
    protected $description = 'Создать таблицы в БД WT и заполнить данными';

    /**
     * Выполнение команды
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Создание таблиц для БД WT');
        $migrateInt = Artisan::call('migrate', [
            '--path' => 'Modules/WT/Migrations',
        ]);

        if ($migrateInt) {
            $this->error('Ошибка при создании таблиц для БД WT');
            return $migrateInt;
        }


        $this->info('Загрузка данных в БД WT');
        $seedInt = Artisan::call('db:seed', [
            '--class' => '\\Modules\\WT\\Seeders\\DatabaseSeeder',
        ]);

        if ($seedInt) {
            $this->error('Ошибка при загрузке данных в БД WT');
            return $seedInt;
        }

        $this->info('Загрузка данных в БД WT завершена');

        return 0;
    }
}
