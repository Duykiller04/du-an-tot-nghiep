<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyInventoryAuditsTable extends Migration
{
    public function up()
    {
        Schema::table('inventory_audits', function (Blueprint $table) {

            // Thay đổi trường time thành date_recorded để lưu ngày kiểm kho
            $table->date('check_date')->after('storage_id');
            $table->dropColumn('time');
            $table->dropColumn('date_recorded');
            $table->dropForeign(['customer_id']); // Xóa ràng buộc khóa ngoại nếu có
            $table->dropColumn('customer_id'); // Xóa cột customer_id
            // Thay thế checked_by từ foreignId (User ID) thành một chuỗi lưu tên người kiểm
            $table->string('checked_by')->after('check_date');

            // Thêm trường status và remarks
            $table->enum('status', ['Đang kiểm', 'Hoàn thành', 'Chờ duyệt'])->default('Đang kiểm')->after('checked_by');
            $table->text('remarks')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('inventory_audits', function (Blueprint $table) {
            // Khôi phục lại bảng về trạng thái trước khi chạy migration này
            $table->foreignId('customer_id')->constrained();
            $table->dropColumn('check_date');
            $table->dropColumn('checked_by');
            $table->dropColumn('status');
            $table->dropColumn('remarks');
            $table->time('time')->after('customer_id');
            $table->time('date_recorded')->after('time');
        });
    }
}

