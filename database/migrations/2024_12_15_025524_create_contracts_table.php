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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('property_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('property_id')->references('id')->on('propeerties')->onDelete('cascade');
            // $table->foreignId('user_id');
            // $table->foreignId('property_id');
            $table->string('contract_type');
            $table->string('contract_start_date');
            $table->string('contract_end_date');
            $table->string('contract_file');
            $table->enum('contract_status', ['pending', 'approved', 'rejected','cancelled', 'completed', 'expired'])->default('pending');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
