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
        Schema::create('message_chats', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('user_id_from');
            $table->unsignedBigInteger('user_id_to');
            $table->unsignedBigInteger('property_id')->nullable();
            $table->foreign('property_id')->references('id')->on('propeerties')->onDelete('CASCADE');
            $table->foreign('user_id_from')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('user_id_to')->references('id')->on('users')->onDelete('CASCADE');
            $table->text('message')->nullable();
            $table->string('attachments')->nullable();
            $table->string('reaction')->nullable()->comment('0= like, 1=love, 2=haha,3= wow, 4=sad, 5=angry')->default('null');
            $table->text('voice_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_chats');
    }
};
