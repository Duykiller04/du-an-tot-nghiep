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
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('notification_enabled')->default(true); 
            $table->integer('expiration_notification_days')->default(30); 
            $table->boolean('receive_email_notifications')->default(true);
            $table->string('email')->default('example@gmail.com'); 
            $table->boolean('temperature_warning')->default(false);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_settings');
    }
};
