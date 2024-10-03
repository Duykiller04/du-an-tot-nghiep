<?php

use App\Models\Customer;
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
        Schema::table('cut_dose_orders', function (Blueprint $table) {
            $table->foreignIdFor(Customer::class)->constrained()->after('disease_id'); // Khóa ngoại đến Customer
            $table->string('customer_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cut_dose_orders', function (Blueprint $table) {
            $table->dropForeign(['customer_id']); // Bỏ khóa ngoại đến Customer
            $table->dropColumn(['customer_name', 'phone', 'address', 'customer_id']);
        });
    }
};
