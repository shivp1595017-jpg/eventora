<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | SUPER ADMIN
        |--------------------------------------------------------------------------
        */

        if (in_array($user->role, ['super_admin', 'super_admin_staff'], true)) {
            return redirect()->route('admin.dashboard');
        }


        /*
        |--------------------------------------------------------------------------
        | ORGANIZATION ADMIN
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'organization_admin') {
            return redirect()->route('organization.admin.dashboard');
        }


        /*
        |--------------------------------------------------------------------------
        | ORGANIZATION STAFF
        |--------------------------------------------------------------------------
        |
        | Staff uses the SAME Organization Admin Panel.
        |
        */

        if ($user->role === 'organization_staff') {
            return redirect()->route('organization.admin.dashboard');
        }


        /*
        |--------------------------------------------------------------------------
        | NORMAL USER
        |--------------------------------------------------------------------------
        */

        return redirect()->route('home');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
