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
            $table->unsignedBigInteger('batch_id')->after('medicine_id')->nullable(); // Thêm cột batch_id
            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade'); // Khóa ngoại
        });
    }

    public function down(): void
    {
        Schema::table('expiration_notifications', function (Blueprint $table) {
            $table->dropForeign(['batch_id']);
            $table->dropColumn('batch_id');
        });
    }
};
