<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('environments', function (Blueprint $table) {
            $table->dateTime('time')->change();
        });
    }
    
    public function down()
    {
        Schema::table('environments', function (Blueprint $table) {
            $table->date('time')->change();
        });
    }
};
