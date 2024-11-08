<?php

namespace App\Console\Commands;

use App\Models\Shift;
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
    protected $description = 'Command description';

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

        // Tìm các ca đang mở mà thời gian đã hết
        $expiredShifts = Shift::where('status', 'đang mở')
            ->where('end_time', '<=', $now)
            ->get();

        foreach ($expiredShifts as $shift) {
            // Đóng ca làm
            $shift->status = 'đã chốt';
            $shift->save();
        }

        $this->info('Đã đóng tất cả các ca làm hết thời gian.');
    }
}
