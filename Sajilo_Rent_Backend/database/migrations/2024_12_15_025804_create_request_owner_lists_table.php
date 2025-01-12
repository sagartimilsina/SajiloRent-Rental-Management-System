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
        Schema::create('request_owner_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('residential_address');
            $table->string('national_id');
            $table->string('govt_id_proof');
            $table->boolean('agree_terms');

            $table->string('business_name')->nullable();
            $table->string('pan_registration_id')->nullable();
            $table->string('business_type')->nullable();
            $table->string('business_proof')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed', 'expired'])->default('pending');

            $table->longText('reason')->nullable();
            $table->softDeletes();

            $table->timestamps();
        });





    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_owner_lists');
    }
};
