<?php

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
        Schema::table('import_orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('storage_id');
            $table->dropConstrainedForeignId('supplier_id');
            $table->dropColumn('price_paid');
            $table->dropColumn('still_in_debt');
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('import_orders', function (Blueprint $table) {
            $table->foreignIdFor(Storage::class)->constrained();
            $table->foreignIdFor(Supplier::class)->constrained();
            $table->double('price_paid')->comment('giá trả');
            $table->double('still_in_debt')->comment('còn nợ');
            $table->string('status');
        });
    }
};
