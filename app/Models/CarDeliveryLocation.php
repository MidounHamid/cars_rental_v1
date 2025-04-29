<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarDeliveryLocation extends Model
{

    protected $fillable = [
        'car_id',
        'location_id',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }}
