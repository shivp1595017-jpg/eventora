<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Organization;
use App\Models\OrganizationStaff;
use App\Models\Booking;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Passwords\CanResetPassword;

#[Fillable([
    'name',
    'email',
    'google_avatar_url',
    'profile_photo_path',
    'password',
    'role',
    'admin_permissions',
])]
#[Hidden([
    'password',
    'remember_token',
])]
class User extends Authenticatable implements CanResetPasswordContract
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, CanResetPassword;

    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }

    /**
     * Organization staff record for this user.
     */
    public function organizationStaff()
    {
        return $this->hasMany(OrganizationStaff::class);
    }

    /**
     * Get the organization assigned to the current account.
     *
     * Organization Admin:
     * organizations.user_id
     *
     * Organization Staff:
     * organization_staff.user_id
     */
    public function currentOrganization(): ?Organization
    {
        if ($this->role === 'organization_admin') {
            return $this->organizations()
                ->where('status', 'approved')
                ->latest()
                ->first();
        }

        if ($this->role === 'organization_staff') {
            return $this->organizationStaff()
                ->with('organization')
                ->where('status', 'active')
                ->latest()
                ->first()
                ?->organization;
        }

        return null;
    }

    /**
     * Get the staff profile for the current account.
     */
    public function currentOrganizationStaff(): ?OrganizationStaff
    {
        if ($this->role !== 'organization_staff') {
            return null;
        }

        return $this->organizationStaff()
            ->where('status', 'active')
            ->latest()
            ->first();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'admin_permissions' => 'array',
        ];
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function profilePhotoUrl(): ?string
    {
        if ($this->profile_photo_path) {
            return \Illuminate\Support\Facades\Storage::disk('public')->url($this->profile_photo_path);
        }

        return $this->google_avatar_url ?: null;
    }
}
