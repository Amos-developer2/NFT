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
        $schedule->command('nft:update-daily-profit')->daily();
        // Schedule auction processing every minute
        $schedule->command('auctions:process-ended')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
        // Register commands explicitly if needed
        $this->commands([
            \App\Console\Commands\ProcessEndedAuctions::class,
        ]);
    }
}
