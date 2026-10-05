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
        Schema::create('password_otps', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Email
            |--------------------------------------------------------------------------
            */
            $table->string('email')->index();

            /*
            |--------------------------------------------------------------------------
            | Hashed OTP
            |--------------------------------------------------------------------------
            */
            $table->string('otp_hash');

            /*
            |--------------------------------------------------------------------------
            | OTP Expiry
            |--------------------------------------------------------------------------
            */
            $table->timestamp('expires_at');

            /*
            |--------------------------------------------------------------------------
            | OTP Verification
            |--------------------------------------------------------------------------
            */
            $table->timestamp('verified_at')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Used OTP
            |--------------------------------------------------------------------------
            */
            $table->timestamp('used_at')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Failed Attempts
            |--------------------------------------------------------------------------
            */
            $table->unsignedTinyInteger('attempts')
                ->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_otps');
    }
};