<?php

namespace App\Providers;

use App\Models\ExpirationNotification;
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
        ////////
        $notifications = ExpirationNotification::with('medicine')
        ->orderBy('notified_at', 'desc')
        ->get();
        //dd($notifications);
        View::share('notifications', $notifications);
    }
}
