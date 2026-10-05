<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class SuperAdminBookingController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->input('q', ''));
        $paymentStatus = (string) $request->input('payment_status', '');
        $bookingStatus = (string) $request->input('booking_status', '');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $bookings = Booking::query()
            ->with(['user', 'event.organization'])
            ->when($query !== '', function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('booking_number', 'like', "%{$query}%")
                        ->orWhere('payment_id', 'like', "%{$query}%")
                        ->orWhere('order_id', 'like', "%{$query}%")
                        ->orWhereHas('user', function ($user) use ($query) {
                            $user->where('name', 'like', "%{$query}%")
                                ->orWhere('email', 'like', "%{$query}%");
                        })
                        ->orWhereHas('event', function ($event) use ($query) {
                            $event->where('title', 'like', "%{$query}%")
                                ->orWhereHas('organization', function ($org) use ($query) {
                                    $org->where('name', 'like', "%{$query}%");
                                });
                        });
                });
            })
            ->when($paymentStatus !== '', fn ($q) => $q->where('payment_status', $paymentStatus))
            ->when($bookingStatus !== '', fn ($q) => $q->where('booking_status', $bookingStatus))
            ->when($dateFrom, fn ($q) => $q->whereHas('event', fn ($event) => $event->whereDate('event_date', '>=', $dateFrom)))
            ->when($dateTo, fn ($q) => $q->whereHas('event', fn ($event) => $event->whereDate('event_date', '<=', $dateTo)))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $view = $request->ajax()
            ? 'admin.partials.bookings-table'
            : 'admin.bookings.index';

        return view($view, compact('bookings'));
    }

    public function payments(Request $request)
    {
        $query = trim((string) $request->input('q', ''));
        $paymentStatus = (string) $request->input('payment_status', '');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $bookings = Booking::query()
            ->with(['user', 'event.organization'])
            ->where(function ($q) {
                $q->whereNotNull('payment_id')
                    ->orWhereNotNull('order_id')
                    ->orWhereIn('payment_status', ['pending', 'paid', 'failed', 'refunded']);
            })
            ->when($query !== '', function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('booking_number', 'like', "%{$query}%")
                        ->orWhere('payment_id', 'like', "%{$query}%")
                        ->orWhere('order_id', 'like', "%{$query}%")
                        ->orWhereHas('user', function ($user) use ($query) {
                            $user->where('name', 'like', "%{$query}%")
                                ->orWhere('email', 'like', "%{$query}%");
                        })
                        ->orWhereHas('event', function ($event) use ($query) {
                            $event->where('title', 'like', "%{$query}%");
                        });
                });
            })
            ->when($paymentStatus !== '', fn ($q) => $q->where('payment_status', $paymentStatus))
            ->when($dateFrom, fn ($q) => $q->whereDate('created_at', '>=', $dateFrom))
            ->when($dateTo, fn ($q) => $q->whereDate('created_at', '<=', $dateTo))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $view = $request->ajax()
            ? 'admin.partials.payments-table'
            : 'admin.payments.index';

        return view($view, compact('bookings'));
    }
}
