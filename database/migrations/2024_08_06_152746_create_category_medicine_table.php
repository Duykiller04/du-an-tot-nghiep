<?php

use App\Models\Category;
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
        Schema::create('category_medicine', function (Blueprint $table) {
            $table->foreignIdFor(Supplier::class)->constrained();
            $table->foreignIdFor(Category::class)->constrained();
            
            $table->primary(['category_id', 'medicine_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_medicine');
    }
};
