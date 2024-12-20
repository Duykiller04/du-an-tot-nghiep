<?php

use App\Models\CutDosePrescription;
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
        Schema::create('cut_dose_prescription_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Medicine::class)->constrained();
            $table->foreignIdFor(Unit::class)->constrained();
            $table->foreignIdFor(CutDosePrescription::class)->constrained();
            $table->double('quantity');
            $table->unsignedBigInteger('current_price');
            $table->string('dosage')->comment('liều lượng');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cut_dose_prescription_details');
    }
};
