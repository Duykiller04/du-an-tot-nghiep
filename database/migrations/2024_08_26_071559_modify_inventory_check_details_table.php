<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('inventory_check_details', function (Blueprint $table) {
            // Thêm các trường mới
            $table->double('expected_quantity')->after('medicine_id');
            $table->double('actual_quantity')->nullable()->after('expected_quantity');
            $table->double('difference')->nullable()->after('actual_quantity');
            $table->text('remarks')->nullable()->after('status');

            // Xóa cột medical_instrument_id nếu không còn cần thiết
            $table->dropForeign(['medical_instrument_id']);
            $table->dropColumn('medical_instrument_id');
        });
    }

    public function down()
    {
        Schema::table('inventory_check_details', function (Blueprint $table) {
            // Khôi phục lại bảng về trạng thái trước khi chạy migration này
            $table->dropColumn('expected_quantity');
            $table->dropColumn('actual_quantity');
            $table->dropColumn('difference');
            $table->dropColumn('remarks');
            $table->foreignId('medical_instrument_id')->nullable()->constrained();
        });
    }
};
