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
        Schema::create('inventory_check_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventory_audit_id');
            $table->foreign('inventory_audit_id')->references('id')->on('inventory_audit');
            $table->unsignedBigInteger('medicine_id');
            $table->foreign('medicine_id')->references('id')->on('medicines');
            $table->unsignedBigInteger('quantity');
            $table->enum('status',['Checked','Unchecked']);
            $table->unsignedBigInteger('medical_instrument_id');
            $table->foreign('medical_instrument_id')->references('id')->on('medical_instruments');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_check_details');
    }
};
