<?php

namespace App\Jobs;

use App\Models\Batch;
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

    // Xác định ngưỡng ngày hết hạn
    $expirationDateThreshold = Carbon::now()->addDays($settings->expiration_notification_days);

    // Lấy các lô thuốc sắp hết hạn
    $batches = Batch::where('expiration_date', '<=', $expirationDateThreshold)->get();

    foreach ($batches as $batch) {
        $medicine = $batch->medicine; // Lấy thông tin thuốc từ lô
        if (!$medicine) {
            continue; // Bỏ qua nếu không có thông tin thuốc
        }

        // Tạo nội dung thông báo
        $message = "Thuốc '{$medicine->name}' sắp hết hạn. Lô nhập ngày: ".$batch->created_at->format('d-m-Y') ;

        // Kiểm tra nếu đã có thông báo cho thuốc và lô này
        $existingNotification = ExpirationNotification::where('medicine_id', $medicine->id)
            ->where('expiration_date', $batch->expiration_date)
            ->first();

        if (!$existingNotification) {
            // Tạo thông báo mới
            ExpirationNotification::create([
                'medicine_id' => $medicine->id,
                'bacth_id' => $batch->id,
                'notified_at' => Carbon::now(),
                'notification_sent' => false,
                'message' => $message,
                'expiration_date' => $batch->expiration_date,
            ]);
        }
    }
}

}
