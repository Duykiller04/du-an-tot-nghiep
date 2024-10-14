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
        Schema::create('expiration_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medicine_id'); // ID thuốc được thông báo
            $table->dateTime('notified_at'); // Thời gian gửi thông báo
            $table->boolean('notification_sent')->default(false); // Trạng thái thông báo (đã gửi hay chưa)
            $table->timestamps();
        
            // Đặt khóa ngoại liên kết với bảng medicines
            $table->foreign('medicine_id')->references('id')->on('medicines')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expiration_notifications');
    }
};
