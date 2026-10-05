<?php

namespace App\Models;

use App\Models\Event;
use App\Models\OrganizationUnit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationStaff extends Model
{
    use HasFactory;

    protected $table = 'organization_staff';

    protected $fillable = [
        'organization_id',
        'organization_unit_id',
        'user_id',
        'created_by_user_id',
        'name',
        'email',
        'mobile',
        'role',
        'permissions',
        'status',
    ];

    protected $casts = [
        'permissions' => 'array',
    ];


    /**
     * Organization
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(
            \App\Models\Organization::class
        );
    }


    /**
     * Primary organization unit
     */
    public function organizationUnit(): BelongsTo
    {
        return $this->belongsTo(
            OrganizationUnit::class
        );
    }


    /**
     * Staff login user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class
        );
    }


    /**
     * User/Admin who added this staff member
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by_user_id'
        );
    }


    /**
     * Multiple organization units
     */
    public function organizationUnits()
    {
        return $this->belongsToMany(
            OrganizationUnit::class,
            'organization_staff_units',
            'organization_staff_id',
            'organization_unit_id'
        );
    }


    /**
     * Multiple assigned events
     */
    public function events()
    {
        return $this->belongsToMany(
            Event::class,
            'organization_staff_events',
            'organization_staff_id',
            'event_id'
        );
    }
}