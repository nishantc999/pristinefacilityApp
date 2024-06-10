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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('emp_code')->nullable();
            $table->unsignedBigInteger('site_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->unsignedBigInteger('shift_id')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('age')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('nominee_name')->nullable();
            $table->boolean('registration_status')->default(0);
            $table->string('dob')->nullable();
            $table->string('date_of_joining')->nullable();
            $table->string('mobile_no')->nullable();    
            $table->string('total_experience')->nullable();
            $table->string('qualification')->nullable();
            $table->string('designation')->nullable();
            $table->string('expertise')->nullable();
            $table->boolean('occupied')->default(0);
            $table->decimal('salary', 8, 2);
            $table->boolean('status')->default(1);
            $table->json('family_detail')->default(json_encode([]));
            // $table->json('documents')->default(json_encode([]));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
