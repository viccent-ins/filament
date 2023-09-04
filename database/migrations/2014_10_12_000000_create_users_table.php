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
            $table->mediumInteger('pid')->default(0);
            $table->string('username')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('password')->nullable();
            $table->string('user_address')->default(null);
            $table->string('email')->nullable();
            $table->string('user_level')->nullable();
            $table->string('login_time')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->integer('score')->nullable();
            $table->integer('invite_code')->nullable();
            $table->integer('eth_auth_amount')->default(0);
            $table->integer('eth_freeze_amount')->default(0);
            $table->integer('eth_available_quota')->default(0);
            $table->integer('usdt_cumulative')->default(0);
            $table->integer('usdt_freezing')->default(0);
            $table->integer('usdt_USDT')->default(0);
            $table->integer('eth_cumulative_income')->default(0);
            $table->integer('eth_today_income')->default(0);
            $table->integer('eth_convertible')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_delete')->default(0);
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
