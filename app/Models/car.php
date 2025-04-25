<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    // Relations


public function carImages()
{
    return $this->hasMany(CarImage::class);
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

    public function specifications()
    {
        return $this->belongsToMany(Specification::class, 'car_specifications', 'car_id', 'specification_id');
    }
}
