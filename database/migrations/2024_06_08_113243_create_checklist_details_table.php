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
        Schema::create('checklist_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checklist_id');
            $table->string('label')->nullable();
            $table->float('rating')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();// who give ratting
            $table->text('description')->nullable();
            $table->boolean('status')->default(1);
            $table->foreign('checklist_id')->references('id')->on('checklists')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklist_details');
    }
};
