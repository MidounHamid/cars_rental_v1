<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_id', 'amount', 'method', 'transaction_id', 'status', 'mode_payment_id'
    ];

    public function booking() {
        return $this->belongsTo(Booking::class);
    }

    public function modePayment() {
        return $this->belongsTo(mode_payment::class, 'mode_payment_id');
    }
}
