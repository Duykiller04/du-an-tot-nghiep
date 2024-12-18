<?php

use App\Models\Batch;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cut_dose_prescription_details', function (Blueprint $table) {
            $table->dropForeignIdFor(Batch::class);
            $table->dropColumn('batch_id');
            $table->dropColumn('current_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cut_dose_prescription_details', function (Blueprint $table) {
            $table->foreignIdFor(Batch::class)->constrained();
            $table->unsignedBigInteger('current_price');
        });
    }
};
