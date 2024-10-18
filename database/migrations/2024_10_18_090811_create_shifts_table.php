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
        Schema::create('shifts', function (Blueprint $table) {
            $table->id(); 
            $table->string('shift_name'); 
            $table->dateTime('start_time'); 
            $table->dateTime('end_time'); 
            $table->enum('status', ['kế hoạch','đang mở','tạm dừng', 'đã chốt', 'đã hủy'])->default('kế hoạch'); 
            $table->decimal('revenue_summary', 10, 2)->nullable(); 
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
