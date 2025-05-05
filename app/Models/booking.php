<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'car_id', 'start_date', 'end_date',
        'status', 'payment_id', 'promotion_id',    'start_time',
        'end_time',
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
        $this->loadMissing(['car', 'specifications']);

        $car = $this->car;
        $carPricePerDay = $car ? $car->price_per_day : 0;

        $startDate = $this->start_date->format('Y-m-d');
        $endDate = $this->end_date->format('Y-m-d');

        $startDateTime = Carbon::createFromFormat('Y-m-d H:i:s', "$startDate {$this->start_time}");
        $endDateTime = Carbon::createFromFormat('Y-m-d H:i:s', "$endDate {$this->end_time}");

        if ($endDateTime <= $startDateTime) return 0;

        $hours = $startDateTime->diffInHours($endDateTime);
        $days = max(1, ceil($hours / 24));

        $basePrice = $carPricePerDay * $days;
        $specTotal = $this->specifications->sum(fn($spec) =>
            $spec->pivot->price * $spec->pivot->quantity
        );

        $total = $basePrice + $specTotal;

        if ($this->promotion) {
            $total *= (1 - $this->promotion->discount_percent / 100);
        }

        return round($total, 2);
    }



}
