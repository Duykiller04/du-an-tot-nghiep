<?php

use App\Models\Storage;
use App\Models\Supplier;
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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Storage::class)->constrained();
            $table->foreignIdFor(Unit::class)->constrained();
            $table->string('medicine_code',20)->comment('Mã thuốc');
            $table->double('price_import',15,2)->comment('giá nhập');
            $table->double('price_sale',15,2)->comment('giá bán');
            $table->string('packaging_specification',50)->comment('Quy cách đóng gói');
            $table->string('registration_number',30)->comment('Số đăng ký');
            $table->string('active_ingredient',30)->comment('Hoạt chất');
            $table->string('concentration',50)->comment('Hàm lượng');
            $table->string('dosage',100)->comment('Liều dùng');
            $table->string('administration_route',50)->comment('Đường dùng (đường uống, đường tiêm)');
            $table->string('origin',50)->comment(' Xuất xứ (ví dụ: Việt Nam)');
            $table->boolean('is_active')->default(true);
            $table->date('expiration_date')->comment('Ngày hết hạn');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
