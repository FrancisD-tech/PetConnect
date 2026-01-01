<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('lost_pets', function (Blueprint $table) {
            $table->enum('status', ['active', 'reunited'])->default('active')->after('description');
            $table->timestamp('reunited_at')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('lost_pets', function (Blueprint $table) {
            $table->dropColumn(['status', 'reunited_at']);
        });
    }
};
