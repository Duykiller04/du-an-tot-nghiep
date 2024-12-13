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
        Schema::table('medicines', function (Blueprint $table) {
            $table->dropForeign(['storage_id']);
            $table->dropColumn([
                'registration_number',
                'origin',
                'packaging_specification',
                'price_import',
                'price_sale',
                'expiration_date',
                'temperature',
                'moisture',
                'storage_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->string('registration_number',30)->comment('Số đăng ký');
            $table->string('origin',50)->comment('Xuất xứ (ví dụ: Việt Nam)');
            $table->string('packaging_specification',50)->comment('Quy cách đóng gói');
            $table->double('price_import',15,2)->comment('giá nhập');
            $table->double('price_sale',15,2)->comment('giá bán');
            $table->date('expiration_date')->comment('Ngày hết hạn');
            $table->decimal('temperature', 5, 2)->nullable()->after('expiration_date')->comment('Nhiệt độ');
            $table->decimal('moisture', 5, 2)->nullable()->after('temperature')->comment('Độ ẩm');
            $table->unsignedBigInteger('storage_id')->nullable()->after('moisture')->comment('Vị trí lưu trữ');
            $table->foreign('storage_id')->references('id')->on('storages')->onDelete('cascade');
        });
    }
};
