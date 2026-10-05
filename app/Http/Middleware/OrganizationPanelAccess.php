<?php

namespace App\Http\Middleware;

use App\Models\OrganizationStaff;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrganizationPanelAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // User login થયેલો ન હોય
        if (!$user) {
            return redirect()->route('login');
        }

        /*
        |--------------------------------------------------------------------------
        | ORGANIZATION ADMIN
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'organization_admin') {

            $organization = $user->organizations()
                ->where('status', 'approved')
                ->latest()
                ->first();

            if (!$organization) {
                abort(403, 'No approved organization is assigned to this account.');
            }

            // Current organization panel માટે store
            $request->attributes->set(
                'organization',
                $organization
            );

            return $next($request);
        }

        /*
        |--------------------------------------------------------------------------
        | ORGANIZATION STAFF
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'organization_staff') {

            $staff = OrganizationStaff::with('organization')
                ->where('user_id', $user->id)
                ->where('status', 'active')
                ->latest()
                ->first();

            if (!$staff || !$staff->organization) {
                abort(403, 'Your organization staff access is inactive or not assigned.');
            }

            if ($staff->organization->status !== 'approved') {
                abort(403, 'Your organization is not approved.');
            }

            // Staff માટે same organization panel context
            $request->attributes->set(
                'organization',
                $staff->organization
            );

            // Staff record પણ આગળ permissions માટે available રહેશે
            $request->attributes->set(
                'organizationStaff',
                $staff
            );

            return $next($request);
        }

        /*
        |--------------------------------------------------------------------------
        | OTHER ROLES
        |--------------------------------------------------------------------------
        */

        abort(403, 'You do not have access to the organization panel.');
    }
}