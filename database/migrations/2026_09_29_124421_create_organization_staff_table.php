<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organization_staff', function (Blueprint $table) {

            $table->id();

            $table->foreignId('organization_id')
                ->constrained('organizations')
                ->cascadeOnDelete();

            $table->foreignId('organization_unit_id')
                ->nullable()
                ->constrained('organization_units')
                ->nullOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('name');

            $table->string('email');

            $table->string('mobile')
                ->nullable();

            $table->enum('role', [
                'hod',
                'faculty',
                'staff'
            ])->default('staff');

            $table->json('permissions')
                ->nullable();

            $table->enum('status', [
                'active',
                'inactive'
            ])->default('active');

            $table->timestamps();

            $table->unique([
                'organization_id',
                'email'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organization_staff');
    }
};