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
        Schema::create('found_pets', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained();
        $table->string('pet_name')->nullable();
        $table->string('breed')->nullable();
        $table->string('color');
        $table->text('found_location');
        $table->date('found_date');
        $table->text('description')->nullable();
        $table->string('image');
        $table->boolean('is_claimed')->default(false);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('found_pets');
    }
};
