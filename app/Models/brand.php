<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
    ];

    // Relation avec le modèle Car 
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
