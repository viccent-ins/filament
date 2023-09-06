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
        Schema::create('nft_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('art_id')->constrained('art_categories')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nft_title');
            $table->integer('nft_like')->nullable();
            $table->integer('nft_click')->default(0);
            $table->decimal('nft_price', 16, 6);
            $table->string('nft_coin_type')->nullable();
            $table->string('nft_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nft_products');
    }
};
