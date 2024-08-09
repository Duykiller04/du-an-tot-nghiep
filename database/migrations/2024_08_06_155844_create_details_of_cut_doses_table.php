<?php

use App\Models\CutDosePrescription;
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
        Schema::create('details_of_cut_doses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Medicine::class)->constrained();
            $table->foreignIdFor(Unit::class)->constrained();
            $table->foreignIdFor(CutDosePrescription::class)->constrained();
            $table->foreignIdFor(MedicalInstrument::class)->constrained();
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
        Schema::dropIfExists('details_of_cut_doses');
    }
};
