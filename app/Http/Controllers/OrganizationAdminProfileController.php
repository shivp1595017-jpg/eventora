<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationAdminProfileController extends Controller
{

    public function show()
{
    $organization = auth()->user()
        ->organizations()
        ->latest()
        ->first();

    if (!$organization) {
        abort(404, 'Organization not found.');
    }

    return view('organization_admin.profile.show', compact('organization'));
}
    /**
     * Show organization profile.
     */
    /**
     * Show organization profile.
     */
    public function edit()
    {
        $organization = auth()->user()
            ->organizations()
            ->latest()
            ->first();

        if (!$organization) {
            abort(404, 'Organization not found.');
        }

        return view('organization_admin.profile.edit', compact('organization'));
    }

    /**
     * Update organization profile.
     */
    public function update(Request $request)
    {
        $organization = auth()->user()
            ->organizations()
            ->latest()
            ->first();

        if (!$organization) {
            abort(404, 'Organization not found.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:School,College,Company,NGO,Other'],
            'description' => ['nullable', 'string'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'website' => ['nullable', 'url', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:6144'],
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request
                ->file('logo')
                ->store('organizations/logos', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request
                ->file('cover_image')
                ->store('organizations/covers', 'public');
        }

        $organization->update($validated);

        return redirect()
    ->route('organization.admin.profile')
    ->with('success', 'Organization profile updated successfully.');
    }
}