<?php

namespace App\Console;

use App\Jobs\SendExpirationNotificationsEmail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->job(new \App\Jobs\CheckExpirationNotifications())->dailyAt('20:55');
        $schedule->job(new \App\Jobs\SendExpirationNotificationsEmail)->dailyAt('21:00');
        $schedule->command('shift:close-expired')->everyMinute();
        $schedule->command('shift:open-scheduled')->everyMinute();
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
