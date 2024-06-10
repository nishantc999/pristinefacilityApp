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
        Schema::table('checklists', function (Blueprint $table) {
            $table->unsignedBigInteger('site_id')->nullable()->change();
            $table->unsignedBigInteger('shift_id')->nullable()->change();
            $table->json('variables')->nullable(); // Adding the new JSON column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checklists', function (Blueprint $table) {
            $table->unsignedBigInteger('site_id')->nullable(false)->change();
            $table->unsignedBigInteger('shift_id')->nullable(false)->change();
            $table->dropColumn('variables'); // Removing the JSON column
        });
    }
};
