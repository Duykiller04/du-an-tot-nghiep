<?php

use App\Models\MedicalInstrument;
use App\Models\MedicalIntrument;
use App\Models\Supplier;
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
        Schema::create('medical_instruments_supplier', function (Blueprint $table) {
            $table->foreignIdFor(MedicalInstrument::class)->constrained();
            $table->foreignIdFor(Supplier::class)->constrained();
            $table->primary(['medical_instrument_id', 'supplier_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_instruments_supplier');
    }
};
