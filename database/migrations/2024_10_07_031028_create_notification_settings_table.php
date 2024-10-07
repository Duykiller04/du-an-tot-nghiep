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
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('notification_enabled')->default(true); // Mặc định là bật
            $table->integer('expiration_notification_days')->default(30); // Số ngày trước khi thuốc hết hạn sẽ thông báo
            $table->boolean('receive_email_notifications')->default(true); // Nhận email thông báo
            $table->boolean('temperature_warning')->default(false); // Cảnh báo nhiệt độ bảo quản
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_settings');
    }
};
