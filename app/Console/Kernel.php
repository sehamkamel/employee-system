<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
protected function schedule(Schedule $schedule)
{
    $schedule->command('attendance:mark-absent')
        ->dailyAt('11:01')
        ->timezone('Africa/Cairo')
        ->withoutOverlapping()
        ->appendOutputTo(storage_path('logs/attendance-schedule.log'));
}


    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
