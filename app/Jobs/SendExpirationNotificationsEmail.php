<?php

namespace App\Jobs;

use App\Models\Medicine;
use App\Models\NotificationSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendExpirationNotificationsEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $settings = NotificationSetting::first();

        if (!$settings || !$settings->notification_enabled || !$settings->receive_email_notifications) {
            return; // Nếu không có cài đặt hoặc tắt thông báo, không làm gì
        }

        
        $medicines = Medicine::where('expiration_date', '<=', now()->addDays($settings->expiration_notification_days))
            ->where('expiration_date', '>=', now())
            ->get();

        if ($medicines->isEmpty()) {
            return; 
        }

        
        $userEmail = $settings->email; 

        Mail::to($userEmail)->send(new \App\Mail\ExpirationNotificationEmail($medicines));
    }
}
