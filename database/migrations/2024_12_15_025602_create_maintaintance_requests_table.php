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
        Schema::create('maintaintance_requests', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('property_id');
            $table->foreignId('property_id');
            // $table->unsignedBigInteger('user_id');
            $table->foreignId('user_id');
            $table->string('request_type');
            $table->string('request_description');
            $table->enum('request_status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintaintance_requests');
    }
};
