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
        Schema::create('accept_salary', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_UserAcceptSalary');
            $table->date('date_Accept');
            $table->decimal('total_salary', 10, 2);
            $table->timestamps();
            $table->foreign('id_UserAcceptSalary')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accept_salary');
    }
};
