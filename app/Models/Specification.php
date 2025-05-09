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

    // Get the icon based on the name if not set
    public function getIconAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }

        // Default icons based on common specification names
        $icons = [
            'gps' => 'map-marker-alt',
            'navigation' => 'compass',
            'child' => 'baby',
            'seat' => 'chair',
            'wifi' => 'wifi',
            'hotspot' => 'wifi',
            'driver' => 'user-tie',
            'service' => 'concierge-bell'
        ];

        // Try to find a matching icon based on the name
        foreach ($icons as $keyword => $icon) {
            if (stripos($this->name, $keyword) !== false) {
                return $icon;
            }
        }

        // Default icon
        return 'cog';
    }
}
