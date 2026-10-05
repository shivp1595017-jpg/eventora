<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedInteger('total_seats')
                ->nullable()
                ->change();

            $table->unsignedInteger('available_seats')
                ->nullable()
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedInteger('total_seats')
                ->nullable(false)
                ->change();

            $table->unsignedInteger('available_seats')
                ->nullable(false)
                ->change();
        });
    }
};