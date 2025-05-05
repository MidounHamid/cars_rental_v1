<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingSpecification extends Model
{

    use HasFactory;

    protected $fillable = ['booking_id', 'specification_id', 'quantity', 'price'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function specification()
    {
        return $this->belongsTo(Specification::class);
    }}
