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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('contact_name', 50);
            $table->string('contact_phone', 50);
            $table->string('user_id', 50);
            $table->string('address', 250);
            $table->string('latitude', 250);
            $table->string('longitude', 250);
            $table->string('address_type', 50);
            $table->string('is_default', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
