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
        Schema::create('property__images', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('property_id');
            $table->foreignId('property_id');
            $table->string('property_image');
            $table->boolean('property_publish_status')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property__images');
    }
};
