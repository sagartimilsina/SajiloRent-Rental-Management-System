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
        Schema::create('propeerties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unsignedBigInteger('sub_category_id');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories');
            $table->string('property_name');
            $table->longText('property_description');
            $table->enum('pricing_type', ['free', 'paid'])->default('free');
            $table->string('property_price');
            $table->string('property_discount')->nullable();
            $table->string('property_location')->nullable();
            $table->string('property_image');
            $table->string('property_quantity');
            $table->string('property_sell_price')->nullable();
            $table->string('property_expiry')->nullable();
            $table->boolean('property_publish_status')->default(false);
            // $table->unsignedBigInteger('created_by');
            $table->foreignId('created_by');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propeerties');
    }
};
