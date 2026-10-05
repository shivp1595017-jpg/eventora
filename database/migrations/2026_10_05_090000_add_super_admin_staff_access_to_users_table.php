<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', [
                'user', 'organization_admin', 'organization_staff', 'super_admin', 'super_admin_staff',
            ])->default('user')->change();
            $table->json('admin_permissions')->nullable();
        });
    }

    public function down(): void
    {
        DB::table('users')->where('role', 'super_admin_staff')->update(['role' => 'user']);
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('admin_permissions');
            $table->enum('role', [
                'user', 'organization_admin', 'organization_staff', 'super_admin',
            ])->default('user')->change();
        });
    }
};
