<?php

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
        Schema::table('cut_dose_order_details', function (Blueprint $table) {
            $table->dropColumn('dosage');
            $table->dropForeign(['medicine_id']);
            $table->dropColumn('medicine_id');
            $table->foreignId('batch_id')->constrained('batches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cut_dose_order_details', function (Blueprint $table) {
            $table->string('dosage');
            $table->dropForeign(['batch_id']);
            $table->dropColumn('batch_id');
            $table->foreignId('medicine_id')->constrained()->onDelete('cascade');
        });
    }
};
