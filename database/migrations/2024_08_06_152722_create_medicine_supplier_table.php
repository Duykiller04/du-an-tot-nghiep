<?php

use App\Models\Medicine;
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
        Schema::create('medicine_supplier', function (Blueprint $table) {
            $table->foreignIdFor(Medicine::class)->constrained();
            $table->foreignIdFor(Supplier::class)->constrained();
            
            $table->primary(['medicine_id', 'supplier_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_supplier');
    }
};
