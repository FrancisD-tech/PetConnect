<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lost_pets', function (Blueprint $table) {
            // Only add contact_phone if it doesn't exist
            if (!Schema::hasColumn('lost_pets', 'contact_phone')) {
                $table->string('contact_phone')->nullable()->after('lost_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('lost_pets', function (Blueprint $table) {
            if (Schema::hasColumn('lost_pets', 'contact_phone')) {
                $table->dropColumn('contact_phone');
            }
        });
    }
};