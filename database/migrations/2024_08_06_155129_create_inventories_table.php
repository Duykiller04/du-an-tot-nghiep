<?php

use App\Models\Medicine;
use App\Models\Storage;
use App\Models\Unit;
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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Storage::class)->constrained();
            $table->foreignIdFor(Medicine::class)->constrained();
            $table->foreignIdFor(Unit::class)->constrained();
            $table->unsignedInteger('quantity')->default(0)->comment('SL đơn vị bé nhất');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
