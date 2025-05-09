<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'car_id',
        'rating',
        'comment',
        'booking_id'
    ];

    public function user()

    {
        return $this->belongsTo(User::class);
    }

    public function car()

    {
        return $this->belongsTo(Car::class);
    }

    public function booking()

    {
        return $this->belongsTo(Booking::class);
    }
}
