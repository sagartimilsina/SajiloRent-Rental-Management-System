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
        Schema::create('mortage__records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')->references('id')->on('propeerties')->onDelete('cascade');
            $table->string('mortage_amount')->nullable();
            $table->string('mortage_start_date');
            $table->string('mortage_end_date');
            $table->string('mortage_file')->nullable();
            $table->enum('mortage_status', ['pending', 'approved', 'rejected', 'completed', 'expired'])->default('pending');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mortage__records');
    }
};
