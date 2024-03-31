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
        Schema::create('deliveryman_bank_details', function (Blueprint $table) {
            $table->id();
            $table->string('deliveryman_id', 50);
            $table->string('deliveryman_name', 100);
            $table->string('account_holder_name', 250);
            $table->string('bank_name', 100);
            $table->string('ifsc_code', 50);
            $table->string('deliveryman_phone', 50);
            $table->string('account_number', 250);
            $table->string('confirm_account_number', 250);
            $table->string('account_type', 100);
            $table->integer('is_active')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveryman_bank_details');
    }
};
