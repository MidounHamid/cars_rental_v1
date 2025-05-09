<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'car_id',
        'start_date',
        'end_date',
        'status',
        'payment_id',
        'promotion_id',
        'start_time',
        'end_time',
    ];


    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_price' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    public function specifications()
    {
        return $this->belongsToMany(Specification::class, 'booking_specifications')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }



    public function calculateTotalPrice()
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

        // Calculate base price
        $basePrice = $carPricePerDay * $days;

        // Calculate specifications total
        $specTotal = $this->specifications->sum(
            fn($spec) => $spec->pivot->price * $spec->pivot->quantity
        );

        // Calculate insurance fee
        $insuranceFee = 0;
        if ($this->car && $this->car->insurance) {
            $insuranceFee = $this->car->insurance->price_per_day * $days;
        }

        // Service fee
        $serviceFee = 15.0;

        // Calculate promotion discount
        $promotionDiscount = 0;
        if ($this->promotion) {
            $promotionDiscount = ($basePrice * $this->promotion->discount_percent) / 100;
        }

        // Calculate final total
        $total = $basePrice - $promotionDiscount + $insuranceFee + $serviceFee + $specTotal;

        return round($total, 2);
    }

    /**
     * Get the total price attribute.
     * This is an accessor that maintains compatibility with existing code.
     */
    public function getTotalPriceAttribute()
    {
        return $this->calculateTotalPrice();
    }
}
