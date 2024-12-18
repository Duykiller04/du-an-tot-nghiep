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
        Schema::table('cut_dose_prescriptions', function (Blueprint $table) {
            $table->dropColumn('name_hospital');
            $table->dropColumn('age');
            $table->dropColumn('phone_doctor');
            $table->dropColumn('total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cut_dose_prescriptions', function (Blueprint $table) {
            $table->string('name_hospital', 50)->comment('tên_bệnh_viện');
            $table->integer('age');
            $table->string('phone_doctor');
            $table->double('total');
        });
    }
};
