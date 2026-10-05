<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // User who made the booking
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Event being booked
            $table->foreignId('event_id')
                ->constrained()
                ->cascadeOnDelete();

            // Unique booking number
            $table->string('booking_number')->unique();

            // Number of tickets
            $table->unsignedInteger('quantity')->default(1);

            // Price for one ticket
            $table->decimal('ticket_price', 10, 2)->default(0);

            // Total amount
            $table->decimal('total_amount', 10, 2)->default(0);

            // Payment information
            $table->string('payment_id')->nullable();
            $table->string('order_id')->nullable();

            // Payment status
            $table->enum('payment_status', [
                'pending',
                'paid',
                'failed',
                'refunded'
            ])->default('pending');

            // Booking status
            $table->enum('booking_status', [
                'pending',
                'confirmed',
                'cancelled'
            ])->default('pending');

            // QR ticket data
            $table->string('qr_code')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};