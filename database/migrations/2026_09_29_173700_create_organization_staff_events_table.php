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
        Schema::create('organization_staff_events', function (Blueprint $table) {

            $table->id();

            $table->foreignId('organization_staff_id')
                ->constrained('organization_staff')
                ->cascadeOnDelete();

            $table->foreignId('event_id')
                ->constrained('events')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(
                [
                    'organization_staff_id',
                    'event_id'
                ],
                'staff_event_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_staff_events');
    }
};