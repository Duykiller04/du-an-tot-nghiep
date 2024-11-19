<?php

namespace App\Console\Commands;

use App\Models\NotificationLog;
use Illuminate\Console\Command;
use App\Models\Shift;
use App\Models\NotificationSetting;
use Carbon\Carbon;

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

        $settings = NotificationSetting::first();
        
        if (!$settings || !$settings->auto_open_shift) {
            $this->info("Tự động mở ca đang bị tắt trong cấu hình.");
            return;
        }

        // Lấy các ca có trạng thái là "kế hoạch" và thời gian bắt đầu nhỏ hơn hoặc bằng hiện tại
        $shifts = Shift::where('status', 'kế hoạch')
            ->where('start_time', '<=', $currentDateTime)
            ->get();

        foreach ($shifts as $shift) {
            
            if ($shift->users()->count() < 1) {
                $this->info("Ca ID {$shift->id} không có nhân viên nào, không thể mở ca.");
                continue;
            }
            
            $startTime = Carbon::parse($shift->start_time);
            $endTime = Carbon::parse($shift->end_time);

            if ($endTime <= $startTime) {
                $this->info("Ca ID {$shift->id} có thời gian kết thúc không hợp lệ.");
                continue;
            }

            // Kiểm tra trùng lặp thời gian với các ca khác trong cùng ngày
            $overlappingShifts = Shift::where('status', 'đang mở')
                ->whereDate('start_time', $startTime->toDateString())
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->whereBetween('start_time', [$startTime, $endTime])
                        ->orWhereBetween('end_time', [$startTime, $endTime])
                        ->orWhere(function ($query) use ($startTime, $endTime) {
                            $query->where('start_time', '<=', $startTime)
                                ->where('end_time', '>=', $endTime);
                        });
                })
                ->where('id', '!=', $shift->id)
                ->count();

            if ($overlappingShifts > 0) {
                $this->info("Ca ID {$shift->id} bị trùng thời gian với ca đang mở khác.");
                continue;
            }

            // Mở ca và lưu trạng thái
            $shift->status = 'đang mở';
            $shift->save();
            NotificationLog::create([
                'message' => "Ca làm {$shift->shift_name} đã được mở.",
                'id_thing' => $shift->id,
            ]);
            $this->info("Ca ID {$shift->id} đã được mở thành công.");
        }
    }
}
