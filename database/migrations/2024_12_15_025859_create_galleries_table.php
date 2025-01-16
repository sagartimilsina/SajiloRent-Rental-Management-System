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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('property_id')->nullable();
            $table->foreignId('property_id');
            $table->enum('gallery_type', ['image', 'video', 'document'])->default('image');
            $table->string('gallery_name');
            $table->string('gallery_file');
            $table->boolean('gallery_publish_status')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
