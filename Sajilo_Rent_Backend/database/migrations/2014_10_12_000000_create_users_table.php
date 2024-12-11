<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('google_id')->nullable();
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('user_role_management');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->unsignedBigInteger('otp_code')->nullable();
            $table->timestamp('otp_code_send_at');
            $table->timestamp('otp_code_verified_at')->nullable();
            $table->timestamp('otp_code_expires_at')->nullable();
            $table->boolean('otp_is_verified')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('avatar')->nullable();
            $table->rememberToken();
            $table->boolean('is_seeded')->default(0)->nullable();
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
