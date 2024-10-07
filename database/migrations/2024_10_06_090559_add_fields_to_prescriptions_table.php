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
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('name_customer');;
            $table->string('address')->nullable()->after('phone');;
            $table->string('email')->nullable()->after('address');;
            $table->integer('weight')->nullable()->after('email');;
            $table->boolean('gender')->nullable()->after('weight');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->dropColumn(['phone', 'address', 'email', 'weight', 'gender']);
        });
    }
};
