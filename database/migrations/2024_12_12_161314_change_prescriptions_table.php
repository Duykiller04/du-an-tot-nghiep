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
            $table->integer('age')->nullable()->change();
            $table->dropColumn('type_sell');
            $table->text('note')->nullable()->after('age');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->string('type_sell')->nullable()->after('age');
            $table->integer('age')->nullable(false)->change();
            $table->dropColumn('note');
        });
    }
};
