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
        Schema::create('purchasing_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nft_product_id')->constrained('nft_products');
            $table->foreignId('user_id');
            $table->string('nft_title');
            $table->integer('nft_like')->nullable();
            $table->integer('nft_click')->default(0);
            $table->decimal('nft_price', 16, 6);
            $table->decimal('nft_amount_pay', 16, 6);
            $table->string('nft_coin_type')->nullable();
            $table->string('nft_image')->nullable();
            $table->string('nft_buy_date')->nullable();
            $table->boolean('nft_is_approve')->default(false);
            $table->string('nft_status_process')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchasing_products');
    }
};
