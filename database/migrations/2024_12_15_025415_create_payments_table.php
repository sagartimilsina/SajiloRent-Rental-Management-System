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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')->references('id')->on('propeerties')->onDelete('cascade');
            $table->integer('property_quantity')->nullable();
            $table->enum('payment_method', ['ESEWA', 'KHALTI', 'STRIPE', 'CASH'])->default('CASH');
            $table->enum('status', ['PENDING', 'COMPLETE', 'FULL_REFUND', 'PARTIAL_REFUND', 'CANCELLED', 'AMBIGUOUS', 'NOT_FOUND', 'CANCELED', 'TIMEOUT'])->default('PENDING');
            $table->string('transaction_code')->nullable();
            $table->string('transaction_uuid');
            $table->string('signature')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->string('total_amount');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
