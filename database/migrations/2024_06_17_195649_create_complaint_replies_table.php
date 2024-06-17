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
        Schema::create('complaint_replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('complaint_ticket_id');
        $table->text('message')->nullable();
        $table->enum('sending_by', ['user', 'client'])->nullable(); //sending by me relation name dal dena taki get kar sake 
        $table->unsignedBigInteger('sender_id')->nullable();
        $table->string('attechment')->nullable();
        $table->timestamps();

        $table->foreign('complaint_ticket_id')->references('id')->on('complaint_tickets')->onDelete('cascade');
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaint_replies');
    }
};
