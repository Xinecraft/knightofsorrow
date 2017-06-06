<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\CalculatePlayerTotalCommand::class,
        \App\Console\Commands\BakeBracketCommand::class,
        \App\Console\Commands\CheckBansCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('calculate:player-total')->hourly();
        $schedule->command('check:bans')->everyTenMinutes();
        $schedule->exec('rm -r /var/lib/mysql-files/*')->daily();
        //$schedule->command('bake:roundrobin')->everyTenMinutes();
    }
}
