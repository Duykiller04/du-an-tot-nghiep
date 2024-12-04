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
        Schema::table('attendaces', function (Blueprint $table) {
            $table->string('img_check_in')->nullable()->change();
            $table->datetime('time_in')->nullable()->after('img_check_in');
            $table->datetime('time_out_2')->nullable()->after('time_out');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendaces', function (Blueprint $table) {
            $table->string('img_check_in')->nullable(false)->change();
            $table->dropColumn('time_in');
            $table->dropColumn('time_out_2');
        });
    }
};
