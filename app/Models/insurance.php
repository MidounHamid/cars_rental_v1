<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price_per_day',
    ];

    // Relation avec le modèle Car (une assurance peut être associée à plusieurs voitures)
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
