<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use App\Models\Organization;
use App\Models\User;

class SuperAdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'stats' => [
                'organizations' => Organization::count(),
                'users' => User::count(),
                'events' => Event::count(),
                'bookings' => Booking::count(),
                'organization_admins' => User::where('role', 'organization_admin')->count(),
                'upcoming_events' => Event::whereDate('event_date', '>=', now()->toDateString())->count(),
                'paid_bookings' => Booking::where('payment_status', 'paid')->count(),
                'pending_payments' => Booking::where('payment_status', 'pending')->count(),
            ],
            'recentOrganizations' => Organization::query()
                ->latest()
                ->take(5)
                ->get(),
            'recentEvents' => Event::query()
                ->with('organization')
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }
}
