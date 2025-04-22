<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;
    protected $fillable = ['discount_percent', 'expires_at', 'starts_at'];

    public function bookings() {
        return $this->hasMany(Booking::class);
    }
}
