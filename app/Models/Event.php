<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'organization_id',
        'organization_unit_id',
        'title',
        'slug',
        'category',
        'description',
        'banner',
        'event_date',
        'event_time',
        'venue',
        'city',
        'ticket_price',
        'total_seats',
        'available_seats',
        'status',
    ];


    public function organization(): BelongsTo
    {
        return $this->belongsTo(
            Organization::class
        );
    }


    public function organizationUnit(): BelongsTo
    {
        return $this->belongsTo(
            OrganizationUnit::class
        );
    }


    public function bookings(): HasMany
    {
        return $this->hasMany(
            Booking::class
        );
    }
}