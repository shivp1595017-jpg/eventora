<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class OrganizationAdminParticipantController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeParticipantPermission();

        $organization = auth()->user()->currentOrganization();

        if (!$organization) {
            abort(404, 'Organization not found.');
        }

        $eventIds = $organization->events()->pluck('id');

        $participants = Booking::with(['user', 'event'])
            ->whereIn('event_id', $eventIds)
            ->whereIn('booking_status', [
                'pending',
                'confirmed'
            ])
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
            'organization_admin.participants.index',
            compact('organization', 'participants')
        );
    }


    /**
     * Check participant access.
     *
     * Organization Admin:
     * Full access.
     *
     * Organization Staff:
     * Requires view_participants permission.
     */
    private function authorizeParticipantPermission(): void
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
            !in_array('view_participants', $permissions, true)
        ) {
            abort(
                403,
                'You do not have permission to view participants.'
            );
        }
    }
}
