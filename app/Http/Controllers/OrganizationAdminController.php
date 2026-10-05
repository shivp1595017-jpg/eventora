<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\View\View;

class OrganizationAdminController extends Controller
{
    /**
     * Organization Admin / Organization Staff Dashboard
     */
    public function dashboard(): View
    {
        // Works for both:
        // organization_admin
        // organization_staff
        $organization = auth()->user()->currentOrganization();

        $totalEvents = 0;
        $totalBookings = 0;
        $totalParticipants = 0;
        $totalRevenue = 0;

        if ($organization) {

            // Get all events belonging to this organization
            $eventIds = $organization->events()->pluck('id');

            // Total events
            $totalEvents = $eventIds->count();

            // Total bookings
            $totalBookings = Booking::whereIn('event_id', $eventIds)
                ->count();

            // Total participants based on ticket quantity
            $totalParticipants = Booking::whereIn('event_id', $eventIds)
                ->whereIn('booking_status', [
                    'pending',
                    'confirmed'
                ])
                ->sum('quantity');

            // Total revenue from successful payments only
            $totalRevenue = Booking::whereIn('event_id', $eventIds)
                ->where('payment_status', 'paid')
                ->sum('total_amount');
        }

        return view(
            'organization_admin.dashboard',
            compact(
                'organization',
                'totalEvents',
                'totalBookings',
                'totalParticipants',
                'totalRevenue'
            )
        );
    }
}