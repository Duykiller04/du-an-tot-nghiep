<?php

use App\Models\Storage;
use App\Models\User;
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
        Schema::create('inventory_audits', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Storage::class)->constrained(); // Khóa ngoại storage_id
            $table->foreignIdFor(User::class)->constrained(); //Người kiểm kho
            $table->string('title'); // Thêm trường title
            $table->date('check_date'); // Ngày kiểm kho
            $table->string('checked_by'); // Tên người kiểm
            $table->enum('status', ['Đang kiểm', 'Hoàn thành', 'Chờ duyệt'])->default('Đang kiểm'); // Trạng thái kiểm
            $table->text('remarks')->nullable(); // Ghi chú
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_audits');
    }
};
