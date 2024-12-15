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
        ->whereHas('expirationNotifications', function ($query) {
            $query->where('notification_sent', false);
        })
        ->get();

    if ($medicines->isEmpty()) {
        return; // Không có thuốc nào cần thông báo, không làm gì
    }
    $userEmail = $settings->email;
    Mail::to($userEmail)->send(new \App\Mail\ExpirationNotificationEmail($medicines));

    // Cập nhật các thuốc đã được gửi thông báo
    foreach ($medicines as $medicine) {
        $medicine->expirationNotifications()
            ->where('notification_sent', false)
            ->update([
                'notified_at' => now(),
                'notification_sent' => true,
            ]);
    }
}

}
