<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Storage;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->foreignIdFor(Storage::class)->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->dropForeign(['storage_id']);
            $table->dropColumn('storage_id');
        });
    }
};
