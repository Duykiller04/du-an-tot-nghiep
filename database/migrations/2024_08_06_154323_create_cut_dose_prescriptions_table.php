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
        Schema::create('cut_dose_prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Disease::class)->constrained();
            $table->string('name_hospital', 50)->comment('tên_bệnh_viện');
            $table->string('name_doctor', 50);
            $table->date('age');
            $table->string('phone_doctor');
            $table->double('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cut_dose_prescriptions');
    }
};
