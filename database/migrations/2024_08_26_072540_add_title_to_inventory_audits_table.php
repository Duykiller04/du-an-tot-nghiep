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
        Schema::table('inventory_audits', function (Blueprint $table) {
            $table->string('title')->after('id'); // Thêm cột title sau cột id
        });
    }

    public function down()
    {
        Schema::table('inventory_audits', function (Blueprint $table) {
            $table->dropColumn('title'); // Xóa cột title khi rollback
        });
    }
};
