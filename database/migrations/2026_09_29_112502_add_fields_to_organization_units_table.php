<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('organization_units', function (Blueprint $table) {
            $table->foreignId('organization_id')
                ->after('id')
                ->constrained('organizations')
                ->cascadeOnDelete();

            $table->string('name')->after('organization_id');

            $table->string('type')
                ->nullable()
                ->after('name');

            $table->text('description')
                ->nullable()
                ->after('type');

            $table->enum('status', [
                'active',
                'inactive'
            ])
                ->default('active')
                ->after('description');

            $table->unique([
                'organization_id',
                'name'
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('organization_units', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropUnique([
                'organization_units_organization_id_name_unique'
            ]);

            $table->dropColumn([
                'organization_id',
                'name',
                'type',
                'description',
                'status',
            ]);
        });
    }
};