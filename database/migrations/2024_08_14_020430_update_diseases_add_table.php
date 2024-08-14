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
            $table->text('symptom')->change();
            $table->text('treatment_direction')->nullable()->after('feature_img'); // Thêm cột hướng điều trị
            $table->enum('danger_level', ['low', 'medium', 'high'])->default('low')->after('treatment_direction'); // Thêm cột đánh giá mức độ nguy hiểm
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diseases', function (Blueprint $table) {
            $table->dropColumn('treatment_direction');
            $table->dropColumn('danger_level');
            $table->string('symptom')->change();
        });
    }
};
