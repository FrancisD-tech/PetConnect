<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('lost_pets', function (Blueprint $table) {
            $table->json('images')->nullable()->after('image');
            // Optional: drop old single image column later
        });
    }

    public function down()
    {
        Schema::table('lost_pets', function (Blueprint $table) {
            $table->dropColumn('images');
        });
    }
};
