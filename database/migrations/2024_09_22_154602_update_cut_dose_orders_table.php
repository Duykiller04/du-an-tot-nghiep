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
        Schema::table('cut_dose_orders', function (Blueprint $table) {
            // Bỏ 2 trường age_min và age_max
            $table->dropColumn(['age_min', 'age_max']);

            // Thêm trường age dưới dạng integer sau weight
            $table->integer('age')->after('weight')->comment('tuổi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cut_dose_orders', function (Blueprint $table) {
            // Thêm lại 2 trường age_min và age_max
            $table->unsignedBigInteger('age_min')->after('weight');
            $table->unsignedBigInteger('age_max')->after('age');

            // Bỏ trường age
            $table->dropColumn('age');
        });
    }
};
