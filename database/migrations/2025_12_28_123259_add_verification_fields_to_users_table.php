<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('full_name')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('address')->nullable();
            $table->enum('id_type', ['national_id', 'drivers_license', 'passport', 'other'])->nullable();
            $table->string('government_id')->nullable(); // path to uploaded file
            $table->enum('verification_status', ['unverified', 'pending', 'verified', 'rejected'])->default('unverified');
            $table->timestamp('verified_at')->nullable();
            $table->text('rejection_reason')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'full_name', 'birth_date', 'phone_number', 'address',
                'id_type', 'government_id', 'verification_status',
                'verified_at', 'rejection_reason'
            ]);
        });
    }
        */
};
