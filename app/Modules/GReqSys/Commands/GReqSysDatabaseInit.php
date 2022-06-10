<?php

namespace Modules\GReqSys\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class GReqSysDatabaseInit extends Command
{
    /**
     * Название и сигнатура команды
     *
     * @var string
     */
    protected $signature = 'greqsys:db';

    /**
     * Описание команды
     *
     * @var string
     */
    protected $description = 'Создать таблицы в БД GReqSys и заполнить данными';

    /**
     * Выполнение команды
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Создание таблиц для БД GReqSys');
        $migrateInt = Artisan::call('migrate', [
            '--path' => 'Modules/GReqSys/Migrations',
        ]);

        if ($migrateInt) {
            $this->error('Ошибка при создании таблиц для БД GReqSys');
            return $migrateInt;
        }


        $this->info('Загрузка данных в БД GReqSys');
        $seedInt = Artisan::call('db:seed', [
            '--class' => '\\Modules\\GReqSys\\Seeders\\DatabaseSeeder',
        ]);

        if ($seedInt) {
            $this->error('Ошибка при загрузке данных в БД GReqSys');
            return $seedInt;
        }


        return 0;
    }
}
