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
            $table->decimal('temperature', 5, 2)->nullable()->after('expiration_date')->comment('Nhiệt độ');
            $table->decimal('moisture', 5, 2)->nullable()->after('temperature')->comment('Độ ẩm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->dropColumn(['temperature', 'moisture']);
        });
    }
};
