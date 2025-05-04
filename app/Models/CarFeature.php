<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarFeature extends Model
{
    use HasFactory;

    protected $table = 'car_features';

    protected $fillable = [
        'car_id',
        'feature_id',
    ];

    // Relation avec le modèle Car
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    // Relation avec le modèle Specification
    public function feature()
    {
        return $this->belongsTo(Feature ::class);
    }
}
