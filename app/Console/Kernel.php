<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//         $schedule->command('inspire')->hourly();
        $schedule->command('export:order')->dailyAt('17:00');
        $schedule->command('export:order')->dailyAt('17:30');
        $schedule->command('export:order')->dailyAt('18:00');


//        $schedule->command('import:all')->dailyAt('23:00');
        $schedule->command('generate:report')->dailyAt('23:10');
        $schedule->command('plan:init')->dailyAt('23:15');
        $schedule->command('plan:calk')->everyTenMinutes();

        $schedule->command('db:backup')->dailyAt('02:00');
        $schedule->command('telescope:clear')->dailyAt('03:00');
        $schedule->command('order:delivery')->dailyAt('05:00');


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
