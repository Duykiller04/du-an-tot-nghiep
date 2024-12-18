<?php

namespace App\Jobs;

use App\Models\Batch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateBatchStatusExpiry implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $expiredBatches = Batch::where('expiration_date', '<', now())
            ->where('status_expiry', false) 
            ->get();

        // Cập nhật trạng thái status_expiry thành true
        foreach ($expiredBatches as $batch) {
            $batch->update(['status_expiry' => true]);
        }

       
    }
}
