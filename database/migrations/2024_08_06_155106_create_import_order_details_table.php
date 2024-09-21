<?php

use App\Models\ImportOrder;
use App\Models\Medicine;
use App\Models\Unit;
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
        Schema::create('import_order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ImportOrder::class)->constrained();
            $table->foreignIdFor(Unit::class)->constrained();
            $table->foreignIdFor(Medicine::class)->constrained();
            $table->dateTime('date_added')->comment('ngày nhập');
            $table->unsignedInteger('quantity')->default(0);
            $table->double('import_price')->comment('giá nhập');
            $table->double('total')->comment('tổng tiền');
            $table->text('note')->nullable()->comment('ghi chú');
            $table->string('medication_name')->comment('tên thuốc');
            $table->dateTime('expiration_date')->comment('ngày hết hạn');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_order_details');
    }
};
