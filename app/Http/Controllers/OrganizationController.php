<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use App\Notifications\OrganizationSubmittedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrganizationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Organization Search
    |--------------------------------------------------------------------------
    */

    public function search(Request $request)
    {
        $query = $request->input('q');

        $organizations = Organization::where('status', 'approved')
            ->when($query, function ($q) use ($query) {
                $q->where(function ($subQuery) use ($query) {
                    $subQuery->where('name', 'like', '%' . $query . '%')
                        ->orWhere('city', 'like', '%' . $query . '%');
                });
            })
            ->latest()
            ->get();

        return view(
            'organizations.search',
            compact('organizations', 'query')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Organization Profile
    |--------------------------------------------------------------------------
    */

    public function show($slug)
    {
        $organization = Organization::with([
            'events' => function ($query) {
                $query->where('status', 'approved')
                    ->whereDate(
                        'event_date',
                        '>=',
                        now()->toDateString()
                    )
                    ->orderBy('event_date');
            }
        ])
            ->where('slug', $slug)
            ->where('status', 'approved')
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Send Organization + Events to View
        |--------------------------------------------------------------------------
        */

        $events = $organization->events;

        return view(
            'organizations.show',
            compact('organization', 'events')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Organization Registration Page
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('organizations.create');
    }


    /*
    |--------------------------------------------------------------------------
    | Store Organization
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'type' => [
                'required',
                'in:School,College,Company,NGO,Other',
            ],

            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],

            /*
            | Email is required because
            | Super Admin will send password setup email.
            */
            'email' => [
                'required',
                'email',
                'max:255',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'address' => [
                'nullable',
                'string',
                'max:500',
            ],

            'city' => [
                'nullable',
                'string',
                'max:100',
            ],

            'state' => [
                'nullable',
                'string',
                'max:100',
            ],

            'website' => [
                'nullable',
                'url',
                'max:255',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Create Unique Slug
        |--------------------------------------------------------------------------
        */

        $baseSlug = Str::slug($validated['name']);

        $slug = $baseSlug;

        $counter = 1;

        while (Organization::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }


        /*
        |--------------------------------------------------------------------------
        | Create Organization
        |--------------------------------------------------------------------------
        |
        | Organization remains pending.
        | Super Admin approves it.
        | Only after approval the organization
        | becomes an Organization Admin account.
        |
        |--------------------------------------------------------------------------
        */

        $organization = Organization::create([

            'user_id' => auth()->id(),

            'name' => $validated['name'],

            'slug' => $slug,

            'type' => $validated['type'],

            'description' => $validated['description'] ?? null,

            'email' => $validated['email'],

            'phone' => $validated['phone'] ?? null,

            'address' => $validated['address'] ?? null,

            'city' => $validated['city'] ?? null,

            'state' => $validated['state'] ?? null,

            'website' => $validated['website'] ?? null,

            'status' => 'pending',

        ]);

        // Notify all Super Admin accounts about the new pending organization.
        // Notification failure must not prevent the organization registration from succeeding.
        try {
            User::where('role', 'super_admin')
                ->get()
                ->each(function (User $superAdmin) use ($organization) {
                    $superAdmin->notify(
                        new OrganizationSubmittedNotification(
                            $organization->id,
                            $organization->name
                        )
                    );
                });
        } catch (\Throwable $e) {
            report($e);
        }


        /*
        |--------------------------------------------------------------------------
        | Success Message
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('organizations.create')
            ->with(
                'success',
                'Organization submitted successfully. It is waiting for Super Admin approval.'
            );
    }
}