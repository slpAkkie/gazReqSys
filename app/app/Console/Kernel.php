<?php

namespace App\Console;

use App\Console\Commands\DatabaseInit;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\Gaz\Commands\GazDatabaseInit;
use Modules\GReqSys\Commands\GReqSysDatabaseInit;
use Modules\GWT\Commands\GWTDatabaseInit;

class Kernel extends ConsoleKernel
{
    /**
     * Пользовательские команды для Artisan
     *
     * @var array
     */
    protected $commands = [
        GazDatabaseInit::class,
        GReqSysDatabaseInit::class,
        GWTDatabaseInit::class,

        DatabaseInit::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
