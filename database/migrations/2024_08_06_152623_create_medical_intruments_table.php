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
        Schema::create('medical_intruments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Storage::class)->constrained();
            $table->foreignIdFor(Unit::class)->constrained();
            $table->string('name')->comment('Tên dụng cụ');
            $table->double('price_import',15,2)->comment('giá nhập');
            $table->double('price_sale',15,2)->comment('giá bán');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_intruments');
    }
};
