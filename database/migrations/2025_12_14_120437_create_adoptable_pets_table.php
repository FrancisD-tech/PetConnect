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
        Schema::create('adoptable_pets', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('breed');
        $table->integer('age_months');
        $table->enum('gender', ['male', 'female']);
        $table->text('description');
        $table->string('image_main');
        $table->json('images_gallery')->nullable();
        $table->string('location');
        $table->boolean('is_adopted')->default(false);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adoptable_pets');
    }
};
