<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\OrganizationUnit;
use App\Models\OrganizationStaff;


class Organization extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'type',
        'logo',
        'cover_image',
        'description',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'website',
        'status',
    ];


    /*
    |--------------------------------------------------------------------------
    | Organization Owner
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Organization Events
    |--------------------------------------------------------------------------
    */

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function organizationUnits()
{
    return $this->hasMany(OrganizationUnit::class);
}

public function organizationStaff()
{
    return $this->hasMany(OrganizationStaff::class);
}
}