<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('inventory:calculate-ending')->monthlyOn($this->lastDayOfMonth(), '23:59');
        $schedule->command('inventory:update-beginning')->monthlyOn(1, '00:00');
    }

    protected function lastDayOfMonth()
    {
        return now()->endOfMonth()->day;
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
