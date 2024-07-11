<?php

namespace App\Console;

use App\Jobs\CalculateDailyRecord;
use App\Jobs\PopulateRandomUser;
use App\Repositories\DataRepository;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new PopulateRandomUser())
            ->everyMinute();

        $schedule->job(new CalculateDailyRecord())
            ->everyTenMinutes();
            // ->daily();
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
