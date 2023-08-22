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
        Schema::create('bank_card_management', function (Blueprint $table) {
            $table->id();
            $table->string('card_real_name');
            $table->string('card_address');
            $table->string('card_address_2')->nullable();
            $table->string('user_id')->nullable();
            $table->string('others')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_card_management');
    }
};
