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
//        $schedule->command('export:order')->dailyAt('17:00');
//        $schedule->command('export:order')->dailyAt('17:30');
//        $schedule->command('export:order')->dailyAt('18:00');
//        $schedule->command('import:all')->dailyAt('23:00');

        $schedule->command('db:backup')->dailyAt('02:00');
        $schedule->command('telescope:clear')->dailyAt('03:00');
        $schedule->command('order:delivery')->dailyAt('05:00');

        $schedule->command('store:report')->dailyAt('17:00');
        $schedule->command('order:report')->dailyAt('17:05');
        $schedule->command('order:report-return')->dailyAt('17:10');

        $schedule->command('store:report')->dailyAt('17:30');
        $schedule->command('order:report')->dailyAt('17:35');
        $schedule->command('order:report-return')->dailyAt('17:40');

        $schedule->command('store:report')->dailyAt('18:00');
        $schedule->command('order:report')->dailyAt('18:05');
        $schedule->command('order:report-return')->dailyAt('18:10');





        $schedule->command('plan:init')->everyFourHours();
        $schedule->command('plan:calk')->everyTenMinutes();



    }

    /*
        StoreRepord
        generepord Repord
        generepord Repord Rutenr


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
