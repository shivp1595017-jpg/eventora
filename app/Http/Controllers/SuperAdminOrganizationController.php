<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use App\Notifications\OrganizationAdminPasswordSetup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Throwable;

class SuperAdminOrganizationController extends Controller
{
    /**
     * Super Admin Organization Management
     *
     * Supports:
     * - Live search
     * - Status filter
     * - Organization type filter
     * - Pagination
     * - Event count
     * - Linked organization admin
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $status = trim((string) $request->input('status', ''));
        $type = trim((string) $request->input('type', ''));

        $allowedStatuses = [
            'pending',
            'approved',
            'rejected',
        ];

        $query = Organization::query()
            ->with('user')
            ->withCount('events');

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {
            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('state', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if (in_array($status, $allowedStatuses, true)) {
            $query->where('status', $status);
        }

        /*
        |--------------------------------------------------------------------------
        | Type Filter
        |--------------------------------------------------------------------------
        */

        if ($type !== '') {
            $query->where('type', $type);
        }

        $organizations = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Dashboard Statistics
        |--------------------------------------------------------------------------
        */

        $totalOrganizations = Organization::count();

        $pendingOrganizations = Organization::where(
            'status',
            'pending'
        )->count();

        $approvedOrganizations = Organization::where(
            'status',
            'approved'
        )->count();

        $rejectedOrganizations = Organization::where(
            'status',
            'rejected'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | Organization Types
        |--------------------------------------------------------------------------
        */

        $organizationTypes = Organization::query()
            ->whereNotNull('type')
            ->where('type', '!=', '')
            ->select('type')
            ->distinct()
            ->orderBy('type')
            ->pluck('type');

        return view(
            'admin.organizations.index',
            compact(
                'organizations',
                'organizationTypes',
                'totalOrganizations',
                'pendingOrganizations',
                'approvedOrganizations',
                'rejectedOrganizations'
            )
        );
    }

    /**
     * Approve Organization
     */
    public function approve(Organization $organization)
    {
        /*
        |--------------------------------------------------------------------------
        | Already Approved
        |--------------------------------------------------------------------------
        */

        if ($organization->status === 'approved') {
            return redirect()
                ->route('admin.organizations.index')
                ->with(
                    'success',
                    'Organization is already approved.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Email Required
        |--------------------------------------------------------------------------
        */

        $organizationEmail = trim(
            (string) $organization->email
        );

        if ($organizationEmail === '') {
            return redirect()
                ->route('admin.organizations.index')
                ->with(
                    'error',
                    'Organization email is required before approval.'
                );
        }

        $organizationEmail = Str::lower(
            $organizationEmail
        );

        try {

            /*
            |--------------------------------------------------------------------------
            | Database Transaction
            |--------------------------------------------------------------------------
            */

            [$user, $token] = DB::transaction(
                function () use (
                    $organization,
                    $organizationEmail
                ) {

                    $organization = Organization::query()
                        ->whereKey($organization->id)
                        ->lockForUpdate()
                        ->firstOrFail();

                    /*
                    |--------------------------------------------------------------------------
                    | Re-check status inside transaction
                    |--------------------------------------------------------------------------
                    */

                    if ($organization->status === 'approved') {
                        throw new \RuntimeException(
                            'Organization is already approved.'
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Find Linked Organization Admin
                    |--------------------------------------------------------------------------
                    */

                    $user = null;

                    if ($organization->user_id) {
                        $user = User::query()
                            ->lockForUpdate()
                            ->find($organization->user_id);
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Find Existing User By Email
                    |--------------------------------------------------------------------------
                    */

                    if (!$user) {
                        $user = User::query()
                            ->lockForUpdate()
                            ->whereRaw(
                                'LOWER(email) = ?',
                                [$organizationEmail]
                            )
                            ->first();
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Create Organization Admin
                    |--------------------------------------------------------------------------
                    */

                    if (!$user) {

                        $user = User::create([
                            'name' => $organization->name
                                . ' Admin',

                            'email' => $organizationEmail,

                            'password' => Hash::make(
                                Str::random(64)
                            ),

                            'role' => 'organization_admin',
                        ]);

                    } else {

                        /*
                        |--------------------------------------------------------------------------
                        | Existing Account
                        |--------------------------------------------------------------------------
                        |
                        | Keep the same account but make it the
                        | organization admin for this approved organization.
                        |
                        */

                        $user->update([
                            'email' => $organizationEmail,
                            'role' => 'organization_admin',
                        ]);
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Link Organization
                    |--------------------------------------------------------------------------
                    */

                    $organization->update([
                        'status' => 'approved',
                        'user_id' => $user->id,
                    ]);

                    /*
                    |--------------------------------------------------------------------------
                    | Password Setup Token
                    |--------------------------------------------------------------------------
                    */

                    $token = Password::broker('users')
                        ->createToken($user);

                    return [
                        $user,
                        $token,
                    ];
                }
            );

            /*
            |--------------------------------------------------------------------------
            | Setup URL
            |--------------------------------------------------------------------------
            */

            $setupUrl = URL::route(
                'organization.admin.password.setup',
                [
                    'token' => $token,
                    'email' => $user->email,
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | Send Password Setup Email
            |--------------------------------------------------------------------------
            */

            try {

                $user->notify(
                    new OrganizationAdminPasswordSetup(
                        $setupUrl
                    )
                );

            } catch (Throwable $mailException) {

                report($mailException);

                return redirect()
                    ->route('admin.organizations.index')
                    ->with(
                        'warning',
                        'Organization approved successfully, but the password setup email could not be sent. Please check mail configuration and resend/reset the password.'
                    );
            }

            return redirect()
                ->route('admin.organizations.index')
                ->with(
                    'success',
                    'Organization approved successfully. Organization Admin account is ready and the password setup email has been sent.'
                );

        } catch (Throwable $exception) {

            report($exception);

            $message = $exception instanceof \RuntimeException
                ? $exception->getMessage()
                : 'Unable to approve organization. Please try again.';

            return redirect()
                ->route('admin.organizations.index')
                ->with(
                    'error',
                    $message
                );
        }
    }

    /**
     * Reject Organization
     */
    public function reject(Organization $organization)
    {
        /*
        |--------------------------------------------------------------------------
        | Approved Organization Protection
        |--------------------------------------------------------------------------
        |
        | Do not accidentally disable an already approved organization
        | through the registration-review reject button.
        |
        */

        if ($organization->status === 'approved') {
            return redirect()
                ->route('admin.organizations.index')
                ->with(
                    'error',
                    'An approved organization cannot be rejected from the registration review screen.'
                );
        }

        if ($organization->status === 'rejected') {
            return redirect()
                ->route('admin.organizations.index')
                ->with(
                    'success',
                    'Organization is already rejected.'
                );
        }

        try {

            DB::transaction(function () use ($organization) {

                $organization = Organization::query()
                    ->whereKey($organization->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                /*
                |--------------------------------------------------------------------------
                | Re-check State
                |--------------------------------------------------------------------------
                */

                if ($organization->status === 'approved') {
                    throw new \RuntimeException(
                        'An approved organization cannot be rejected.'
                    );
                }

                if ($organization->status === 'rejected') {
                    return;
                }

                $organization->update([
                    'status' => 'rejected',
                ]);
            });

            return redirect()
                ->route('admin.organizations.index')
                ->with(
                    'success',
                    'Organization rejected successfully.'
                );

        } catch (Throwable $exception) {

            report($exception);

            return redirect()
                ->route('admin.organizations.index')
                ->with(
                    'error',
                    'Unable to reject organization. Please try again.'
                );
        }
    }
}