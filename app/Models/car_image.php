<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class car_image extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['car_id', 'image_path', 'is_primary'];

    protected $casts = ['is_primary' => 'boolean'];

    public function car() {
        return $this->belongsTo(Car::class);
    }
}
