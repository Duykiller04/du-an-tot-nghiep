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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('tax_code',10)->comment('Mã số thuế');
            $table->string('name')->comment('Tên nhà cung cấp');
            $table->string('address')->comment('Địa chỉ nhà cung cấp');
            $table->string('phone',20)->unique()->comment('Số điện thoại nhà cung cấp');
            $table->string('email')->unique()->comment('Email nhà cung cấp');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
