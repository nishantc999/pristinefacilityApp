<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checklist_id');
            $table->unsignedBigInteger('checklist_variable_id');
            $table->decimal('rating', 3, 1); // 3 digits in total with 1 decimal place
            $table->enum('status', ['pending', 'completed', 'revised'])->default('pending');
            $table->unsignedBigInteger('rating_given_by');
            $table->text('remark')->nullable();
            $table->string('media')->nullable(); // Assuming the media will be stored as a string (file path or URL)
            $table->timestamps();

            // Foreign keys
            $table->foreign('checklist_id')->references('id')->on('checklists')->onDelete('cascade');
            $table->foreign('checklist_variable_id')->references('id')->on('variables')->onDelete('cascade');
            $table->foreign('rating_given_by')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedback');
    }
}
