<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Shift;
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

            
            $shift->status = 'đang mở';
            $shift->save();

            $this->info("Ca ID {$shift->id} đã được mở thành công.");
        }
    }
}
