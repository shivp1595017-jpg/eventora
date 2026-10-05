<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->foreignId('organization_id')
                ->constrained('organizations')
                ->cascadeOnDelete();

            $table->string('title');
            $table->string('slug')->unique();

            $table->string('category')->nullable();

            $table->text('description')->nullable();

            $table->string('banner')->nullable();

            $table->date('event_date');
            $table->time('event_time')->nullable();

            $table->string('venue')->nullable();
            $table->string('city')->nullable();

            $table->decimal('ticket_price', 10, 2)->default(0);

            $table->integer('total_seats')->nullable();
            $table->integer('available_seats')->nullable();

            $table->enum('status', [
                'draft',
                'pending',
                'approved',
                'rejected',
                'cancelled'
            ])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};