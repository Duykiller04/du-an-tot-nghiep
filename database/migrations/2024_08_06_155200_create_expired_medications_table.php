<?php

use App\Models\Medicine;
use App\Models\Storage;
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
        Schema::create('expired_medications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Storage::class)->constrained();
            $table->foreignIdFor(Medicine::class)->constrained();
            $table->unsignedInteger('quantity')->default(0);
            $table->dateTime('expiration_date')->comment('ngày hết hạn');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expired_medications');
    }
};
