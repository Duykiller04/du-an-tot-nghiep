<?php

use App\Models\Shift;
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
            $table->boolean('status')->default(true);
            $table->foreignIdFor(Shift::class)->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cut_dose_orders', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
