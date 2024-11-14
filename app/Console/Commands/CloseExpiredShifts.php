<?php

namespace App\Console\Commands;

use App\Models\NotificationLog;
use App\Models\Shift;
use App\Models\NotificationSetting;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CloseExpiredShifts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shift:close-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tự động đóng các ca làm đã hết thời gian nếu được bật trong cấu hình';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $settings = NotificationSetting::first();

        if (!$settings || !$settings->auto_close_shift) {
            $this->info("Tự động đóng ca đang bị tắt trong cấu hình.");
            return;
        }
        $closeAfterMinutes = $settings->close_after_minutes ?? 0;

        // Tìm các ca đang mở mà thời gian đã hết và quá số phút quy định
        $expiredShifts = Shift::where('status', 'đang mở')
            ->where('end_time', '<=', $now->copy()->subMinutes($closeAfterMinutes))
            ->get();

        foreach ($expiredShifts as $shift) {
            // Đóng ca làm
            $shift->status = 'đã chốt';
            $shift->save();
            NotificationLog::create([
                'message' => "Ca làm {$shift->shift_name} đã được đóng.",
                'id_thing' => $shift->id,
            ]);
            $this->info("Ca ID {$shift->id} đã được đóng.");
        }

        $this->info('Đã đóng tất cả các ca làm hết thời gian.');
    }
}
