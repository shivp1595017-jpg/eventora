<?php

namespace Tests\Feature\Admin;

use App\Models\Booking;
use App\Models\Event;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_list_filters_by_payment_status_and_creation_date(): void
    {
        $admin = User::factory()->create(['role' => 'super_admin']);
        $inRange = $this->createBooking('PAYMENT-IN-RANGE', 'paid', '2026-10-10 12:00:00');
        $this->createBooking('PAYMENT-OUT-OF-RANGE', 'failed', '2026-09-10 12:00:00');

        $response = $this->actingAs($admin)->get(route('admin.payments.index', [
            'payment_status' => 'paid',
            'date_from' => '2026-10-01',
            'date_to' => '2026-10-31',
        ]));

        $response->assertOk()
            ->assertSee($inRange->booking_number)
            ->assertDontSee('PAYMENT-OUT-OF-RANGE');
    }

    public function test_payment_csv_export_uses_booking_creation_date_filter(): void
    {
        $admin = User::factory()->create(['role' => 'super_admin']);
        $inRange = $this->createBooking('PAYMENT-IN-RANGE', 'paid', '2026-10-10 12:00:00');
        $this->createBooking('PAYMENT-OUT-OF-RANGE', 'paid', '2026-09-10 12:00:00');

        $response = $this->actingAs($admin)->get(route('admin.payments.export', [
            'format' => 'csv',
            'date_from' => '2026-10-01',
            'date_to' => '2026-10-31',
        ]));

        $response->assertOk();
        $this->assertStringContainsString($inRange->booking_number, $response->streamedContent());
        $this->assertStringNotContainsString('PAYMENT-OUT-OF-RANGE', $response->streamedContent());
    }

    private function createBooking(string $bookingNumber, string $paymentStatus, string $createdAt): Booking
    {
        static $sequence = 0;
        $sequence++;

        $user = User::factory()->create();
        $organization = Organization::create([
            'name' => 'Payment Test Organization '.$sequence,
            'slug' => 'payment-test-organization-'.$sequence,
            'type' => 'Company',
        ]);
        $event = Event::create([
            'organization_id' => $organization->id,
            'title' => 'Payment Test Event '.$sequence,
            'slug' => 'payment-test-event-'.$sequence,
            'event_date' => '2026-09-01',
            'status' => 'approved',
        ]);

        $booking = Booking::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'booking_number' => $bookingNumber,
            'payment_status' => $paymentStatus,
            'booking_status' => 'confirmed',
            'total_amount' => 100,
        ]);

        $booking->forceFill(['created_at' => $createdAt])->save();

        return $booking;
    }
}
