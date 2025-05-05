<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'car_id', 'start_date', 'end_date', 
        'status', 'payment_id', 'promotion_id'
    ];


    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        // other casts...
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function car() {
        return $this->belongsTo(Car::class);
    }

    public function promotion() {
        return $this->belongsTo(Promotion::class);
    }

    public function payment() {
        return $this->hasOne(Payment::class);
    }
    public function specifications()
    {
        return $this->belongsToMany(Specification::class, 'booking_specifications')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }



    public function getTotalPriceAttribute()
{
    $carPricePerDay = $this->car->price ?? 0;
    $days = $this->start_date->diffInDays($this->end_date) + 1;

    $base = $carPricePerDay * $days;

    $specTotal = $this->specifications->sum(function ($spec) {
        return $spec->pivot->price * $spec->pivot->quantity;
    });

    $total = $base + $specTotal;

    if ($this->promotion) {
        $total -= $total * ($this->promotion->discount_percent / 100);
    }

    return round($total, 2);
}

}
