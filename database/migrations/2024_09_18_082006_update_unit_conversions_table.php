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
        Schema::table('unit_conversions', function (Blueprint $table) {
            // Xóa 2 trường unit_id_1 và unit_id_2
            $table->dropForeign(['unit_id_1']);
            $table->dropForeign(['unit_id_2']);
            $table->dropColumn(['unit_id_1', 'unit_id_2']);

            // Thêm trường unit_id
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade')->comment('id đơn vị quy đổi');

            // Sửa comment của trường proportion
            $table->double('proportion')->comment('Đơn vị quy đổi')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unit_conversions', function (Blueprint $table) {
            // Thêm lại các trường unit_id_1 và unit_id_2
            $table->foreignId('unit_id_1')->constrained('units')->onDelete('cascade');
            $table->foreignId('unit_id_2')->constrained('units')->onDelete('cascade');

            // Xóa trường unit_id
            $table->dropForeign(['unit_id']);
            $table->dropColumn('unit_id');

            // Sửa lại comment của trường proportion
            $table->double('proportion')->comment('Tỷ lệ')->change();
        });
    }
};
