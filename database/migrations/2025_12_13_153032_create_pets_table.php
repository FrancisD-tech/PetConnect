<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('breed');
            $table->enum('gender', ['male', 'female']);
            $table->integer('age');
            $table->string('image');
            $table->string('status')->default('safe'); // safe, lost, found, adopted
            $table->string('microchip')->nullable();
            $table->boolean('vaccinated')->default(false);
            $table->boolean('neutered')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pets');
    }
};
