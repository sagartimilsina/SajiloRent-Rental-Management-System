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
            // $table->unsignedBigInteger('user_id');
             $table->foreignId('user_id');
            // $table->unsignedBigInteger('property_id');
            $table->foreignId('property_id');
            $table->enum('payment_method', ['esewa', 'khalti', 'stripe', 'cash', 'manual'])->default('manual');
            $table->enum('payment_status', ['pending', 'success', 'failed'])->default('pending');
            $table->string('transaction_id');
            $table->string('payment_date');
            $table->string('service_charge')->nullable();
            $table->string('discount')->nullable();
            $table->string('tax')->nullable();
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
