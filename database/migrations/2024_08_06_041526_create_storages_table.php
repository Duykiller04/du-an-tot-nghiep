<?php

use App\Models\MedicalInstrument;
use App\Models\Medicine;
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
        Schema::create('storages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Unit::class)->constrained();
            $table->string('inventory_code')->unique();
            $table->string('location')->comment('địa chỉ');
            $table->unsignedInteger('quantity')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.storage.import_order_details.inventory
     */
    public function down(): void
    {
        Schema::dropIfExists('storages');
    }
};
