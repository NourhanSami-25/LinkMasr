<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Go to Cron Jobs in cPanel
     * Add: * * * * * cd /home/yourusername/public_html && php artisan schedule:run
     */

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('reminders:check')->everyMinute();
        $schedule->command('reminders:cleanup')->daily();
        $schedule->command('notifications:cleanup')->daily();
        $schedule->command('logs:cleanup')->daily();
        $schedule->command('contracts:check-expiratio')->daily();
        $schedule->command('finances:check-overdue')->daily();
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}




