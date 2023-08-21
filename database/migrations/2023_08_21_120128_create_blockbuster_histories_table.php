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
        Schema::create('blockbuster_histories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('date_end');
            $table->string('image')->nullable();
            $table->integer('amount_people');
            $table->string('other');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blockbuster_histories');
    }
};
