<?php

namespace App\Console\Commands;

use App\Models\NotificationLog;
use Illuminate\Console\Command;
use App\Models\Shift;
use App\Models\NotificationSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class OpenScheduledShifts extends Command
{
    protected $signature = 'shift:open-scheduled';
    protected $description = 'Tự động mở ca làm theo lịch nếu đạt đủ điều kiện';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $currentDateTime = Carbon::now('Asia/Ho_Chi_Minh');
        $currentDate = $currentDateTime->toDateString();

        $settings = NotificationSetting::first();

        if (!$settings || !$settings->auto_open_shift) {
            $this->info("Tự động mở ca đang bị tắt trong cấu hình.");
            Log::info("Tự động mở ca đang bị tắt trong cấu hình");
            return;
        }

        // Kiểm tra xem có ca nào đang mở không
        $existingOpenShift = Shift::where('status', 'đang mở')->exists();
        if ($existingOpenShift) {
            $this->info("Đã có ca làm đang mở, không thể mở thêm ca.");
            Log::info("Đã có ca làm đang mở, không thể mở thêm ca.");
            return;
        }

        $shift = Shift::where('status', 'kế hoạch')
            ->whereDate('start_time', '=', $currentDate) 
            ->where('start_time', '=', $currentDateTime) 
            ->where('start_time', '>=', $currentDateTime->copy()->subHour()) // Thời gian hiện tại <= 1 giờ sau thời gian bắt đầu
            ->orderBy('start_time') 
            ->lockForUpdate() 
            ->first();

        if (!$shift) {
            $this->info("Không có ca nào phù hợp để mở trong ngày hôm nay.");
            Log::info("Không có ca nào phù hợp để mở trong ngày hôm nay.");
            return;
        }

        if ($shift->users()->count() < 1) {
            $this->info("Ca ID {$shift->id} không có nhân viên nào, không thể mở ca.");
            Log::info("Ca không có nhân viên nào, không thể mở ca.");
            return;
        }

        $startTime = Carbon::parse($shift->start_time);
        $endTime = Carbon::parse($shift->end_time);

        if ($endTime <= $startTime) {
            $this->info("Ca ID {$shift->id} có thời gian kết thúc không hợp lệ.");
            Log::info("Ca có thời gian kết thúc không hợp lệ.");
            return;
        }

        // Mở ca và lưu trạng thái
        $shift->status = 'đang mở';
        $shift->save();

        // Ghi log
        NotificationLog::create([
            'message' => "Ca làm {$shift->shift_name} đã được mở.",
            'id_thing' => $shift->id,
        ]);
        $this->info("Ca ID {$shift->id} đã được mở thành công.");
        Log::info("Ca đã được mở thành công.");
    }
}
