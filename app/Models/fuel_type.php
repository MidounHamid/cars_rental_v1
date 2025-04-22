<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fuel_type extends Model
{
    use HasFactory;

    protected $fillable = [
        'fuel_type',
    ];

    // Relation avec le modèle Car (si un type de carburant peut être associé à plusieurs voitures)
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
