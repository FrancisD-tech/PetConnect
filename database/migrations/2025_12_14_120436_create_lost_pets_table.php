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
        Schema::create('lost_pets', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained();
        $table->string('pet_name');
        $table->string('breed');
        $table->string('color');
        $table->text('last_seen_location');
        $table->date('lost_date');
        $table->text('description')->nullable();
        $table->string('image');
        $table->boolean('is_reunited')->default(false);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lost_pets');
    }
};
