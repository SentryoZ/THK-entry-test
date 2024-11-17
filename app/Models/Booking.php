<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'hotel_id',
        'customer_name',
        'customer_contact',
        'checkin_time',
        'checkout_time',
    ];

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'hotel_id');
    }

    protected function casts()
    {
        return [
            'checkin_time' => 'timestamp',
            'checkout_time' => 'timestamp',
        ];
    }
}
