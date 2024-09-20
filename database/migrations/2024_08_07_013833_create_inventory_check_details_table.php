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
            $table->foreignIdFor(InventoryAudit::class)->constrained(); // Khóa ngoại đến InventoryAudit
            $table->foreignIdFor(Medicine::class)->constrained(); // Khóa ngoại đến Medicine
            $table->double('expected_quantity'); // Số lượng dự kiến
            $table->double('actual_quantity')->nullable(); // Số lượng thực tế
            $table->double('difference')->nullable(); // Chênh lệch
            $table->text('remarks')->nullable(); // Ghi chú
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
