<?php

namespace App\Providers;

use App\Models\ExpirationNotification;
use App\Models\NotificationLog;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();


        ///////////
        $expirationNotifications = ExpirationNotification::with('medicine')
            ->orderBy('notified_at', 'desc')
            ->get();

        $commonNotifications = NotificationLog::latest()->get();
        $allNotificationsCount = $expirationNotifications->count() + $commonNotifications->count();
        View::share([
            'expirationNotifications' => $expirationNotifications,
            'commonNotifications' => $commonNotifications,
            'allNotificationsCount' => $allNotificationsCount,
        ]);
    }
}
