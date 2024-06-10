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
        Schema::create('employee_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->string('aadhar_card')->nullable();
            $table->enum('aadhar_card_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('pan_card')->nullable();
            $table->enum('pan_card_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('passbook')->nullable();
            $table->enum('passbook_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('police_verification')->nullable();
            $table->enum('police_verification_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('medical')->nullable();
            $table->enum('medical_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->bigInteger('city_id')->nullable();
            $table->bigInteger('district_id')->nullable();
            $table->bigInteger('state_id')->nullable();
            $table->string('p_address',700)->nullable();
            $table->string('c_address',700)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_details');
    }
};
