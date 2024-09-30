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
        Schema::create('salary', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('num_attendance');
            $table->string('reward', 255);
            $table->date('revised_date');
            $table->unsignedBigInteger('id_attent');
            $table->unsignedBigInteger('user_id');
            $table->decimal('base_salary', 10, 2);
            $table->integer('status');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary');
    }
};
