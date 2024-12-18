<?php

namespace App\Jobs;

use App\Models\Batch;
use App\Models\ExpirationNotification;
use App\Models\Medicine;
use App\Models\NotificationSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
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

        // Lấy các lô thuốc sắp hết hạn mà chưa được thông báo
        $batches = Batch::where('expiration_date', '<=', now()->addDays($settings->expiration_notification_days))
            ->where('expiration_date', '>=', now())
            ->whereDoesntHave('expirationNotifications', function ($query) {
                $query->where('notification_sent', false);
            })
            ->with('medicine') // Lấy luôn thông tin thuốc liên kết
            ->get();

        if ($batches->isEmpty()) {
            return; // Không có lô thuốc nào cần thông báo, không làm gì
        }

        // Chuẩn bị dữ liệu để gửi email
        $data = $batches->map(function ($batch) {
            return [
                'medicine_name' => $batch->medicine->name,
                'batch_id' => $batch->id,
                'expiration_date' => $batch->expiration_date,
                'batch_name' => $batch->created_at->format('d-m-Y'),
            ];
        });
      
        $userEmail = $settings->email;
        Mail::to($userEmail)->send(new \App\Mail\ExpirationNotificationEmail($data));

        // Cập nhật trạng thái thông báo đã gửi trong bảng expiration_notifications
        foreach ($batches as $batch) {
            ExpirationNotification::where('batch_id', $batch->id)
                ->where('notification_sent', false)
                ->update([
                    'notified_at' => now(),
                    'notification_sent' => true,
                ]);
        }
    }
}
