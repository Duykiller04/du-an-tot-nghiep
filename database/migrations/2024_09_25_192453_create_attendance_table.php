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
        Schema::create('attendance', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('work_shift_id');
            $table->date('day');
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('status');
            $table->timestamp('checkin')->useCurrent(); 
            $table->timestamp('checkout')->useCurrent()->nullable();
            $table->timestamps();
            $table->foreign('work_shift_id')->references('id')->on('work_shift');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_attendance');
    }
};
