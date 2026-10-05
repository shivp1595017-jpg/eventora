<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\OrganizationStaff;
use App\Models\OrganizationUnit;
use App\Models\User;
use App\Notifications\StaffAddedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;

class OrganizationAdminStaffController extends Controller
{
    /**
     * Display staff members.
     */
    public function index(Request $request)
    {
        $this->authorizeStaffManagement();

        $organization = auth()->user()->currentOrganization();

        if (!$organization) {
            abort(404, 'Organization not found.');
        }

        $staff = $organization->organizationStaff()
            ->with([
                'organizationUnit',
                'organizationUnits',
                'events',
                'user',
                'createdBy',
            ])
            ->when($request->filled('search'), function ($query) use ($request) {

                $search = trim($request->search);

                $query->where(function ($q) use ($search) {

                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('mobile', 'like', '%' . $search . '%')
                        ->orWhere('role', 'like', '%' . $search . '%');

                });

            })
            ->when($request->filled('unit'), function ($query) use ($request) {

                $query->whereHas('organizationUnits', function ($q) use ($request) {

                    $q->where(
                        'organization_units.id',
                        $request->unit
                    );

                });

            })
            ->when($request->filled('status'), function ($query) use ($request) {

                $query->where(
                    'status',
                    $request->status
                );

            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $units = $organization->organizationUnits()
            ->orderBy('name')
            ->get();

        return view(
            'organization_admin.staff.index',
            compact(
                'organization',
                'staff',
                'units'
            )
        );
    }


    /**
     * Show create staff form.
     */
    public function create()
    {
        $this->authorizeStaffManagement();

        $organization = auth()->user()->currentOrganization();

        if (!$organization) {
            abort(404, 'Organization not found.');
        }

        $units = $organization->organizationUnits()
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $events = Event::where(
                'organization_id',
                $organization->id
            )
            ->orderBy('event_date')
            ->orderBy('event_time')
            ->orderBy('title')
            ->get();

        return view(
            'organization_admin.staff.create',
            compact(
                'organization',
                'units',
                'events'
            )
        );
    }


    /**
     * Store new staff member.
     */
    public function store(Request $request)
    {
        $this->authorizeStaffManagement();

        $organization = auth()->user()->currentOrganization();

        if (!$organization) {
            abort(404, 'Organization not found.');
        }

        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',

                Rule::unique('organization_staff')
                    ->where(function ($query) use ($organization) {

                        return $query->where(
                            'organization_id',
                            $organization->id
                        );

                    }),

                Rule::unique('users', 'email'),
            ],

            'mobile' => [
                'nullable',
                'string',
                'max:30',
            ],

            'organization_unit_ids' => [
                'nullable',
                'array',
            ],

            'organization_unit_ids.*' => [
                'integer',

                function ($attribute, $value, $fail) use ($organization) {

                    $exists = OrganizationUnit::where(
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
                            'One of the selected organization units is invalid.'
                        );
                    }
                },
            ],

            'event_ids' => [
                'nullable',
                'array',
            ],

            'event_ids.*' => [
                'integer',

                function ($attribute, $value, $fail) use ($organization) {

                    $exists = Event::where(
                            'id',
                            $value
                        )
                        ->where(
                            'organization_id',
                            $organization->id
                        )
                        ->exists();

                    if (!$exists) {
                        $fail(
                            'One of the selected events is invalid.'
                        );
                    }
                },
            ],

            'role' => [
                'required',
                'string',
                'max:100',
            ],

            'permissions' => [
                'nullable',
                'array',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Clean Values
        |--------------------------------------------------------------------------
        */

        $validated['name'] = trim(
            $validated['name']
        );

        $validated['email'] = strtolower(
            trim($validated['email'])
        );


        $unitIds =
            $validated['organization_unit_ids'] ?? [];


        $eventIds =
            $validated['event_ids'] ?? [];


        $permissions =
            $validated['permissions'] ?? [];


        try {

            DB::beginTransaction();


            /*
            |--------------------------------------------------------------------------
            | Create Login User
            |--------------------------------------------------------------------------
            */

            $temporaryPassword = bin2hex(
                random_bytes(16)
            );


            $user = User::create([
                'name' =>
                    $validated['name'],

                'email' =>
                    $validated['email'],

                'password' =>
                    Hash::make(
                        $temporaryPassword
                    ),

                'role' =>
                    'organization_staff',
            ]);


            /*
            |--------------------------------------------------------------------------
            | Primary Organization Unit
            |--------------------------------------------------------------------------
            */

            $primaryUnitId =
                !empty($unitIds)
                    ? $unitIds[0]
                    : null;


            /*
            |--------------------------------------------------------------------------
            | Create Staff
            |--------------------------------------------------------------------------
            */

            $staff = OrganizationStaff::create([

                'organization_id' =>
                    $organization->id,

                'organization_unit_id' =>
                    $primaryUnitId,

                'user_id' =>
                    $user->id,

                'created_by_user_id' =>
                    auth()->id(),

                'name' =>
                    $validated['name'],

                'email' =>
                    $validated['email'],

                'mobile' =>
                    $validated['mobile'] ?? null,

                'role' =>
                    $validated['role'],

                'permissions' =>
                    $permissions,

                'status' =>
                    $validated['status'],
            ]);


            /*
            |--------------------------------------------------------------------------
            | Multiple Organization Units
            |--------------------------------------------------------------------------
            */

            $staff->organizationUnits()->sync(
                $unitIds
            );


            /*
            |--------------------------------------------------------------------------
            | Multiple Events
            |--------------------------------------------------------------------------
            */

            $staff->events()->sync(
                $eventIds
            );


            /*
            |--------------------------------------------------------------------------
            | Send Password Setup Link
            |--------------------------------------------------------------------------
            */

            $status = Password::sendResetLink([
                'email' =>
                    $user->email,
            ]);


            if (
                $status !==
                Password::RESET_LINK_SENT
            ) {

                throw new \Exception(
                    'Password setup link could not be sent.'
                );
            }


            DB::commit();

            if (auth()->user()->role === 'organization_staff') {
                try {
                    $staff->loadMissing('organization');
                    User::where('role', 'super_admin')->get()->each(function (User $superAdmin) use ($staff) {
                        $superAdmin->notify(new StaffAddedNotification($staff));
                    });
                } catch (\Throwable $notificationError) {
                    report($notificationError);
                }
            }

            return redirect()
                ->route(
                    'organization.admin.staff.index'
                )
                ->with(
                    'success',
                    'Staff member added successfully. A password setup link has been sent to the staff email address.'
                );

        } catch (\Throwable $e) {

            DB::rollBack();


            return back()
                ->withInput()
                ->with(
                    'error',
                    'Staff member could not be created. Please check your email configuration and try again.'
                );
        }
    }


    /**
     * Show staff profile.
     *
     * Organization Admin:
     * Can view any staff member of own organization.
     *
     * Organization Staff:
     * Can view ONLY their own profile.
     */
    public function show(
        OrganizationStaff $staff
    ) {

        $user = auth()->user();


        /*
        |--------------------------------------------------------------------------
        | Organization Admin
        |--------------------------------------------------------------------------
        */

        if (
            $user->role ===
            'organization_admin'
        ) {

            $this->authorizeOrganizationStaff(
                $staff
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Organization Staff
        |--------------------------------------------------------------------------
        */

        elseif (
            $user->role ===
            'organization_staff'
        ) {

            $currentStaff =
                $user->currentOrganizationStaff();


            if (!$currentStaff) {

                abort(
                    403,
                    'Your staff access is inactive or not assigned.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Only Own Profile
            |--------------------------------------------------------------------------
            */

            if (
                $currentStaff->id !==
                $staff->id
            ) {

                abort(
                    403,
                    'You can only view your own profile.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Make sure staff is from same organization
            |--------------------------------------------------------------------------
            */

            if (
                $currentStaff->organization_id !==
                $staff->organization_id
            ) {

                abort(
                    403,
                    'Unauthorized access.'
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Everyone Else
        |--------------------------------------------------------------------------
        */

        else {

            abort(
                403,
                'Unauthorized access.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Load Profile Data
        |--------------------------------------------------------------------------
        */

        $staff->load([
            'organization',
            'organizationUnit',
            'organizationUnits',
            'events',
            'user',
            'createdBy',
        ]);


        return view(
            'organization_admin.staff.show',
            compact('staff')
        );
    }


    /**
     * Show edit staff form.
     */
    public function edit(
        OrganizationStaff $staff
    ) {

        $this->authorizeStaffManagement();

        $this->authorizeOrganizationStaff(
            $staff
        );


        $organization =
            auth()->user()->currentOrganization();


        if (!$organization) {

            abort(
                404,
                'Organization not found.'
            );
        }


        $units = $organization
            ->organizationUnits()
            ->where(
                'status',
                'active'
            )
            ->orderBy('name')
            ->get();


        $events = Event::where(
                'organization_id',
                $organization->id
            )
            ->orderBy('event_date')
            ->orderBy('event_time')
            ->orderBy('title')
            ->get();


        $staff->load([
            'organizationUnits',
            'events',
            'user',
            'createdBy',
        ]);


        return view(
            'organization_admin.staff.edit',
            compact(
                'staff',
                'organization',
                'units',
                'events'
            )
        );
    }


    /**
     * Update staff member.
     *
     * Password setup email is sent ONLY
     * when email address changes.
     */
    public function update(
        Request $request,
        OrganizationStaff $staff
    ) {

        $this->authorizeStaffManagement();

        $this->authorizeOrganizationStaff(
            $staff
        );


        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',

                Rule::unique(
                    'organization_staff'
                )
                    ->ignore($staff->id)
                    ->where(function ($query) use ($staff) {

                        return $query->where(
                            'organization_id',
                            $staff->organization_id
                        );

                    }),

                Rule::unique(
                    'users',
                    'email'
                )
                    ->ignore($staff->user_id),
            ],

            'mobile' => [
                'nullable',
                'string',
                'max:30',
            ],

            'organization_unit_ids' => [
                'nullable',
                'array',
            ],

            'organization_unit_ids.*' => [
                'integer',

                function (
                    $attribute,
                    $value,
                    $fail
                ) use ($staff) {

                    $exists =
                        OrganizationUnit::where(
                            'id',
                            $value
                        )
                        ->where(
                            'organization_id',
                            $staff->organization_id
                        )
                        ->where(
                            'status',
                            'active'
                        )
                        ->exists();


                    if (!$exists) {

                        $fail(
                            'One of the selected organization units is invalid.'
                        );
                    }
                },
            ],

            'event_ids' => [
                'nullable',
                'array',
            ],

            'event_ids.*' => [
                'integer',

                function (
                    $attribute,
                    $value,
                    $fail
                ) use ($staff) {

                    $exists =
                        Event::where(
                            'id',
                            $value
                        )
                        ->where(
                            'organization_id',
                            $staff->organization_id
                        )
                        ->exists();


                    if (!$exists) {

                        $fail(
                            'One of the selected events is invalid.'
                        );
                    }
                },
            ],

            'role' => [
                'required',
                'string',
                'max:100',
            ],

            'permissions' => [
                'nullable',
                'array',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Clean Values
        |--------------------------------------------------------------------------
        */

        $validated['name'] = trim(
            $validated['name']
        );


        $newEmail = strtolower(
            trim($validated['email'])
        );


        $oldEmail = strtolower(
            trim($staff->email)
        );


        /*
        |--------------------------------------------------------------------------
        | Email Change Check
        |--------------------------------------------------------------------------
        */

        $emailChanged =
            $oldEmail !== $newEmail;


        $unitIds =
            $validated['organization_unit_ids'] ?? [];


        $eventIds =
            $validated['event_ids'] ?? [];


        $permissions =
            $validated['permissions'] ?? [];


        unset(
            $validated['organization_unit_ids'],
            $validated['event_ids']
        );


        $validated['email'] =
            $newEmail;


        $validated['permissions'] =
            $permissions;


        $validated['organization_unit_id'] =
            !empty($unitIds)
                ? $unitIds[0]
                : null;


        DB::beginTransaction();


        try {

            /*
            |--------------------------------------------------------------------------
            | Update Staff
            |--------------------------------------------------------------------------
            */

            $staff->update(
                $validated
            );


            /*
            |--------------------------------------------------------------------------
            | Sync Units
            |--------------------------------------------------------------------------
            */

            $staff->organizationUnits()->sync(
                $unitIds
            );


            /*
            |--------------------------------------------------------------------------
            | Sync Events
            |--------------------------------------------------------------------------
            */

            $staff->events()->sync(
                $eventIds
            );


            /*
            |--------------------------------------------------------------------------
            | Update Linked User
            |--------------------------------------------------------------------------
            */

            if ($staff->user) {

                $staff->user->update([

                    'name' =>
                        $validated['name'],

                    'email' =>
                        $newEmail,

                    'role' =>
                        'organization_staff',
                ]);

            } else {

                /*
                |--------------------------------------------------------------------------
                | Safety fallback
                |--------------------------------------------------------------------------
                */

                $temporaryPassword =
                    bin2hex(
                        random_bytes(16)
                    );


                $user = User::create([

                    'name' =>
                        $validated['name'],

                    'email' =>
                        $newEmail,

                    'password' =>
                        Hash::make(
                            $temporaryPassword
                        ),

                    'role' =>
                        'organization_staff',
                ]);


                $staff->update([
                    'user_id' =>
                        $user->id
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Send Password Setup Link ONLY
            | when email changed.
            |--------------------------------------------------------------------------
            */

            if ($emailChanged) {

                $status =
                    Password::sendResetLink([
                        'email' =>
                            $newEmail,
                    ]);


                if (
                    $status !==
                    Password::RESET_LINK_SENT
                ) {

                    throw new \Exception(
                        'Password setup link could not be sent.'
                    );
                }
            }


            DB::commit();


            /*
            |--------------------------------------------------------------------------
            | Success Message
            |--------------------------------------------------------------------------
            */

            if ($emailChanged) {

                return redirect()
                    ->route(
                        'organization.admin.staff.index'
                    )
                    ->with(
                        'success',
                        'Staff member updated successfully. A password setup link has been sent to the new email address.'
                    );
            }


            return redirect()
                ->route(
                    'organization.admin.staff.index'
                )
                ->with(
                    'success',
                    'Organization staff member updated successfully.'
                );

        } catch (\Throwable $e) {

            DB::rollBack();


            return back()
                ->withInput()
                ->with(
                    'error',
                    'Staff member could not be updated. Please check the email address and mail configuration.'
                );
        }
    }


    /**
     * Delete staff member.
     */
    public function destroy(OrganizationStaff $staff)
    {
        // Organization Admin may delete staff only from their own organization.
        // Organization Staff are never allowed to delete staff.
        $user = auth()->user();

        if ($user->role !== 'organization_admin') {
            abort(403, 'Only the Organization Admin can delete staff members.');
        }

        $this->authorizeOrganizationStaff($staff);

        DB::transaction(function () use ($staff) {
            if ($staff->user) {
                $staff->user->delete();
            }

            $staff->delete();
        });

        return redirect()
            ->route('organization.admin.staff.index')
            ->with('success', 'Staff member deleted successfully.');
    }


    /**
     * Authorize staff management.
     */
    private function authorizeStaffManagement(): void
    {
        $user = auth()->user();


        /*
        |--------------------------------------------------------------------------
        | Organization Admin
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
        | Organization Staff
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


        if (
            !in_array(
                'manage_staff',
                $permissions,
                true
            )
        ) {

            abort(
                403,
                'You do not have permission to manage staff.'
            );
        }
    }


    /**
     * Make sure staff belongs to current organization.
     */
    private function authorizeOrganizationStaff(
        OrganizationStaff $staff
    ): void {

        $organization =
            auth()->user()->currentOrganization();


        if (
            !$organization ||
            $staff->organization_id !==
                $organization->id
        ) {

            abort(
                403,
                'Unauthorized access.'
            );
        }
    }
}