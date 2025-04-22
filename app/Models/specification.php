<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    use HasFactory;

    protected $fillable = [
        'specification',
    ];

    //  la relation avec les voitures
    public function cars()
    {
        return $this->belongsToMany(Car::class, 'car_spefications', 'specification_id', 'car_id');
    }
}
