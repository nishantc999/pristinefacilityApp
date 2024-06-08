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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->boolean('status')->default(1);
            $table->json('lines')->default(json_encode([]));
            $table->boolean('is_employee')->default(0);
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('profile')->default('user.png');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade'); //client employee blong to client 
            $table->unsignedBigInteger('project_manager_id')->nullable();
            $table->text('description')->nullable();
            $table->string('password');
            $table->boolean('profile_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
