<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{

    protected $fillable = ['name', 'type'];

    public function cars()
    {
        return $this->belongsToMany(Car::class, 'car_delivery_locations');
    }

}
