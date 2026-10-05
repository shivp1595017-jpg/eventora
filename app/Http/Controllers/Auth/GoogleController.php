<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect user to Google login.
     *
     * Google account selector will be shown
     * every time the user chooses Continue with Google.
     */
    public function redirect()
    {
        return Socialite::driver('google')
            ->with([
                'prompt' => 'select_account',
            ])
            ->scopes([
                'openid',
                'profile',
                'email',
            ])
            ->redirect();
    }


    /**
     * Handle Google callback.
     */
    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();


        /*
        |--------------------------------------------------------------------------
        | Find Existing User
        |--------------------------------------------------------------------------
        */

        $user = User::where(
            'email',
            $googleUser->getEmail()
        )->first();


        /*
        |--------------------------------------------------------------------------
        | Create User If Not Exists
        |--------------------------------------------------------------------------
        */

        if (!$user) {

            $user = User::create([

                'name' =>
                    $googleUser->getName()
                    ?: $googleUser->getNickname()
                    ?: 'Google User',

                'email' =>
                    $googleUser->getEmail(),

                'password' =>
                    bcrypt(
                        str()->random(32)
                    ),

            ]);
        }

        $googleAvatarUrl = $googleUser->getAvatar()
            ?: data_get($googleUser->user, 'picture');

        if (
            is_string($googleAvatarUrl)
            && filter_var($googleAvatarUrl, FILTER_VALIDATE_URL)
            && str_starts_with($googleAvatarUrl, 'https://')
            && $user->google_avatar_url !== $googleAvatarUrl
        ) {
            $user->forceFill(['google_avatar_url' => $googleAvatarUrl])->save();
        }

        $googleEmailIsVerified = ($googleUser->user['email_verified'] ?? false) === true
            || ($googleUser->user['verified_email'] ?? false) === true;

        if ($googleEmailIsVerified && !$user->email_verified_at) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }


        /*
        |--------------------------------------------------------------------------
        | Login User
        |--------------------------------------------------------------------------
        |
        | false = Do not remember login after browser session ends.
        |
        */

        Auth::login(
            $user,
            false
        );


        /*
        |--------------------------------------------------------------------------
        | Regenerate Session
        |--------------------------------------------------------------------------
        */

        request()
            ->session()
            ->regenerate();


        /*
        |--------------------------------------------------------------------------
        | SUPER ADMIN
        |--------------------------------------------------------------------------
        */

        if (in_array($user->role, ['super_admin', 'super_admin_staff'], true)) {

            return redirect()
                ->route(
                    'admin.dashboard'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | ORGANIZATION ADMIN
        |--------------------------------------------------------------------------
        */

        if (
            $user->role ===
            'organization_admin'
        ) {

            return redirect()
                ->route(
                    'organization.admin.dashboard'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | ORGANIZATION STAFF
        |--------------------------------------------------------------------------
        */

        if (
            $user->role ===
            'organization_staff'
        ) {

            return redirect()
                ->route(
                    'organization.admin.dashboard'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | NORMAL USER
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'home'
            );
    }
}
