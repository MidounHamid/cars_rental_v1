<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'model',
        'car_type_id',
        'city',
        'price_per_day',
        'fuel_types_id',
        'transmission',
        'seats',
        'is_available',
        'agency_id',
        'brand_id',
        'insurance_id',
        'available_from',
        'available_to',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'available_from' => 'datetime',
        'available_to' => 'datetime',
        'is_available' => 'boolean',
        'price_per_day' => 'decimal:2',
        'seats' => 'integer',
    ];

    protected $appends = ['average_rating', 'total_reviews'];

    // Returns all car images
    public function carImages()
    
    {
        return $this->hasMany(CarImage::class);
    }

    // Get the primary image specifically marked as primary
    public function primaryImage()
    {
        return $this->hasOne(CarImage::class)->where('is_primary', true);
    }

    public function brand()

    {
        return $this->belongsTo(Brand::class);
    }

    public function carType()
    {
        return $this->belongsTo(CarType::class);
    }

    public function fuelType()

    {
        return $this->belongsTo(FuelType::class, 'fuel_types_id');
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function insurance()

    {
        return $this->belongsTo(Insurance::class);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'car_features', 'car_id', 'feature_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function deliveryLocations()
    {
        return $this->belongsToMany(Location::class, 'car_delivery_locations');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getIsAvailableAttribute()
    {
        $today = Carbon::today();

        return !$this->bookings()
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->exists();
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->count();
    }
}
