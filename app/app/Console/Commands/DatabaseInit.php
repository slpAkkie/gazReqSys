<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DatabaseInit extends Command
{
    /**
     * Название и сигнатура команды
     *
     * @var string
     */
    protected $signature = 'db:init';

    /**
     * Описание команды
     *
     * @var string
     */
    protected $description = 'Создание и заполнение таблиц всех баз данных';

    /**
     * Выполнение команды
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Создание и заполнение таблиц баз данных');

        Artisan::call('gaz:db');
        Artisan::call('reqsys:db');
        Artisan::call('wt:db');
        Artisan::call('migrate');

        $this->info('Создание и заполнение баз данных завершено');

        return 0;
    }
}
