<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use App\Models\OrganizationUnit;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OrganizationAdminEventController extends Controller
{
    /**
     * Display organization's events.
     */
    public function index(Request $request): View
    {
        $this->authorizeEventPermission('view');

        $organization =
            auth()->user()->currentOrganization();

        if (!$organization) {
            abort(
                404,
                'Organization not found.'
            );
        }

        $events = $organization
            ->events()
            ->with('organizationUnit')
            ->withCount([
                'bookings as active_bookings_count' => function ($query) {
                    $query->where(
                        'booking_status',
                        '!=',
                        'cancelled'
                    );
                },
            ])
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = trim($request->string('q')->toString());
                $query->where(function ($sub) use ($term) {
                    $sub->where('title', 'like', "%{$term}%")
                        ->orWhere('venue', 'like', "%{$term}%")
                        ->orWhere('city', 'like', "%{$term}%")
                        ->orWhere('category', 'like', "%{$term}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'organization_admin.events.index',
            compact(
                'organization',
                'events'
            )
        );
    }


    /**
     * Show create event form.
     */
    public function create(): View
    {
        $this->authorizeEventPermission('create');

        $organization =
            auth()->user()->currentOrganization();

        if (!$organization) {
            abort(
                404,
                'Organization not found.'
            );
        }

        $units = OrganizationUnit::where(
                'organization_id',
                $organization->id
            )
            ->where(
                'status',
                'active'
            )
            ->orderBy('name')
            ->get();

        return view(
            'organization_admin.events.create',
            compact(
                'organization',
                'units'
            )
        );
    }


    /**
     * Store new event.
     *
     * Events are live immediately.
     * No separate event approval workflow.
     */
    public function store(
        Request $request
    ): RedirectResponse {

        $this->authorizeEventPermission('create');

        $organization =
            auth()->user()->currentOrganization();

        if (!$organization) {
            abort(
                404,
                'Organization not found.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Validate Event
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'organization_unit_id' => [
                'nullable',
                'integer',
                function (
                    $attribute,
                    $value,
                    $fail
                ) use ($organization) {

                    if (!$value) {
                        return;
                    }

                    $exists =
                        OrganizationUnit::where(
                                'id',
                                $value
                            )
                            ->where(
                                'organization_id',
                                $organization->id
                            )
                            ->where(
                                'status',
                                'active'
                            )
                            ->exists();

                    if (!$exists) {

                        $fail(
                            'The selected organization unit is invalid.'
                        );
                    }
                },
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'category' => [
                'required',
                'string',
                'max:100',
            ],

            'description' => [
                'required',
                'string',
            ],

            'banner' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'event_date' => [
                'required',
                'date',
            ],

            'event_time' => [
                'required',
                'date_format:H:i',
            ],

            'venue' => [
                'required',
                'string',
                'max:255',
            ],

            'city' => [
                'required',
                'string',
                'max:100',
            ],

            'ticket_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'seat_type' => [
                'required',
                'in:limited,unlimited',
            ],

            'total_seats' => [
                'nullable',
                'integer',
                'min:1',
                'required_if:seat_type,limited',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Event Date/Time Must Be Future
        |--------------------------------------------------------------------------
        */

        $eventStart = Carbon::parse(
            $validated['event_date'] .
            ' ' .
            $validated['event_time']
        );


        if (
            $eventStart->lessThanOrEqualTo(
                now()
            )
        ) {

            return back()
                ->withInput()
                ->withErrors([
                    'event_date' =>
                        'Event date and time must be in the future.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Seat Configuration
        |--------------------------------------------------------------------------
        */

        if (
            $validated['seat_type'] ===
            'unlimited'
        ) {

            $validated['total_seats'] =
                null;

            $validated['available_seats'] =
                null;

        } else {

            $validated['available_seats'] =
                (int)
                $validated['total_seats'];
        }


        unset(
            $validated['seat_type']
        );


        /*
        |--------------------------------------------------------------------------
        | Organization
        |--------------------------------------------------------------------------
        */

        $validated['organization_id'] =
            $organization->id;


        /*
        |--------------------------------------------------------------------------
        | Event Is Live Immediately
        |--------------------------------------------------------------------------
        */

        $validated['status'] =
            'approved';


        /*
        |--------------------------------------------------------------------------
        | Generate Unique Slug
        |--------------------------------------------------------------------------
        */

        $validated['slug'] =
            $this->generateUniqueSlug(
                $validated['title']
            );


        /*
        |--------------------------------------------------------------------------
        | Upload Banner
        |--------------------------------------------------------------------------
        */

        if (
            $request->hasFile('banner')
        ) {

            $validated['banner'] =
                $request
                    ->file('banner')
                    ->store(
                        'events',
                        'public'
                    );
        }


        /*
        |--------------------------------------------------------------------------
        | Create Event
        |--------------------------------------------------------------------------
        */

        try {

            Event::create(
                $validated
            );

        } catch (QueryException $e) {

            report($e);

            return back()
                ->withInput()
                ->withErrors([
                    'title' =>
                        'The event could not be created. Please try again.',
                ]);
        }


        return redirect()
            ->route(
                'organization.admin.events.index'
            )
            ->with(
                'success',
                'Event created successfully and is now live.'
            );
    }


    /**
     * Show event details.
     */
    public function show(
        Event $event
    ): View {

        $this->authorizeEventPermission('view');

        $this->authorizeOrganizationEvent(
            $event
        );

        $event->load([
            'organization',
            'organizationUnit',
        ]);

        return view(
            'organization_admin.events.show',
            compact('event')
        );
    }


    /**
     * Show edit form.
     */
    public function edit(
        Event $event
    ): View {

        $this->authorizeEventPermission('manage');

        $this->authorizeOrganizationEvent(
            $event
        );

        $organization =
            auth()->user()->currentOrganization();

        if (!$organization) {
            abort(
                404,
                'Organization not found.'
            );
        }

        $units = OrganizationUnit::where(
                'organization_id',
                $organization->id
            )
            ->where(
                'status',
                'active'
            )
            ->orderBy('name')
            ->get();

        $event->load(
            'organizationUnit'
        );

        return view(
            'organization_admin.events.edit',
            compact(
                'event',
                'organization',
                'units'
            )
        );
    }


    /**
     * Update event.
     */
    public function update(
        Request $request,
        Event $event
    ): RedirectResponse {

        $this->authorizeEventPermission('manage');

        $this->authorizeOrganizationEvent(
            $event
        );

        $organization =
            auth()->user()->currentOrganization();

        if (!$organization) {
            abort(
                404,
                'Organization not found.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Validate Updated Event
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'organization_unit_id' => [
                'nullable',
                'integer',
                function (
                    $attribute,
                    $value,
                    $fail
                ) use ($organization) {

                    if (!$value) {
                        return;
                    }

                    $exists =
                        OrganizationUnit::where(
                                'id',
                                $value
                            )
                            ->where(
                                'organization_id',
                                $organization->id
                            )
                            ->where(
                                'status',
                                'active'
                            )
                            ->exists();

                    if (!$exists) {

                        $fail(
                            'The selected organization unit is invalid.'
                        );
                    }
                },
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'category' => [
                'required',
                'string',
                'max:100',
            ],

            'description' => [
                'required',
                'string',
            ],

            'banner' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'event_date' => [
                'required',
                'date',
            ],

            'event_time' => [
                'required',
                'date_format:H:i',
            ],

            'venue' => [
                'required',
                'string',
                'max:255',
            ],

            'city' => [
                'required',
                'string',
                'max:100',
            ],

            'ticket_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'seat_type' => [
                'required',
                'in:limited,unlimited',
            ],

            'total_seats' => [
                'nullable',
                'integer',
                'min:1',
                'required_if:seat_type,limited',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | New Event Date/Time
        |--------------------------------------------------------------------------
        */

        $newEventStart = Carbon::parse(
            $validated['event_date'] .
            ' ' .
            $validated['event_time']
        );


        $oldEventStart = Carbon::parse(
            $event->event_date .
            ' ' .
            $event->event_time
        );


        /*
        |--------------------------------------------------------------------------
        | Prevent Moving Event To Past
        |--------------------------------------------------------------------------
        */

        $dateTimeChanged =
            $newEventStart->ne(
                $oldEventStart
            );


        if (
            $dateTimeChanged &&
            $newEventStart->lessThanOrEqualTo(
                now()
            )
        ) {

            return back()
                ->withInput()
                ->withErrors([
                    'event_date' =>
                        'The updated event date and time must be in the future.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Transaction
        |--------------------------------------------------------------------------
        |
        | The event row is locked so booking cannot change the reserved
        | seat count while we recalculate available seats.
        |
        */

        try {

            DB::transaction(
                function () use (
                    &$event,
                    $validated,
                    $request
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | Lock Current Event
                    |--------------------------------------------------------------------------
                    */

                    $lockedEvent =
                        Event::lockForUpdate()
                            ->findOrFail(
                                $event->id
                            );


                    /*
                    |--------------------------------------------------------------------------
                    | Reserved Seats
                    |--------------------------------------------------------------------------
                    |
                    | All non-cancelled bookings reserve seats.
                    |
                    */

                    $reservedSeats =
                        (int)
                        Booking::where(
                            'event_id',
                            $lockedEvent->id
                        )
                        ->where(
                            'booking_status',
                            '!=',
                            'cancelled'
                        )
                        ->sum(
                            'quantity'
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | New Seat Configuration
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $validated['seat_type'] ===
                        'unlimited'
                    ) {

                        $validated[
                            'total_seats'
                        ] = null;

                        $validated[
                            'available_seats'
                        ] = null;

                    } else {

                        $newTotalSeats =
                            (int)
                            $validated['total_seats'];


                        /*
                        |--------------------------------------------------------------------------
                        | Cannot Reduce Seats Below Reserved Count
                        |--------------------------------------------------------------------------
                        */

                        if (
                            $newTotalSeats <
                            $reservedSeats
                        ) {

                            throw new \RuntimeException(
                                'Total seats cannot be less than the number of already reserved seats (' .
                                $reservedSeats .
                                ').'
                            );
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Recalculate Available Seats
                        |--------------------------------------------------------------------------
                        */

                        $validated[
                            'available_seats'
                        ] =
                            $newTotalSeats -
                            $reservedSeats;
                    }


                    unset(
                        $validated['seat_type']
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Generate New Slug If Title Changed
                    |--------------------------------------------------------------------------
                    */

                    $newSlug =
                        Str::slug(
                            $validated['title']
                        );


                    if (
                        $newSlug !==
                        $lockedEvent->slug
                    ) {

                        $validated['slug'] =
                            $this->generateUniqueSlug(
                                $validated['title'],
                                $lockedEvent->id
                            );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Upload New Banner
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $request->hasFile(
                            'banner'
                        )
                    ) {

                        $newBanner =
                            $request
                                ->file('banner')
                                ->store(
                                    'events',
                                    'public'
                                );


                        /*
                        |--------------------------------------------------------------------------
                        | Delete Old Banner
                        |--------------------------------------------------------------------------
                        */

                        if (
                            $lockedEvent->banner
                            &&
                            Storage::disk(
                                'public'
                            )->exists(
                                $lockedEvent->banner
                            )
                        ) {

                            Storage::disk(
                                'public'
                            )->delete(
                                $lockedEvent->banner
                            );
                        }


                        $validated['banner'] =
                            $newBanner;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Keep Event Live
                    |--------------------------------------------------------------------------
                    */

                    $validated['status'] =
                        'approved';


                    /*
                    |--------------------------------------------------------------------------
                    | Update Event
                    |--------------------------------------------------------------------------
                    */

                    $lockedEvent->update(
                        $validated
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Return Refreshed Event
                    |--------------------------------------------------------------------------
                    */

                    $event =
                        $lockedEvent->fresh([
                            'organization',
                            'organizationUnit',
                        ]);
                }
            );

        } catch (\RuntimeException $e) {

            return back()
                ->withInput()
                ->withErrors([
                    'total_seats' =>
                        $e->getMessage(),
                ]);

        } catch (QueryException $e) {

            report($e);

            return back()
                ->withInput()
                ->withErrors([
                    'title' =>
                        'The event could not be updated. Please try again.',
                ]);
        }


        return redirect()
            ->route(
                'organization.admin.events.index'
            )
            ->with(
                'success',
                'Event updated successfully.'
            );
    }


    /**
     * Delete event.
     *
     * Events with bookings are not deleted to protect
     * booking/ticket history.
     */
    public function destroy(
        Event $event
    ): RedirectResponse {

        $this->authorizeEventPermission(
            'manage'
        );

        $this->authorizeOrganizationEvent(
            $event
        );


        try {

            DB::transaction(
                function () use ($event) {

                    /*
                    |--------------------------------------------------------------------------
                    | Lock Event
                    |--------------------------------------------------------------------------
                    */

                    $lockedEvent =
                        Event::lockForUpdate()
                            ->findOrFail(
                                $event->id
                            );


                    /*
                    |--------------------------------------------------------------------------
                    | Existing Bookings
                    |--------------------------------------------------------------------------
                    */

                    $hasBookings =
                        Booking::where(
                            'event_id',
                            $lockedEvent->id
                        )->exists();


                    if ($hasBookings) {

                        throw new \RuntimeException(
                            'This event cannot be deleted because booking records already exist. Please keep the event for booking history.'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Delete Banner
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $lockedEvent->banner
                        &&
                        Storage::disk(
                            'public'
                        )->exists(
                            $lockedEvent->banner
                        )
                    ) {

                        Storage::disk(
                            'public'
                        )->delete(
                            $lockedEvent->banner
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Delete Event
                    |--------------------------------------------------------------------------
                    */

                    $lockedEvent->delete();
                }
            );

        } catch (\RuntimeException $e) {

            return back()
                ->with(
                    'error',
                    $e->getMessage()
                );

        } catch (QueryException $e) {

            report($e);

            return back()
                ->with(
                    'error',
                    'The event could not be deleted because it is being used by other records.'
                );
        }


        return redirect()
            ->route(
                'organization.admin.events.index'
            )
            ->with(
                'success',
                'Event deleted successfully.'
            );
    }


    /**
     * Generate unique slug.
     */
    private function generateUniqueSlug(
        string $title,
        ?int $ignoreEventId = null
    ): string {

        $slug =
            Str::slug($title);


        if ($slug === '') {

            $slug =
                'event-' .
                strtolower(
                    Str::random(8)
                );
        }


        $originalSlug =
            $slug;

        $counter = 1;


        while (true) {

            $query =
                Event::where(
                    'slug',
                    $slug
                );


            if ($ignoreEventId) {

                $query->where(
                    'id',
                    '!=',
                    $ignoreEventId
                );
            }


            if (
                !$query->exists()
            ) {

                return $slug;
            }


            $slug =
                $originalSlug .
                '-' .
                $counter;

            $counter++;
        }
    }


    /**
     * Make sure user can access only
     * their own organization's event.
     */
    private function authorizeOrganizationEvent(
        Event $event
    ): void {

        $organization =
            auth()->user()
                ->currentOrganization();


        if (
            !$organization ||
            $event->organization_id !==
                $organization->id
        ) {

            abort(
                403,
                'Unauthorized access.'
            );
        }
    }


    /**
     * Check event-related permission.
     *
     * Organization Admin:
     * Full access.
     *
     * Organization Staff:
     * Access depends on permissions.
     */
    private function authorizeEventPermission(
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
        | VIEW EVENTS
        |--------------------------------------------------------------------------
        */

        if (
            $action ===
            'view'
        ) {

            if (
                !in_array(
                    'view_events',
                    $permissions,
                    true
                )
                &&
                !in_array(
                    'manage_events',
                    $permissions,
                    true
                )
            ) {

                abort(
                    403,
                    'You do not have permission to view events.'
                );
            }


            return;
        }


        /*
        |--------------------------------------------------------------------------
        | CREATE EVENTS
        |--------------------------------------------------------------------------
        */

        if (
            $action ===
            'create'
        ) {

            if (
                !in_array(
                    'create_events',
                    $permissions,
                    true
                )
                &&
                !in_array(
                    'manage_events',
                    $permissions,
                    true
                )
            ) {

                abort(
                    403,
                    'You do not have permission to create events.'
                );
            }


            return;
        }


        /*
        |--------------------------------------------------------------------------
        | MANAGE EVENTS
        |--------------------------------------------------------------------------
        */

        if (
            $action ===
            'manage'
        ) {

            if (
                !in_array(
                    'manage_events',
                    $permissions,
                    true
                )
            ) {

                abort(
                    403,
                    'You do not have permission to manage events.'
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
