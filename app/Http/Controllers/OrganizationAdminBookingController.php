<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrganizationAdminBookingController extends Controller
{
    /**
     * Display organization bookings.
     */
    public function index(Request $request): View
    {
        $this->authorizeBookingPermission('view');

        $organization = auth()->user()->currentOrganization();

        if (!$organization) {
            abort(
                404,
                'Organization not found.'
            );
        }

        $eventIds = $organization
            ->events()
            ->pluck('id');

        $bookings = Booking::with([
                'user',
                'event',
            ])
            ->whereIn(
                'event_id',
                $eventIds
            )
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = trim($request->string('q')->toString());
                $query->where(function ($sub) use ($term) {
                    $sub->where('booking_number', 'like', "%{$term}%")
                        ->orWhereHas('user', fn ($user) => $user->where('name', 'like', "%{$term}%")->orWhere('email', 'like', "%{$term}%"))
                        ->orWhereHas('event', fn ($event) => $event->where('title', 'like', "%{$term}%"));
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view(
            'organization_admin.bookings.index',
            compact(
                'organization',
                'bookings'
            )
        );
    }


    /**
     * Confirm booking.
     */
    public function confirm(
        Booking $booking
    ): RedirectResponse {

        $this->authorizeBookingPermission(
            'manage'
        );


        $this->authorizeOrganizationBooking(
            $booking
        );


        $result = DB::transaction(
            function () use ($booking) {

                /*
                |--------------------------------------------------------------------------
                | Lock Booking
                |--------------------------------------------------------------------------
                */

                $lockedBooking =
                    Booking::with('event')
                        ->lockForUpdate()
                        ->findOrFail(
                            $booking->id
                        );


                /*
                |--------------------------------------------------------------------------
                | Already Cancelled
                |--------------------------------------------------------------------------
                */

                if (
                    $lockedBooking->booking_status ===
                    'cancelled'
                ) {

                    throw new \RuntimeException(
                        'This booking has already been cancelled.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Already Confirmed
                |--------------------------------------------------------------------------
                */

                if (
                    $lockedBooking->booking_status ===
                    'confirmed'
                ) {

                    return 'already_confirmed';
                }


                /*
                |--------------------------------------------------------------------------
                | Payment Validation
                |--------------------------------------------------------------------------
                */

                $isFreeBooking =
                    (float)
                    $lockedBooking->total_amount <= 0;


                if (
                    !$isFreeBooking &&
                    $lockedBooking->payment_status !==
                        'paid'
                ) {

                    throw new \RuntimeException(
                        'This booking cannot be confirmed until the payment is completed.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Free Booking
                |--------------------------------------------------------------------------
                */

                if (
                    $isFreeBooking
                ) {

                    $lockedBooking->payment_status =
                        'paid';
                }


                /*
                |--------------------------------------------------------------------------
                | Confirm Booking
                |--------------------------------------------------------------------------
                */

                $lockedBooking->booking_status =
                    'confirmed';


                /*
                |--------------------------------------------------------------------------
                | Ensure QR Value Exists
                |--------------------------------------------------------------------------
                */

                if (
                    empty(
                        $lockedBooking->qr_code
                    )
                ) {

                    $lockedBooking->qr_code =
                        $lockedBooking->booking_number;
                }


                $lockedBooking->save();


                return 'confirmed';
            }
        );


        if (
            $result ===
            'already_confirmed'
        ) {

            return back()->with(
                'success',
                'This booking is already confirmed.'
            );
        }


        return back()->with(
            'success',
            'Booking confirmed successfully.'
        );
    }


    /**
     * Cancel booking.
     */
    public function cancel(
        Booking $booking
    ): RedirectResponse {

        $this->authorizeBookingPermission(
            'manage'
        );


        $this->authorizeOrganizationBooking(
            $booking
        );


        DB::transaction(
            function () use ($booking) {

                /*
                |--------------------------------------------------------------------------
                | Lock Booking
                |--------------------------------------------------------------------------
                */

                $lockedBooking =
                    Booking::lockForUpdate()
                        ->findOrFail(
                            $booking->id
                        );


                /*
                |--------------------------------------------------------------------------
                | Already Cancelled
                |--------------------------------------------------------------------------
                */

                if (
                    $lockedBooking->booking_status ===
                    'cancelled'
                ) {

                    throw new \RuntimeException(
                        'This booking has already been cancelled.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Lock Event
                |--------------------------------------------------------------------------
                */

                $event =
                    Event::lockForUpdate()
                        ->find(
                            $lockedBooking->event_id
                        );


                if (!$event) {

                    throw new \RuntimeException(
                        'The event associated with this booking was not found.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Release Reserved Seats
                |--------------------------------------------------------------------------
                */

                if (
                    $event->available_seats !== null
                ) {

                    $event->available_seats =
                        $event->available_seats +
                        (int)
                        $lockedBooking->quantity;

                    $event->save();
                }


                /*
                |--------------------------------------------------------------------------
                | Cancel Booking
                |--------------------------------------------------------------------------
                */

                $lockedBooking->update([

                    'booking_status' =>
                        'cancelled',

                ]);
            }
        );


        return back()->with(
            'success',
            'Booking cancelled successfully and reserved seats have been released.'
        );
    }


    /**
     * Make sure user can access only
     * their own organization's booking.
     */
    private function authorizeOrganizationBooking(
        Booking $booking
    ): void {

        $organization =
            auth()->user()
                ->currentOrganization();


        if (!$organization) {

            abort(
                403,
                'No organization is assigned to your account.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Organization Must Own Event
        |--------------------------------------------------------------------------
        */

        $eventBelongsToOrganization =
            $organization
                ->events()
                ->where(
                    'id',
                    $booking->event_id
                )
                ->exists();


        if (
            !$eventBelongsToOrganization
        ) {

            abort(
                403,
                'Unauthorized access.'
            );
        }
    }


    /**
     * Check booking-related permission.
     *
     * Organization Admin:
     * Full access.
     *
     * Organization Staff:
     * Access depends on permissions.
     */
    private function authorizeBookingPermission(
        string $action
    ): void {

        $user =
            auth()->user();


        /*
        |--------------------------------------------------------------------------
        | ORGANIZATION ADMIN
        |--------------------------------------------------------------------------
        */

        if (
            $user->role ===
            'organization_admin'
        ) {

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | ORGANIZATION STAFF
        |--------------------------------------------------------------------------
        */

        if (
            $user->role !==
            'organization_staff'
        ) {

            abort(
                403,
                'Unauthorized access.'
            );
        }


        $staff =
            $user->currentOrganizationStaff();


        if (!$staff) {

            abort(
                403,
                'Your staff access is inactive or not assigned.'
            );
        }


        $permissions =
            $staff->permissions ?? [];


        /*
        |--------------------------------------------------------------------------
        | VIEW BOOKINGS
        |--------------------------------------------------------------------------
        */

        if (
            $action ===
            'view'
        ) {

            if (
                !in_array(
                    'view_bookings',
                    $permissions,
                    true
                ) &&
                !in_array(
                    'manage_bookings',
                    $permissions,
                    true
                )
            ) {

                abort(
                    403,
                    'You do not have permission to view bookings.'
                );
            }


            return;
        }


        /*
        |--------------------------------------------------------------------------
        | MANAGE BOOKINGS
        |--------------------------------------------------------------------------
        */

        if (
            $action ===
            'manage'
        ) {

            if (
                !in_array(
                    'manage_bookings',
                    $permissions,
                    true
                )
            ) {

                abort(
                    403,
                    'You do not have permission to manage bookings.'
                );
            }


            return;
        }


        abort(
            403,
            'Unauthorized access.'
        );
    }
}
