<?php

namespace App\Console;

use App\Jobs\CalculateDailyRecord;
use App\Jobs\PopulateRandomUser;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedulerRandomuser = $schedule->job(new PopulateRandomUser());
        $schedulerCalculateDaily = $schedule->job(new CalculateDailyRecord());

        if (config('app.env')=='local') {
            $schedulerRandomuser->everyMinute();
            $schedulerCalculateDaily->everyFiveMinutes();
        } else {
            $schedulerRandomuser->hourly();
            $schedulerCalculateDaily->daily();
        }
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
