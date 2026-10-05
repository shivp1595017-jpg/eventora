<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'booking_number',
        'quantity',
        'ticket_price',
        'total_amount',
        'payment_id',
        'order_id',
        'payment_status',
        'booking_status',
        'qr_code',
    ];

    protected $casts = [
        'ticket_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'quantity' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Event
    |--------------------------------------------------------------------------
    */

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}