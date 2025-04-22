<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mode_payment extends Model
{
    use HasFactory;
    protected $fillable = ['mode_payment'];

    public function payments() {
        return $this->hasMany(Payment::class);
    }
}
