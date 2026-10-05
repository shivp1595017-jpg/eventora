<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;

class SuperAdminAccessStaffController extends Controller
{
    private const PERMISSIONS = [
        'organizations', 'events', 'manage_staff', 'users', 'bookings', 'payments', 'ticket_verification', 'settings',
    ];

    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));
        $staff = User::where('role', 'super_admin_staff')
            ->when($search !== '', fn ($q) => $q->where(fn ($sub) => $sub->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%")))
            ->latest()->paginate(15)->withQueryString();
        $permissions = self::PERMISSIONS;
        if (auth()->user()->role === 'super_admin_staff') {
            $permissions = array_values(array_intersect($permissions, auth()->user()->admin_permissions ?? []));
        }
        return view('admin.access-staff.index', compact('staff', 'permissions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'admin_permissions' => ['nullable', 'array'],
            'admin_permissions.*' => ['string', Rule::in(self::PERMISSIONS)],
        ]);

        $grantedPermissions = array_values(array_unique($data['admin_permissions'] ?? []));
        if (auth()->user()->role === 'super_admin_staff') {
            $grantedPermissions = array_values(array_intersect($grantedPermissions, auth()->user()->admin_permissions ?? []));
        }

        $user = User::create([
            'name' => trim($data['name']),
            'email' => strtolower(trim($data['email'])),
            'password' => Hash::make(bin2hex(random_bytes(32))),
            'role' => 'super_admin_staff',
            'admin_permissions' => $grantedPermissions,
        ]);

        try {
            $status = Password::sendResetLink(['email' => $user->email]);
        } catch (\Throwable $exception) {
            report($exception);
            $user->delete();
            return back()->withInput()->with('error', 'Staff account was not created because the password setup email could not be sent.');
        }
        if ($status !== Password::RESET_LINK_SENT) {
            $user->delete();
            return back()->withInput()->with('error', 'Staff account was not created because the password setup email could not be sent.');
        }

        return redirect()->route('admin.access-staff.index')->with('success', 'Super Admin Staff added. A password setup link was sent.');
    }

    public function update(Request $request, User $staff)
    {
        abort_unless($staff->role === 'super_admin_staff', 404);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($staff->id)],
            'admin_permissions' => ['nullable', 'array'],
            'admin_permissions.*' => ['string', Rule::in(self::PERMISSIONS)],
        ]);

        $grantedPermissions = array_values(array_unique($data['admin_permissions'] ?? []));
        if (auth()->user()->role === 'super_admin_staff') {
            $grantedPermissions = array_values(array_intersect($grantedPermissions, auth()->user()->admin_permissions ?? []));
        }

        $staff->update([
            'name' => trim($data['name']),
            'email' => strtolower(trim($data['email'])),
            'admin_permissions' => $grantedPermissions,
        ]);

        return redirect()->route('admin.access-staff.index')->with('success', 'Staff account and permissions updated.');
    }

    public function destroy(User $staff)
    {
        abort_unless($staff->role === 'super_admin_staff', 404);
        $staff->delete();

        return redirect()->route('admin.access-staff.index')->with('success', 'Super Admin Staff account deleted.');
    }
}
