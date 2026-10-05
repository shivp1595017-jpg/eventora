<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use App\Models\Organization;
use App\Models\OrganizationUnit;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class SuperAdminEventController extends Controller
{
    public function index(Request $request): View
    {
        $query = trim((string) $request->input('q', ''));
        $status = (string) $request->input('status', '');
        $category = (string) $request->input('category', '');
        $city = trim((string) $request->input('city', ''));
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $events = Event::query()
            ->with('organization')
            ->withCount('bookings')
            ->when($query !== '', function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('title', 'like', "%{$query}%")
                        ->orWhere('slug', 'like', "%{$query}%")
                        ->orWhere('category', 'like', "%{$query}%")
                        ->orWhere('city', 'like', "%{$query}%")
                        ->orWhere('venue', 'like', "%{$query}%")
                        ->orWhereHas('organization', function ($org) use ($query) {
                            $org->where('name', 'like', "%{$query}%");
                        });
                });
            })
            ->when($status !== '', fn ($q) => $q->where('status', $status))
            ->when($category !== '', fn ($q) => $q->where('category', $category))
            ->when($city !== '', fn ($q) => $q->where('city', 'like', "%{$city}%"))
            ->when($dateFrom, fn ($q) => $q->whereDate('event_date', '>=', $dateFrom))
            ->when($dateTo, fn ($q) => $q->whereDate('event_date', '<=', $dateTo))
            ->latest('event_date')
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        $categories = Event::query()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $cities = Event::query()
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        $view = $request->ajax()
            ? 'admin.partials.events-table'
            : 'admin.events.index';

        return view($view, compact('events', 'categories', 'cities'));
    }

    public function print(Request $request): View
    {
        $query = trim((string) $request->input('q', ''));

        $events = Event::query()
            ->with('organization')
            ->withCount('bookings')
            ->when($query !== '', function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('title', 'like', "%{$query}%")
                        ->orWhere('city', 'like', "%{$query}%")
                        ->orWhereHas('organization', fn ($org) => $org->where('name', 'like', "%{$query}%"));
                });
            })
            ->latest('event_date')
            ->get();

        return view('admin.events.print', compact('events'));
    }

    public function create(): View
    {
        [$organizations, $units] = $this->eventFormData();

        return view('admin.events.create', compact('organizations', 'units'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateEvent($request);

        $organization = Organization::whereKey($validated['organization_id'])
            ->where('status', 'approved')
            ->firstOrFail();

        $this->validateUnitForOrganization($validated['organization_unit_id'] ?? null, $organization->id);
        $this->ensureFutureDateTime($validated['event_date'], $validated['event_time']);

        if ($validated['seat_type'] === 'unlimited') {
            $validated['total_seats'] = null;
            $validated['available_seats'] = null;
        } else {
            $validated['available_seats'] = (int) $validated['total_seats'];
        }

        unset($validated['seat_type']);

        $validated['status'] = 'approved';
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);

        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('events', 'public');
        }

        try {
            Event::create($validated);
        } catch (QueryException $e) {
            report($e);

            return back()->withInput()->withErrors([
                'title' => 'The event could not be created. Please try again.',
            ]);
        }

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event created successfully and is now live.');
    }

    public function show(Event $event): View
    {
        $event->load(['organization', 'organizationUnit'])->loadCount('bookings');

        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event): View
    {
        [$organizations, $units] = $this->eventFormData();
        $event->load(['organization', 'organizationUnit']);

        return view('admin.events.edit', compact('event', 'organizations', 'units'));
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $validated = $this->validateEvent($request);

        $organization = Organization::whereKey($validated['organization_id'])
            ->where('status', 'approved')
            ->firstOrFail();

        $this->validateUnitForOrganization($validated['organization_unit_id'] ?? null, $organization->id);

        $newEventStart = Carbon::parse($validated['event_date'] . ' ' . $validated['event_time']);
        $oldEventStart = Carbon::parse($event->event_date . ' ' . $event->event_time);
        $dateTimeChanged = $newEventStart->ne($oldEventStart);

        if ($dateTimeChanged && $newEventStart->lessThanOrEqualTo(now())) {
            return back()->withInput()->withErrors([
                'event_date' => 'The updated event date and time must be in the future.',
            ]);
        }

        try {
            DB::transaction(function () use (&$event, $validated, $request, $organization) {
                $lockedEvent = Event::lockForUpdate()->findOrFail($event->id);
                $reservedSeats = (int) Booking::where('event_id', $lockedEvent->id)
                    ->where('booking_status', '!=', 'cancelled')
                    ->sum('quantity');

                if ((int) $lockedEvent->organization_id !== (int) $organization->id && $reservedSeats > 0) {
                    throw new \RuntimeException(
                        'This event cannot be moved to another organization because booking records already exist.'
                    );
                }

                if ($validated['seat_type'] === 'unlimited') {
                    $validated['total_seats'] = null;
                    $validated['available_seats'] = null;
                } else {
                    $newTotalSeats = (int) $validated['total_seats'];

                    if ($newTotalSeats < $reservedSeats) {
                        throw new \RuntimeException(
                            'Total seats cannot be less than the number of already reserved seats (' .
                            $reservedSeats .
                            ').'
                        );
                    }

                    $validated['available_seats'] = $newTotalSeats - $reservedSeats;
                }

                unset($validated['seat_type']);

                if (Str::slug($validated['title']) !== $lockedEvent->slug) {
                    $validated['slug'] = $this->generateUniqueSlug($validated['title'], $lockedEvent->id);
                }

                if ($request->hasFile('banner')) {
                    $newBanner = $request->file('banner')->store('events', 'public');

                    if ($lockedEvent->banner && Storage::disk('public')->exists($lockedEvent->banner)) {
                        Storage::disk('public')->delete($lockedEvent->banner);
                    }

                    $validated['banner'] = $newBanner;
                }

                $validated['status'] = 'approved';
                $lockedEvent->update($validated);
                $event = $lockedEvent->fresh(['organization', 'organizationUnit']);
            });
        } catch (\RuntimeException $e) {
            return back()->withInput()->withErrors([
                'total_seats' => $e->getMessage(),
            ]);
        } catch (QueryException $e) {
            report($e);

            return back()->withInput()->withErrors([
                'title' => 'The event could not be updated. Please try again.',
            ]);
        }

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        try {
            DB::transaction(function () use ($event) {
                $lockedEvent = Event::lockForUpdate()->findOrFail($event->id);

                if (Booking::where('event_id', $lockedEvent->id)->exists()) {
                    throw new \RuntimeException(
                        'This event cannot be deleted because booking records already exist. Please keep the event for booking history.'
                    );
                }

                if ($lockedEvent->banner && Storage::disk('public')->exists($lockedEvent->banner)) {
                    Storage::disk('public')->delete($lockedEvent->banner);
                }

                $lockedEvent->delete();
            });
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        } catch (QueryException $e) {
            report($e);

            return back()->with(
                'error',
                'The event could not be deleted because it is being used by other records.'
            );
        }

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }

    private function eventFormData(): array
    {
        $organizations = Organization::query()
            ->where('status', 'approved')
            ->orderBy('name')
            ->get(['id', 'name', 'city']);

        $units = OrganizationUnit::query()
            ->where('status', 'active')
            ->whereIn('organization_id', $organizations->pluck('id'))
            ->with('organization:id,name')
            ->orderBy('name')
            ->get();

        return [$organizations, $units];
    }

    private function validateEvent(Request $request): array
    {
        return $request->validate([
            'organization_id' => ['required', 'integer', 'exists:organizations,id'],
            'organization_unit_id' => ['nullable', 'integer'],
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'banner' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'event_date' => ['required', 'date'],
            'event_time' => ['required', 'date_format:H:i'],
            'venue' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'ticket_price' => ['required', 'numeric', 'min:0'],
            'seat_type' => ['required', 'in:limited,unlimited'],
            'total_seats' => ['nullable', 'integer', 'min:1', 'required_if:seat_type,limited'],
        ]);
    }

    private function validateUnitForOrganization(?int $unitId, int $organizationId): void
    {
        if (!$unitId) {
            return;
        }

        $exists = OrganizationUnit::whereKey($unitId)
            ->where('organization_id', $organizationId)
            ->where('status', 'active')
            ->exists();

        if (!$exists) {
            throw ValidationException::withMessages([
                'organization_unit_id' => 'The selected organization unit is invalid for this organization.',
            ]);
        }
    }

    private function ensureFutureDateTime(string $date, string $time): void
    {
        $eventStart = Carbon::parse($date . ' ' . $time);

        if ($eventStart->lessThanOrEqualTo(now())) {
            throw ValidationException::withMessages([
                'event_date' => 'Event date and time must be in the future.',
            ]);
        }
    }

    private function generateUniqueSlug(string $title, ?int $ignoreEventId = null): string
    {
        $slug = Str::slug($title);

        if ($slug === '') {
            $slug = 'event-' . strtolower(Str::random(8));
        }

        $originalSlug = $slug;
        $counter = 1;

        while (true) {
            $query = Event::where('slug', $slug);

            if ($ignoreEventId) {
                $query->where('id', '!=', $ignoreEventId);
            }

            if (!$query->exists()) {
                return $slug;
            }

            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
    }
}
