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
        Schema::table('adoptable_pets', function (Blueprint $table) {
            // Add the column as nullable first
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            
            // Optional: Add index
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('adoptable_pets', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
