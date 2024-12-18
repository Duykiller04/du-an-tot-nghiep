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
        Schema::table('cut_dose_prescription_details', function (Blueprint $table) {
            $table->dropColumn(['quantity', 'dosage']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cut_dose_prescription_details', function (Blueprint $table) {
            $table->double('quantity')->nullable(false);
            $table->string('dosage', 255)->nullable(false)->collation('utf8mb4_unicode_ci');
        });
    }
};
