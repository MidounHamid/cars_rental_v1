<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Car;

class CarBooking extends Component
{
    public $car;
    public $pickup_date;
    public $return_date;
    public $total_price = 0;

    public function mount(Car $car)
    {
        $this->car = $car;
    }

    public function updatedPickupDate()
    {
        $this->calculateTotalPrice();
    }

    public function updatedReturnDate()
    {
        $this->calculateTotalPrice();
    }

    public function calculateTotalPrice()
    {
        if ($this->pickup_date && $this->return_date) {
            try {
                $pickup = Carbon::parse($this->pickup_date);
                $return = Carbon::parse($this->return_date);

                if ($return->gt($pickup)) {
                    // Ensure correct order: from pickup to return
                    $days = $pickup->diffInDays($return) + 1;
                    $this->total_price = $days * $this->car->price_per_day;
                } else {
                    $this->total_price = 0;
                }
            } catch (\Exception $e) {
                $this->total_price = 0;
            }
        }
    }

    public function render()
    {
        return view('livewire.car-booking');
    }
}
