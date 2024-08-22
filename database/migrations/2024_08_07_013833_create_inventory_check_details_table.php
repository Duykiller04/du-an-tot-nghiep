<?php

use App\Models\InventoryAudit;
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
        Schema::create('inventory_check_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(InventoryAudit::class)->constrained();
            $table->foreignIdFor(Medicine::class)->constrained();
            $table->double('quantity');
            $table->enum('status',['checked','unchecked']);
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
