<?php

namespace App\Jobs;
use App\Models\Medicine;
use App\Models\NotificationSetting;
use App\Models\ExpirationNotification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckExpirationNotifications implements ShouldQueue
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
        // Lấy cấu hình thông báo
        $settings = NotificationSetting::first();
        
        if (!$settings || !$settings->notification_enabled) {
            return; // Dừng nếu thông báo không được bật
        }
        $expirationDateThreshold = Carbon::now()->addDays($settings->expiration_notification_days);
        $medicines = Medicine::where('expiration_date', '<=', $expirationDateThreshold)->get();

        foreach ($medicines as $medicine) {
            // Kiểm tra nếu đã có thông báo cho thuốc này
            $existingNotification = ExpirationNotification::where('medicine_id', $medicine->id)->first();

            if (!$existingNotification) {
                ExpirationNotification::create([
                    'medicine_id' => $medicine->id,
                    'notified_at' => Carbon::now(),
                    'notification_sent' => false,
                ]);
            }
        }
    }
}
