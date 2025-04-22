<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarSpefication extends Model
{
    use HasFactory;

    protected $table = 'car_spefications';

    protected $fillable = [
        'car_id',
        'specification_id',
    ];

    // Relation avec le modèle Car
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    // Relation avec le modèle Specification
    public function specification()
    {
        return $this->belongsTo(Specification::class);
    }
}
