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

        // Xác định ngày hết hạn cần thông báo dựa trên cấu hình
        $expirationDateThreshold = Carbon::now()->addDays($settings->expiration_notification_days);

        // Lấy danh sách thuốc sắp hết hạn
        $medicines = Medicine::where('expiration_date', '<=', $expirationDateThreshold)->get();

        foreach ($medicines as $medicine) {
            // Kiểm tra nếu đã có thông báo chưa gửi cho thuốc này
            $existingNotification = ExpirationNotification::where('medicine_id', $medicine->id)
                ->where('notification_sent', false)
                ->first();

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
