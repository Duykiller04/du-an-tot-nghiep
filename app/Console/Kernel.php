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
        $schedule->job(new \App\Jobs\CheckExpirationNotifications())->dailyAt('14:48');
        $schedule->job(new \App\Jobs\SendExpirationNotificationsEmail)->dailyAt('15:49');
        $schedule->job(new \App\Jobs\UpdateBatchStatusExpiry())->dailyAt('16:05');
        $schedule->command('shift:open-scheduled')->everyMinute();
        $schedule->command('shift:close-expired')->everyMinute();
      
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
