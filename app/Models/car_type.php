<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car_type extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    // Relation avec le modèle Car ( un type peut avoir plusieurs voitures)
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
