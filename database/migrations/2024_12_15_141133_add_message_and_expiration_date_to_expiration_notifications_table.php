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
        Schema::table('expiration_notifications', function (Blueprint $table) {
            $table->text('message')->nullable()->after('notification_sent'); // Thêm cột message
            $table->date('expiration_date')->nullable()->after('message');   // Thêm cột expiration_date
        });
    }

    public function down(): void
    {
        Schema::table('expiration_notifications', function (Blueprint $table) {
            $table->dropColumn(['message', 'expiration_date']);
        });
    }
};
