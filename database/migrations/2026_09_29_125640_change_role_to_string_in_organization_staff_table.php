<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('organization_staff', function (Blueprint $table) {
            $table->string('role')
                ->default('staff')
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('organization_staff', function (Blueprint $table) {
            $table->enum('role', [
                'hod',
                'faculty',
                'staff',
            ])
                ->default('staff')
                ->change();
        });
    }
};