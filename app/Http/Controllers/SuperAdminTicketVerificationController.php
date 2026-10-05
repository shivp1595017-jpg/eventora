<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class SuperAdminTicketVerificationController extends Controller
{
    public function index()
    {
        return view('admin.ticket-verification.index');
    }

    public function search(Request $request)
    {
        $term = trim((string) $request->query('q', ''));
        if ($term === '') {
            return response()->json([]);
        }

        return response()->json(Booking::with(['user', 'event.organization'])
            ->where(function ($query) use ($term) {
                $query->where('booking_number', 'like', "%{$term}%")
                    ->orWhereHas('user', fn ($user) => $user->where('name', 'like', "%{$term}%")->orWhere('email', 'like', "%{$term}%"))
                    ->orWhereHas('event', fn ($event) => $event->where('title', 'like', "%{$term}%"));
            })
            ->latest()->limit(10)->get()
            ->map(fn (Booking $booking) => [
                'booking_number' => $booking->booking_number,
                'participant' => $booking->user?->name ?? 'N/A',
                'event' => $booking->event?->title ?? 'N/A',
                'organization' => $booking->event?->organization?->name ?? 'N/A',
                'payment_status' => $booking->payment_status,
                'booking_status' => $booking->booking_status,
                'url' => route('admin.ticket-verification.verify', $booking->booking_number),
            ])->values());
    }

    public function verify(string $bookingNumber)
    {
        $booking = Booking::with(['user', 'event.organization'])
            ->where('booking_number', $bookingNumber)->first();

        $isValid = $booking && $booking->event
            && $booking->payment_status === 'paid'
            && $booking->booking_status === 'confirmed';

        return view('admin.ticket-verification.result', compact('booking', 'isValid'));
    }
}
