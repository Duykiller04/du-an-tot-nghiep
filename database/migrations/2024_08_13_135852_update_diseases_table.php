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
        Schema::table('diseases', function (Blueprint $table) {
            // Drop foreign key and user_id column
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            // Add the feature_img column
            $table->string('feature_img')->nullable()->after('symptom');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diseases', function (Blueprint $table) {
            // Add user_id column and foreign key back
            $table->unsignedBigInteger('user_id')->after('symptom');
            $table->foreign('user_id')->references('id')->on('users');

            // Drop the feature_img column
            $table->dropColumn('feature_img');
        });
    }
};
