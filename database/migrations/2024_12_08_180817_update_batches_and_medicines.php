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
        Schema::table('batches', function (Blueprint $table) {
            $table->dropColumn(['temperature', 'moisture']);
        });

        Schema::table('medicines', function (Blueprint $table) {
            $table->float('temperature')->nullable()->comment('Nhiệt độ bảo quản')->after('type_product');
            $table->float('moisture')->nullable()->comment('Độ ẩm bảo quản')->after('temperature');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->float('temperature')->nullable()->comment('Nhiệt độ bảo quản');
            $table->float('moisture')->nullable()->comment('Độ ẩm bảo quản');
        });

        Schema::table('medicines', function (Blueprint $table) {
            $table->dropColumn(['temperature', 'moisture']);
        });
    }
};
