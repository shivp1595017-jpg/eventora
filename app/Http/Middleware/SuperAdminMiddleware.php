<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        if (!in_array($user->role, ['super_admin', 'super_admin_staff'], true)) {
            abort(403, 'Unauthorized access.');
        }

        // Super Admin Staff can never manage Super Admin accounts or delete staff.
        if ($user->role === 'super_admin_staff') {
            $routeName = (string) $request->route()?->getName();
            if ($routeName === 'admin.access-staff.destroy' || $routeName === 'admin.staff.destroy') {
                abort(403, 'Only the Main Super Admin can perform this action.');
            }

            $permission = match (true) {
                in_array($routeName, ['admin.dashboard', 'admin.profile', 'admin.notifications.read'], true) => null,
                str_starts_with($routeName, 'admin.organizations.') => 'organizations',
                str_starts_with($routeName, 'admin.events.') => 'events',
                str_starts_with($routeName, 'admin.staff.') => 'manage_staff',
                str_starts_with($routeName, 'admin.access-staff.') => 'manage_staff',
                str_starts_with($routeName, 'admin.users.') => 'users',
                str_starts_with($routeName, 'admin.bookings.') => 'bookings',
                str_starts_with($routeName, 'admin.payments.') => 'payments',
                str_starts_with($routeName, 'admin.ticket-verification.') => 'ticket_verification',
                $routeName === 'admin.settings' => 'settings',
                in_array($routeName, ['admin.export', 'admin.print'], true) => match ((string) $request->route('resource')) {
                    'staff', 'admin_staff' => 'manage_staff',
                    default => (string) $request->route('resource'),
                },
                default => 'denied',
            };

            if ($permission === 'denied' || ($permission !== null && !in_array($permission, $user->admin_permissions ?? [], true))) {
                abort(403, 'You do not have permission to access this section.');
            }
        }

        return $next($request);
    }
}
