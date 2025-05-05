<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    use HasFactory;

    // Define the table name if it's not the plural form of the model
    protected $table = 'specifications';

    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'name',
        'price',
    ];


    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_specifications')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }
}
