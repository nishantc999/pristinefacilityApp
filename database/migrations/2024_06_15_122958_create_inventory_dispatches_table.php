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
        Schema::create('inventory_dispatches', function (Blueprint $table) {
            $table->id();
            $table->string('dispatchNumber')->unique();
            $table->string('sendor')->nullable();
            $table->unsignedBigInteger('receiver_id')->nullable();
            $table->string('sendingDate')->nullable();
            $table->string('receivingDate')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('shift_id')->nullable();
             $table->string('req')->nullable();
            $table->enum('status', ['dispatched', 'received', 'rejected'])->default('dispatched');
            $table->text('product_quantity')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_dispatches');
    }
};
