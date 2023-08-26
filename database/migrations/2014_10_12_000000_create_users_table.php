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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->string('mobile')->nullable();
            $table->string('password');
            $table->string('email')->nullable();
            $table->string('withdraw_password')->nullable();
            $table->string('name')->nullable();
            $table->string('nick_name')->nullable();
            $table->string('referral')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('status')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
