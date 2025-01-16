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
        Schema::create('tenant_agreementwith_systems', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('request_id');
            $table->foreign('request_id')->references('id')->on('request_owner_lists');
            $table->enum('status', ['pending', 'approved', 'rejected', 'expired'])->default('pending');
            $table->boolean('agreement_status')->default(0)->comment('0=no,1=yes');
            $table->string('agreement_file')->nullable();
            $table->softDeletes();
            $table->longText('agreement');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_agreementwith_systems');
    }
};
