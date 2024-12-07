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
            $table->dropColumn('name_customer');
            $table->dropColumn('total');
            $table->string('customer_name', 50)->after('type_sell');
            $table->double('total_price')->after('seller');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->dropColumn('customer_name');
            $table->dropColumn('total_price');
            $table->string('name_customer', 50)->after('type_sell');
            $table->double('total')->after('seller');
        });
    }
};
