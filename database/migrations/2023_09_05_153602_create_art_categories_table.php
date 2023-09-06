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
        Schema::create('art_categories', function (Blueprint $table) {
            $table->id();
            $table->string('art_level')->nullable();
            $table->decimal('art_price_start', 12, 6)->default(0);
            $table->decimal('art_price_end', 12, 6)->default(0);
            $table->string('art_coin_type');
            $table->string('art_image')->nullable();
            $table->string('art_other')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('art_categories');
    }
};
