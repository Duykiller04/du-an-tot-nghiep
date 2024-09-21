<?php

use App\Models\Medicine;
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
        Schema::create('unit_conversions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Medicine::class)->constrained();
            $table->foreignId('unit_id_1')->constrained('id')->on('units')->onDelete('cascade');
            $table->foreignId('unit_id_2')->constrained('id')->on('units')->onDelete('cascade');
            $table->double('proportion')->comment('Tỷ lệ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_conversions');
    }
};
