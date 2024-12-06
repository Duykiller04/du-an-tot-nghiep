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
        Schema::table('cut_dose_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('disease_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cut_dose_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('disease_id')->nullable(false)->change();
        });
    }
};
