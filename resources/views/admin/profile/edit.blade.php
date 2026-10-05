@extends('layouts.admin')
@section('title', 'Admin Profile - Eventora')
@section('heading', 'Super Admin Profile')
@section('description', 'Update your Super Admin account and security settings.')
@section('content')
<div class="two-col">
    <section class="card" style="padding:22px">
        <h2 style="font-size:16px;margin-bottom:6px">Account Information</h2>
        <p style="color:var(--muted);font-size:12px;margin-bottom:16px">This profile stays inside your Super Admin panel.</p>
        @if(session('status') === 'profile-updated')<div class="flash success">Profile updated.</div>@endif
        <div class="super-profile-photo">
            <div class="super-profile-avatar">
                <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                @if($user->profilePhotoUrl())
                    <img src="{{ $user->profilePhotoUrl() }}" alt="{{ $user->name }} profile photo" referrerpolicy="no-referrer" onerror="this.remove()">
                @endif
            </div>
            <div><strong>{{ $user->name }}</strong><small>Super Admin profile</small></div>
        </div>
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" style="display:grid;gap:12px">
            @csrf @method('PATCH')
            <label style="font-size:12px;font-weight:700">Profile photo<input class="filter-control" type="file" name="profile_photo" accept="image/jpeg,image/png,image/webp"></label>
            <small style="color:var(--muted)">JPG, PNG or WebP, up to 2 MB.</small>
            @error('profile_photo')<small style="color:#ef4444">{{ $message }}</small>@enderror
            @if($user->profile_photo_path)
                <label style="font-size:12px;color:var(--muted)"><input type="checkbox" name="remove_profile_photo" value="1"> Remove uploaded photo</label>
            @endif
            <label style="font-size:12px;font-weight:700">Name<input class="filter-control" name="name" value="{{ old('name', $user->name) }}" required></label>
            @error('name')<small style="color:#ef4444">{{ $message }}</small>@enderror
            <label style="font-size:12px;font-weight:700">Email<input class="filter-control" type="email" name="email" value="{{ old('email', $user->email) }}" required></label>
            @error('email')<small style="color:#ef4444">{{ $message }}</small>@enderror
            <button class="btn approve" type="submit" style="justify-self:start">Save Profile</button>
        </form>
    </section>

    <section class="card" style="padding:22px">
        <h2 style="font-size:16px;margin-bottom:6px">Change Password</h2>
        <p style="color:var(--muted);font-size:12px;margin-bottom:16px">Use your current password to set a new one.</p>
        @if(session('status') === 'password-updated')<div class="flash success">Password updated.</div>@endif
        <form method="POST" action="{{ route('password.update') }}" style="display:grid;gap:12px">
            @csrf @method('PUT')
            <label style="font-size:12px;font-weight:700">Current password<input class="filter-control" type="password" name="current_password" required autocomplete="current-password"></label>
            @error('current_password', 'updatePassword')<small style="color:#ef4444">{{ $message }}</small>@enderror
            <label style="font-size:12px;font-weight:700">New password<input class="filter-control" type="password" name="password" required autocomplete="new-password"></label>
            @error('password', 'updatePassword')<small style="color:#ef4444">{{ $message }}</small>@enderror
            <label style="font-size:12px;font-weight:700">Confirm new password<input class="filter-control" type="password" name="password_confirmation" required autocomplete="new-password"></label>
            <button class="btn approve" type="submit" style="justify-self:start">Update Password</button>
        </form>
    </section>
</div>
<style>
    .super-profile-photo{display:flex;align-items:center;gap:16px;margin:20px 0;padding:18px;border:1px solid var(--border);border-radius:14px;background:var(--card2)}
    .super-profile-avatar{position:relative;display:grid;width:112px;height:112px;flex:0 0 112px;place-items:center;overflow:hidden;border:3px solid var(--border);border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--primary2));color:#fff;font-size:40px;font-weight:800}
    .super-profile-avatar img{position:absolute;inset:0;width:100%;height:100%;border-radius:inherit;object-fit:cover}
    .super-profile-photo strong,.super-profile-photo small{display:block}
    .super-profile-photo small{margin-top:4px;color:var(--muted);font-size:11px}
    @media(max-width:480px){.super-profile-photo{align-items:flex-start;flex-direction:column}}
</style>
@endsection
