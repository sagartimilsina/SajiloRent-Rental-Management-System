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
        Schema::create('property__reviews', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('property_id');
            $table->foreignId('property_id');
            // $table->unsignedBigInteger('user_id');
            $table->foreignId('user_id');
            $table->string('property_review');
            $table->string('property_rating');
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property__reviews');
    }
};
