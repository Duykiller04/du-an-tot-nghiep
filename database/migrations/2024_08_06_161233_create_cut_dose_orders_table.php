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
        Schema::create('cut_dose_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('weight')->comment('cân nặng');
            $table->unsignedBigInteger('age_min');
            $table->unsignedBigInteger('age_max');
            $table->boolean('gender');
            $table->string('name_diseases')->comment('tên bệnh');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cut_dose_orders');
    }
};
