<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's read-only profile.
     */
    public function show(Request $request): View|RedirectResponse
    {
        if (in_array($request->user()->role, ['super_admin', 'super_admin_staff'], true)) {
            return Redirect::route('admin.profile');
        }

        return view('profile.show', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        if (in_array($request->user()->role, ['super_admin', 'super_admin_staff'], true)) {
            return view('admin.profile.edit', ['user' => $request->user()]);
        }

        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = $request->user();
        $photo = $validated['profile_photo'] ?? null;
        $removePhoto = (bool) ($validated['remove_profile_photo'] ?? false);
        unset($validated['profile_photo'], $validated['remove_profile_photo']);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($photo) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $user->profile_photo_path = $photo->store('profile-photos', 'public');
        } elseif ($removePhoto && $user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
            $user->profile_photo_path = null;
        }

        $user->save();

        $route = in_array($request->user()->role, ['super_admin', 'super_admin_staff'], true)
            ? 'admin.profile'
            : 'profile.show';

        return Redirect::route($route)->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
