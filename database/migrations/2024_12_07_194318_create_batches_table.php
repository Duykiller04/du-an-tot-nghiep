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
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_id')->constrained()->onDelete('cascade');
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('set null');
            $table->string('registration_number', 30)->comment('Số đăng ký');
            $table->string('origin', 50)->nullable()->comment('Xuất xứ (ví dụ: Việt Nam)');
            $table->string('packaging_specification', 50)->nullable()->comment('Quy cách đóng gói');
            $table->double('price_import', 15, 2)->comment('Giá nhập');
            $table->double('price_sale', 15, 2)->comment('Giá bán');
            $table->date('expiration_date')->comment('Ngày hết hạn');
            $table->float('temperature')->nullable()->comment('Nhiệt độ bảo quản');
            $table->float('moisture')->nullable()->comment('Độ ẩm bảo quản');
            $table->unsignedBigInteger('storage_id')->nullable()->comment('Vị trí lưu trữ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
