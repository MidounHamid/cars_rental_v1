<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agencie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'address',
        'phone',
        'logo',
    ];


    // Une agence peut avoir plusieurs voitures
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
