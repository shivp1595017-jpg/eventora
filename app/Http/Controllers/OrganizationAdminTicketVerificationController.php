<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class OrganizationAdminTicketVerificationController extends Controller
{
    /**
     * Ticket Verification main page
     */
    public function index()
    {
        $this->authorizeTicketVerificationPermission();

        $organization = auth()->user()->currentOrganization();

        if (!$organization) {
            abort(404, 'Organization not found.');
        }

        return view(
            'organization_admin.ticket_verification.result',
            [
                'booking' => null,
                'organization' => $organization,
                'isValid' => false,
                'message' => null,
            ]
        );
    }


    /**
     * Live ticket search
     */
    public function search(Request $request)
    {
        $this->authorizeTicketVerificationPermission();

        $organization = auth()->user()->currentOrganization();

        if (!$organization) {
            return response()->json([]);
        }

        $search = trim($request->get('q', ''));

        if ($search === '') {
            return response()->json([]);
        }

        $bookings = Booking::with([
            'user',
            'event'
        ])
            ->whereHas('event', function ($query) use ($organization) {
                $query->where(
                    'organization_id',
                    $organization->id
                );
            })
            ->where(function ($query) use ($search) {

                $query->where(
                    'booking_number',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhereHas('user', function ($userQuery) use ($search) {

                    $userQuery
                        ->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');

                })

                ->orWhereHas('event', function ($eventQuery) use ($search) {

                    $eventQuery->where(
                        'title',
                        'like',
                        '%' . $search . '%'
                    );

                });
            })
            ->latest()
            ->limit(10)
            ->get();

        return response()->json(
            $bookings->map(function ($booking) {

                return [
                    'booking_number' => $booking->booking_number,
                    'participant' => $booking->user->name ?? 'N/A',
                    'email' => $booking->user->email ?? 'N/A',
                    'event' => $booking->event->title ?? 'N/A',
                    'payment_status' => $booking->payment_status,
                    'booking_status' => $booking->booking_status,
                ];

            })->values()
        );
    }


    /**
     * Verify ticket
     */
    public function verify($bookingNumber)
    {
        $this->authorizeTicketVerificationPermission();

        $organization = auth()->user()->currentOrganization();

        if (!$organization) {
            abort(404, 'Organization not found.');
        }

        $booking = Booking::with([
            'user',
            'event.organization'
        ])
            ->where('booking_number', $bookingNumber)
            ->first();

        if (!$booking) {

            return view(
                'organization_admin.ticket_verification.result',
                [
                    'booking' => null,
                    'organization' => $organization,
                    'isValid' => false,
                    'message' => 'Invalid ticket. Booking not found.'
                ]
            );
        }


        /*
         * Check whether booking belongs
         * to logged-in organization.
         */
        if (
            !$booking->event ||
            $booking->event->organization_id != $organization->id
        ) {

            return view(
                'organization_admin.ticket_verification.result',
                [
                    'booking' => null,
                    'organization' => $organization,
                    'isValid' => false,
                    'message' => 'This ticket does not belong to your organization.'
                ]
            );
        }


        /*
         * Ticket is valid only when:
         *
         * Payment = paid
         * Booking = confirmed
         */
        $isValid =
            $booking->payment_status === 'paid' &&
            $booking->booking_status === 'confirmed';


        $message = $isValid
            ? 'Valid ticket. Participant is confirmed.'
            : 'Invalid ticket. Payment or booking is not confirmed.';


        return view(
            'organization_admin.ticket_verification.result',
            compact(
                'booking',
                'organization',
                'isValid',
                'message'
            )
        );
    }


    /**
     * Check ticket verification permission.
     *
     * Organization Admin:
     * Full access.
     *
     * Organization Staff:
     * Requires verify_tickets permission.
     */
    private function authorizeTicketVerificationPermission(): void
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | ORGANIZATION ADMIN
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'organization_admin') {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | ORGANIZATION STAFF
        |--------------------------------------------------------------------------
        */

        if ($user->role !== 'organization_staff') {
            abort(403, 'Unauthorized access.');
        }

        $staff = $user->currentOrganizationStaff();

        if (!$staff) {
            abort(
                403,
                'Your staff access is inactive or not assigned.'
            );
        }

        $permissions = $staff->permissions ?? [];

        if (
            !in_array('verify_tickets', $permissions, true)
        ) {
            abort(
                403,
                'You do not have permission to verify tickets.'
            );
        }
    }
}