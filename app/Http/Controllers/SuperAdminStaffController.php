<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Organization;
use App\Models\OrganizationStaff;
use App\Models\OrganizationUnit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;

class SuperAdminStaffController extends Controller
{
    public function index(Request $request)
    {
        $staff = OrganizationStaff::with(['organization', 'organizationUnit', 'user', 'createdBy'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = trim($request->search);
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('mobile', 'like', "%{$search}%")
                        ->orWhere('role', 'like', "%{$search}%")
                        ->orWhereHas('organization', fn ($oq) => $oq->where('name', 'like', "%{$search}%"));
                });
            })
            ->when($request->filled('organization'), fn ($query) => $query->where('organization_id', $request->organization))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $organizations = Organization::orderBy('name')->get(['id', 'name', 'status']);

        return view('admin.staff.index', compact('staff', 'organizations'));
    }

    public function create()
    {
        $organizations = Organization::where('status', 'approved')->orderBy('name')->get();
        $units = OrganizationUnit::whereIn('organization_id', $organizations->pluck('id'))
            ->where('status', 'active')->with('organization')->orderBy('name')->get();
        $events = Event::whereIn('organization_id', $organizations->pluck('id'))
            ->with('organization')->orderBy('event_date')->orderBy('event_time')->orderBy('title')->get();

        return view('admin.staff.create', compact('organizations', 'units', 'events'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateStaff($request);
        $organization = Organization::where('status', 'approved')->findOrFail($validated['organization_id']);

        $unitIds = $validated['organization_unit_ids'] ?? [];
        $eventIds = $validated['event_ids'] ?? [];
        $permissions = $validated['permissions'] ?? [];

        DB::beginTransaction();
        try {
            $temporaryPassword = bin2hex(random_bytes(16));

            $user = User::create([
                'name' => trim($validated['name']),
                'email' => strtolower(trim($validated['email'])),
                'password' => Hash::make($temporaryPassword),
                'role' => 'organization_staff',
            ]);

            $staff = OrganizationStaff::create([
                'organization_id' => $organization->id,
                'organization_unit_id' => $unitIds[0] ?? null,
                'user_id' => $user->id,
                'created_by_user_id' => auth()->id(),
                'name' => trim($validated['name']),
                'email' => strtolower(trim($validated['email'])),
                'mobile' => $validated['mobile'] ?? null,
                'role' => $validated['role'],
                'permissions' => $permissions,
                'status' => $validated['status'],
            ]);

            $staff->organizationUnits()->sync($unitIds);
            $staff->events()->sync($eventIds);

            $status = Password::sendResetLink(['email' => $user->email]);
            if ($status !== Password::RESET_LINK_SENT) {
                throw new \RuntimeException('Password setup link could not be sent.');
            }

            DB::commit();

            return redirect()->route('admin.staff.index')
                ->with('success', 'Staff member added successfully. A password setup link has been sent.');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return back()->withInput()->with('error', 'Staff member could not be created. Please check the email configuration and selected organization data.');
        }
    }

    public function show(OrganizationStaff $staff)
    {
        $staff->load(['organization', 'organizationUnit', 'organizationUnits', 'events', 'user', 'createdBy']);
        return view('admin.staff.show', compact('staff'));
    }

    public function edit(OrganizationStaff $staff)
    {
        $organizations = Organization::where('status', 'approved')->orderBy('name')->get();
        $units = OrganizationUnit::whereIn('organization_id', $organizations->pluck('id'))
            ->where('status', 'active')->with('organization')->orderBy('name')->get();
        $events = Event::whereIn('organization_id', $organizations->pluck('id'))
            ->with('organization')->orderBy('event_date')->orderBy('event_time')->orderBy('title')->get();

        $staff->load(['organizationUnits', 'events', 'user']);

        return view('admin.staff.edit', compact('staff', 'organizations', 'units', 'events'));
    }

    public function update(Request $request, OrganizationStaff $staff)
    {
        $validated = $this->validateStaff($request, $staff);
        $organization = Organization::where('status', 'approved')->findOrFail($validated['organization_id']);
        $emailChanged = strtolower(trim($validated['email'])) !== strtolower($staff->email);

        DB::beginTransaction();
        try {
            $staff->update([
                'organization_id' => $organization->id,
                'organization_unit_id' => ($validated['organization_unit_ids'] ?? [])[0] ?? null,
                'name' => trim($validated['name']),
                'email' => strtolower(trim($validated['email'])),
                'mobile' => $validated['mobile'] ?? null,
                'role' => $validated['role'],
                'permissions' => $validated['permissions'] ?? [],
                'status' => $validated['status'],
            ]);

            $staff->organizationUnits()->sync($validated['organization_unit_ids'] ?? []);
            $staff->events()->sync($validated['event_ids'] ?? []);

            if ($staff->user) {
                $staff->user->update([
                    'name' => $staff->name,
                    'email' => $staff->email,
                    'role' => 'organization_staff',
                ]);
            }

            if ($emailChanged && $staff->user) {
                $status = Password::sendResetLink(['email' => $staff->user->email]);
                if ($status !== Password::RESET_LINK_SENT) {
                    throw new \RuntimeException('Password setup link could not be sent.');
                }
            }

            DB::commit();

            return redirect()->route('admin.staff.index')
                ->with('success', $emailChanged ? 'Staff updated and a new password setup link was sent.' : 'Staff member updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return back()->withInput()->with('error', 'Staff member could not be updated.');
        }
    }

    public function markNotificationRead(string $notification)
    {
        $item = auth()->user()->notifications()->where('id', $notification)->firstOrFail();
        $item->markAsRead();

        return redirect($item->data['url'] ?? route('admin.dashboard'));
    }

    public function destroy(OrganizationStaff $staff)
    {
        DB::transaction(function () use ($staff) {
            if ($staff->user) {
                $staff->user->delete();
            }
            $staff->delete();
        });

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff member deleted successfully.');
    }

    private function validateStaff(Request $request, ?OrganizationStaff $staff = null): array
    {
        $organizationIds = Organization::where('status', 'approved')->pluck('id');

        return $request->validate([
            'organization_id' => ['required', 'integer', Rule::in($organizationIds->all())],
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('organization_staff', 'email')
                    ->ignore($staff?->id)
                    ->where(fn ($q) => $q->where('organization_id', $request->integer('organization_id'))),
                Rule::unique('users', 'email')->ignore($staff?->user_id),
            ],
            'mobile' => ['nullable', 'string', 'max:30'],
            'organization_unit_ids' => ['nullable', 'array'],
            'organization_unit_ids.*' => [
                'integer',
                function ($attribute, $value, $fail) use ($request) {
                    $valid = OrganizationUnit::whereKey($value)
                        ->where('organization_id', $request->integer('organization_id'))
                        ->where('status', 'active')
                        ->exists();
                    if (!$valid) {
                        $fail('One of the selected organization units is invalid.');
                    }
                },
            ],
            'event_ids' => ['nullable', 'array'],
            'event_ids.*' => [
                'integer',
                function ($attribute, $value, $fail) use ($request) {
                    $valid = Event::whereKey($value)
                        ->where('organization_id', $request->integer('organization_id'))
                        ->exists();
                    if (!$valid) {
                        $fail('One of the selected events is invalid.');
                    }
                },
            ],
            'role' => ['required', 'string', 'max:100'],
            'permissions' => ['nullable', 'array'],
            'status' => ['required', 'in:active,inactive'],
        ]);
    }
}
