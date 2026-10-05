<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\OrganizationStaff;

class OrganizationUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'name',
        'type',
        'description',
        'status',
    ];

    /**
     * Organization this unit belongs to.
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Events belonging to this unit.
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function staff(): HasMany
{
    return $this->hasMany(OrganizationStaff::class);
}
}