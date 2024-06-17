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
        Schema::create('complaint_tickets', function (Blueprint $table) {
            $table->id();
           
            $table->unsignedBigInteger('employee_id');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('complainer_id')->nullable();
            $table->unsignedBigInteger('closer_id')->nullable();
           
            $table->text('subject')->nullable();
           
            $table->enum('ticket_status', ['opened', 'closed'])->default('opened');
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('complainer_id')->references('id')->on('clients')->onDelete('set null');
            $table->foreign('closer_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaint_tickets');
    }
};
