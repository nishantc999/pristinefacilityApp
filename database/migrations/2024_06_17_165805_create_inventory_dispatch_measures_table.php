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
        Schema::create('inventory_dispatch_measures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receiver_id')->nullable();
            $table->string('sku_label')->nullable();
            $table->string('sku_quantity')->nullable();
            $table->string('label')->nullable();
            $table->string('image')->default('default.png');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_dispatch_measures');
    }
};
