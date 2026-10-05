<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Razorpay\Api\Api;

class BookingController extends Controller
{
    /**
     * Display booking page.
     */
    public function create(string $slug): View|RedirectResponse
    {
        $event = Event::with('organization')
            ->where('slug', $slug)
            ->where('status', 'approved')
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Prevent Booking For Past Events
        |--------------------------------------------------------------------------
        */

        if ($this->eventHasStarted($event)) {
            return redirect()
                ->route('events.show', $event->slug)
                ->with(
                    'error',
                    'This event is no longer available for booking.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Sold Out Check
        |--------------------------------------------------------------------------
        */

        if (
            $event->available_seats !== null &&
            $event->available_seats <= 0
        ) {
            return redirect()
                ->route('events.show', $event->slug)
                ->with(
                    'error',
                    'This event is sold out.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Already Registered Check
        |--------------------------------------------------------------------------
        */

        $alreadyBooked = Booking::where(
                'user_id',
                auth()->id()
            )
            ->where(
                'event_id',
                $event->id
            )
            ->exists();

        if ($alreadyBooked) {
            return redirect()
                ->route(
                    'events.show',
                    $event->slug
                )
                ->with(
                    'error',
                    'You have already registered for this event.'
                );
        }

        return view(
            'bookings.create',
            compact('event')
        );
    }


    /**
     * Store a new booking.
     *
     * Rule:
     * One registered account = one ticket per event.
     */
    public function store(
        Request $request,
        string $slug
    ): RedirectResponse {

        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | Quantity Is Always 1
        |--------------------------------------------------------------------------
        |
        | We intentionally DO NOT trust the submitted quantity.
        | Even if someone changes the hidden input to 5,
        | backend will still create only 1 ticket.
        |
        */

        $quantity = 1;


        /*
        |--------------------------------------------------------------------------
        | Database Transaction
        |--------------------------------------------------------------------------
        |
        | Lock event row to prevent simultaneous overbooking.
        |
        */

        try {

            $result = DB::transaction(function () use (
                $slug,
                $user,
                $quantity
            ) {

                /*
                |--------------------------------------------------------------------------
                | Lock Event
                |--------------------------------------------------------------------------
                */

                $event = Event::with('organization')
                    ->where(
                        'slug',
                        $slug
                    )
                    ->where(
                        'status',
                        'approved'
                    )
                    ->lockForUpdate()
                    ->firstOrFail();


                /*
                |--------------------------------------------------------------------------
                | Past Event
                |--------------------------------------------------------------------------
                */

                if (
                    $this->eventHasStarted(
                        $event
                    )
                ) {

                    throw new \RuntimeException(
                        'This event is no longer available for booking.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | One User / One Event
                |--------------------------------------------------------------------------
                */

                $existingBooking =
                    Booking::where(
                        'user_id',
                        $user->id
                    )
                    ->where(
                        'event_id',
                        $event->id
                    )
                    ->lockForUpdate()
                    ->first();


                if ($existingBooking) {

                    /*
                    |--------------------------------------------------------------------------
                    | Existing Pending Booking
                    |--------------------------------------------------------------------------
                    |
                    | Let user continue payment instead of creating
                    | another booking.
                    |
                    */

                    if (
                        $existingBooking->booking_status ===
                        'pending'
                        &&
                        $existingBooking->payment_status !==
                        'paid'
                    ) {

                        return [
                            'existing_booking' =>
                                $existingBooking,
                        ];
                    }


                    throw new \RuntimeException(
                        'You have already registered for this event.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Seat Availability
                |--------------------------------------------------------------------------
                */

                if (
                    $event->available_seats !== null
                    &&
                    $event->available_seats < 1
                ) {

                    throw new \RuntimeException(
                        'This event is sold out.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Ticket Price
                |--------------------------------------------------------------------------
                */

                $ticketPrice =
                    (float) $event->ticket_price;


                /*
                |--------------------------------------------------------------------------
                | Total Amount
                |--------------------------------------------------------------------------
                */

                $totalAmount =
                    round(
                        $ticketPrice,
                        2
                    );


                /*
                |--------------------------------------------------------------------------
                | Generate Unique Booking Number
                |--------------------------------------------------------------------------
                */

                do {

                    $bookingNumber =
                        'EVT-' .
                        strtoupper(
                            Str::random(10)
                        );

                } while (
                    Booking::where(
                        'booking_number',
                        $bookingNumber
                    )->exists()
                );


                /*
                |--------------------------------------------------------------------------
                | Free Event
                |--------------------------------------------------------------------------
                */

                $isFreeEvent =
                    $totalAmount <= 0;


                /*
                |--------------------------------------------------------------------------
                | Create Booking
                |--------------------------------------------------------------------------
                */

                $booking = Booking::create([

                    'user_id' =>
                        $user->id,

                    'event_id' =>
                        $event->id,

                    'booking_number' =>
                        $bookingNumber,

                    'quantity' =>
                        1,

                    'ticket_price' =>
                        $ticketPrice,

                    'total_amount' =>
                        $totalAmount,

                    'payment_id' =>
                        null,

                    'order_id' =>
                        null,

                    'payment_status' =>
                        $isFreeEvent
                            ? 'paid'
                            : 'pending',

                    'booking_status' =>
                        $isFreeEvent
                            ? 'confirmed'
                            : 'pending',

                    'qr_code' =>
                        $bookingNumber,

                ]);


                /*
                |--------------------------------------------------------------------------
                | Reserve Exactly One Seat
                |--------------------------------------------------------------------------
                */

                if (
                    $event->available_seats !== null
                ) {

                    $event->available_seats =
                        $event->available_seats - 1;

                    $event->save();
                }


                return [

                    'booking' =>
                        $booking,

                    'is_free' =>
                        $isFreeEvent,

                ];
            });


            /*
            |--------------------------------------------------------------------------
            | Existing Pending Booking
            |--------------------------------------------------------------------------
            */

            if (
                isset(
                    $result['existing_booking']
                )
            ) {

                return redirect()
                    ->route(
                        'bookings.payment',
                        $result['existing_booking']->id
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Free Booking
            |--------------------------------------------------------------------------
            */

            if (
                $result['is_free'] === true
            ) {

                return redirect()
                    ->route(
                        'bookings.ticket',
                        $result['booking']->id
                    )
                    ->with(
                        'success',
                        'Your registration has been confirmed successfully.'
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Paid Booking
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route(
                    'bookings.payment',
                    $result['booking']->id
                );


        } catch (QueryException $e) {

            /*
            |--------------------------------------------------------------------------
            | Duplicate Booking Protection
            |--------------------------------------------------------------------------
            */

            if (
                str_contains(
                    strtolower(
                        $e->getMessage()
                    ),
                    'bookings_user_event_unique'
                )
            ) {

                return back()
                    ->with(
                        'error',
                        'You have already registered for this event.'
                    );
            }


            report($e);

            return back()
                ->with(
                    'error',
                    'Booking could not be created. Please try again.'
                );


        } catch (\RuntimeException $e) {

            return back()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }


    /**
     * Display payment page and create/reuse Razorpay order.
     */
    public function payment(
        int $id
    ): View|RedirectResponse {

        $booking = Booking::with([
            'event.organization',
        ])
            ->where(
                'user_id',
                auth()->id()
            )
            ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Already Paid
        |--------------------------------------------------------------------------
        */

        if (
            $booking->payment_status ===
            'paid'
        ) {

            return redirect()
                ->route(
                    'bookings.ticket',
                    $booking->id
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Cancelled Booking
        |--------------------------------------------------------------------------
        */

        if (
            $booking->booking_status ===
            'cancelled'
        ) {

            return redirect()
                ->route(
                    'events.show',
                    $booking->event->slug
                )
                ->with(
                    'error',
                    'This booking has been cancelled.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Event Started
        |--------------------------------------------------------------------------
        */

        if (
            $this->eventHasStarted(
                $booking->event
            )
        ) {

            DB::transaction(
                function () use ($booking) {

                    $lockedBooking =
                        Booking::lockForUpdate()
                            ->find(
                                $booking->id
                            );

                    if (!$lockedBooking) {
                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Don't Release Twice
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $lockedBooking->booking_status ===
                        'cancelled'
                    ) {
                        return;
                    }


                    $event =
                        Event::lockForUpdate()
                            ->find(
                                $lockedBooking->event_id
                            );


                    if (
                        $event &&
                        $event->available_seats !== null
                    ) {

                        $event->available_seats +=
                            (int)
                            $lockedBooking->quantity;

                        $event->save();
                    }


                    $lockedBooking->update([

                        'booking_status' =>
                            'cancelled',

                        'payment_status' =>
                            'failed',

                    ]);
                }
            );


            return redirect()
                ->route(
                    'events.show',
                    $booking->event->slug
                )
                ->with(
                    'error',
                    'This event has already started. Your pending booking was cancelled.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Free Event
        |--------------------------------------------------------------------------
        */

        if (
            (float) $booking->total_amount <= 0
        ) {

            $booking->update([

                'payment_status' =>
                    'paid',

                'booking_status' =>
                    'confirmed',

                'qr_code' =>
                    $booking->booking_number,

            ]);


            return redirect()
                ->route(
                    'bookings.ticket',
                    $booking->id
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Razorpay API
        |--------------------------------------------------------------------------
        */

        $api = new Api(

            config(
                'services.razorpay.key'
            ),

            config(
                'services.razorpay.secret'
            )

        );


        /*
        |--------------------------------------------------------------------------
        | Amount In Paise
        |--------------------------------------------------------------------------
        */

        $amount =
            (int) round(
                (
                    (float)
                    $booking->total_amount
                ) * 100
            );


        if (
            $amount <= 0
        ) {

            return back()
                ->with(
                    'error',
                    'Invalid payment amount.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Reuse Existing Razorpay Order
        |--------------------------------------------------------------------------
        */

        $order = null;


        if (
            $booking->order_id
        ) {

            try {

                $existingOrder =
                    $api->order->fetch(
                        $booking->order_id
                    );


                if (
                    $existingOrder
                    &&
                    isset(
                        $existingOrder['id']
                    )
                    &&
                    (int)
                    $existingOrder['amount'] ===
                    $amount
                    &&
                    $existingOrder['currency'] ===
                    'INR'
                ) {

                    $order =
                        $existingOrder;
                }


            } catch (\Throwable $e) {

                $order = null;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Create Razorpay Order
        |--------------------------------------------------------------------------
        */

        if (!$order) {

            try {

                $order =
                    $api->order->create([

                        'receipt' =>
                            $booking->booking_number,

                        'amount' =>
                            $amount,

                        'currency' =>
                            'INR',

                    ]);


                $booking->update([

                    'order_id' =>
                        $order['id'],

                ]);


            } catch (\Throwable $e) {

                report($e);


                return back()
                    ->with(
                        'error',
                        'Payment order could not be created. Please try again.'
                    );
            }
        }


        return view(
            'bookings.payment',
            compact(
                'booking',
                'order'
            )
        );
    }


    /**
     * Verify successful Razorpay payment.
     */
    public function paymentSuccess(
        Request $request,
        int $id
    ): View|RedirectResponse {

        $booking = Booking::with('event')
            ->where(
                'user_id',
                auth()->id()
            )
            ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Already Paid
        |--------------------------------------------------------------------------
        */

        if (
            $booking->payment_status ===
            'paid'
        ) {

            return view(
                'bookings.success',
                compact('booking')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Validate Payment Response
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'payment_id' => [
                'required',
                'string',
                'max:255',
            ],

            'razorpay_order_id' => [
                'required',
                'string',
                'max:255',
            ],

            'razorpay_signature' => [
                'required',
                'string',
                'max:500',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Order Must Match Booking
        |--------------------------------------------------------------------------
        */

        if (
            !$booking->order_id
            ||
            !hash_equals(
                (string)
                $booking->order_id,
                (string)
                $validated[
                    'razorpay_order_id'
                ]
            )
        ) {

            return redirect()
                ->route(
                    'bookings.payment',
                    $booking->id
                )
                ->with(
                    'error',
                    'Payment order does not match this booking.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Razorpay API
        |--------------------------------------------------------------------------
        */

        $api = new Api(

            config(
                'services.razorpay.key'
            ),

            config(
                'services.razorpay.secret'
            )

        );


        try {

            /*
            |--------------------------------------------------------------------------
            | Verify Signature
            |--------------------------------------------------------------------------
            */

            $api->utility
                ->verifyPaymentSignature([

                    'razorpay_order_id' =>
                        $validated[
                            'razorpay_order_id'
                        ],

                    'razorpay_payment_id' =>
                        $validated[
                            'payment_id'
                        ],

                    'razorpay_signature' =>
                        $validated[
                            'razorpay_signature'
                        ],

                ]);


            /*
            |--------------------------------------------------------------------------
            | Fetch Payment
            |--------------------------------------------------------------------------
            */

            $payment =
                $api->payment->fetch(
                    $validated['payment_id']
                );


            /*
            |--------------------------------------------------------------------------
            | Verify Order ID
            |--------------------------------------------------------------------------
            */

            if (
                !isset(
                    $payment['order_id']
                )
                ||
                $payment['order_id'] !==
                    $booking->order_id
            ) {

                throw new \RuntimeException(
                    'Razorpay payment order mismatch.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Verify Amount
            |--------------------------------------------------------------------------
            */

            $expectedAmount =
                (int) round(
                    (
                        (float)
                        $booking->total_amount
                    ) * 100
                );


            if (
                !isset(
                    $payment['amount']
                )
                ||
                (int)
                $payment['amount'] !==
                    $expectedAmount
            ) {

                throw new \RuntimeException(
                    'Razorpay payment amount mismatch.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Currency
            |--------------------------------------------------------------------------
            */

            if (
                isset(
                    $payment['currency']
                )
                &&
                $payment['currency'] !==
                    'INR'
            ) {

                throw new \RuntimeException(
                    'Invalid payment currency.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Captured Payment
            |--------------------------------------------------------------------------
            */

            if (
                isset(
                    $payment['status']
                )
                &&
                $payment['status'] !==
                    'captured'
            ) {

                throw new \RuntimeException(
                    'Payment has not been captured yet.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Final Booking Update
            |--------------------------------------------------------------------------
            */

            DB::transaction(
                function () use (
                    $validated,
                    $booking
                ) {

                    $lockedBooking =
                        Booking::lockForUpdate()
                            ->findOrFail(
                                $booking->id
                            );


                    /*
                    |--------------------------------------------------------------------------
                    | Already Completed
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $lockedBooking
                            ->payment_status ===
                        'paid'
                    ) {

                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Cancelled Booking
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $lockedBooking
                            ->booking_status ===
                        'cancelled'
                    ) {

                        throw new \RuntimeException(
                            'This booking has already been cancelled.'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Confirm Booking
                    |--------------------------------------------------------------------------
                    */

                    $lockedBooking->update([

                        'payment_id' =>
                            $validated[
                                'payment_id'
                            ],

                        'order_id' =>
                            $validated[
                                'razorpay_order_id'
                            ],

                        'payment_status' =>
                            'paid',

                        'booking_status' =>
                            'confirmed',

                        'qr_code' =>
                            $lockedBooking
                                ->booking_number,

                    ]);
                }
            );


            /*
            |--------------------------------------------------------------------------
            | Refresh
            |--------------------------------------------------------------------------
            */

            $booking->refresh();


            return view(
                'bookings.success',
                compact('booking')
            );


        } catch (\Throwable $e) {

            report($e);


            /*
            |--------------------------------------------------------------------------
            | Payment Failed
            |--------------------------------------------------------------------------
            |
            | Seat stays reserved so this same booking can retry payment.
            |
            */

            $booking->update([
                'payment_status' =>
                    'failed',
            ]);


            return redirect()
                ->route(
                    'bookings.payment',
                    $booking->id
                )
                ->with(
                    'error',
                    'Payment verification failed. Please try again.'
                );
        }
    }


    /**
     * Display user's bookings.
     */
    public function index(): View
    {
        $bookings = Booking::with([
            'event.organization',
        ])
            ->where(
                'user_id',
                auth()->id()
            )
            ->latest()
            ->get();


        return view(
            'bookings.index',
            compact('bookings')
        );
    }


    /**
     * Display ticket.
     */
    public function ticket(
        int $id
    ): View {

        $booking = Booking::with([
            'event.organization',
            'user',
        ])
            ->where(
                'user_id',
                auth()->id()
            )
            ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Ticket Only For Confirmed/Paid Booking
        |--------------------------------------------------------------------------
        */

        if (
            $booking->payment_status !==
            'paid'
            ||
            $booking->booking_status ===
            'cancelled'
        ) {

            abort(
                403,
                'Your ticket is not available yet.'
            );
        }


        return view(
            'bookings.ticket',
            compact('booking')
        );
    }


    /**
     * Check whether an event has started.
     */
    private function eventHasStarted(
        Event $event
    ): bool {

        $eventTime =
            $event->event_time
            ?: '23:59:59';


        $eventDateTime =
            Carbon::parse(
                $event->event_date .
                ' ' .
                $eventTime
            );


        return now()->greaterThan(
            $eventDateTime
        );
    }
}