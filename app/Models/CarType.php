<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // exemple de champs, à adapter
    ];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
