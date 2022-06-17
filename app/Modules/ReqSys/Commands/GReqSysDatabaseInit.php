<?php

namespace Modules\ReqSys\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class GReqSysDatabaseInit extends Command
{
    /**
     * Название и сигнатура команды
     *
     * @var string
     */
    protected $signature = 'reqsys:db';

    /**
     * Описание команды
     *
     * @var string
     */
    protected $description = 'Создать таблицы в БД ReqSys и заполнить данными';

    /**
     * Выполнение команды
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Создание таблиц для БД ReqSys');
        $migrateInt = Artisan::call('migrate', [
            '--path' => 'Modules/ReqSys/Migrations',
        ]);

        if ($migrateInt) {
            $this->error('Ошибка при создании таблиц для БД ReqSys');
            return $migrateInt;
        }


        $this->info('Загрузка данных в БД ReqSys');
        $seedInt = Artisan::call('db:seed', [
            '--class' => '\\Modules\\ReqSys\\Seeders\\DatabaseSeeder',
        ]);

        if ($seedInt) {
            $this->error('Ошибка при загрузке данных в БД ReqSys');
            return $seedInt;
        }

        $this->info('Загрузка данных в БД ReqSys завершена');

        return 0;
    }
}
