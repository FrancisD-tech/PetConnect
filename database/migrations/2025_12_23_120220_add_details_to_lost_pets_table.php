<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lost_pets', function (Blueprint $table) {
            $table->string('species')->nullable()->after('pet_name');                   
            $table->integer('age')->nullable()->after('breed');                       
            $table->enum('gender', ['male', 'female', 'unknown'])->nullable()->after('age');
            $table->string('contact_phone')->nullable()->after('last_seen_date');       
        });
    }

    public function down(): void
    {
        Schema::table('lost_pets', function (Blueprint $table) {
            $table->dropColumn(['species', 'age', 'gender', 'contact_phone']);
        });
    }
};