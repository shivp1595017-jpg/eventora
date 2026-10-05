<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrganizationAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | ORGANIZATION ADMIN
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'organization_admin') {

            $organization = $user->currentOrganization();

            if (!$organization) {
                abort(403, 'No approved organization is assigned to this account.');
            }

            return $next($request);
        }

        /*
        |--------------------------------------------------------------------------
        | ORGANIZATION STAFF
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'organization_staff') {

            $staff = $user->currentOrganizationStaff();

            if (!$staff) {
                abort(403, 'Your staff access is inactive or not assigned.');
            }

            $organization = $staff->organization;

            if (!$organization) {
                abort(403, 'No organization is assigned to this staff account.');
            }

            if ($organization->status !== 'approved') {
                abort(403, 'Your organization is not approved.');
            }

            return $next($request);
        }

        /*
        |--------------------------------------------------------------------------
        | OTHER USERS
        |--------------------------------------------------------------------------
        */
        abort(403, 'Unauthorized access.');
    }
}