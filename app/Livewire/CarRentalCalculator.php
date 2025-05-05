<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Car;
use App\Models\Specification;

class CarRentalCalculator extends Component
{
    public $car;
    public $pickup_date;
    public $pickup_time;
    public $return_date;
    public $return_time;
    public $rental_duration = 0;
    public $total_price = 0;
    public $base_price = 0;
    public $additional_options = 0;

    // Specifications from database
    public $specifications = [];
    public $selected_specifications = [];

    public function mount(Car $car)
    {
        $this->car = $car;
        $this->base_price = $car->price_per_day;
        $this->pickup_time = '10:00';
        $this->return_time = '10:00';

        // Initialize selected_specifications with 0 for each spec
        $specifications = Specification::all();
        foreach ($specifications as $spec) {
            $this->selected_specifications[$spec->id] = 0;
        }
    }

    // Livewire lifecycle hook when any property is updated
    public function updated($name)
    {
        if (in_array($name, ['pickup_date', 'pickup_time', 'return_date', 'return_time'])) {
            $this->calculateRentalDuration();
        }
    }

    public function increaseSpecQuantity($specId)
    {
        if (!isset($this->selected_specifications[$specId])) {
            $this->selected_specifications[$specId] = 0;
        }
        $this->selected_specifications[$specId]++;
        $this->calculateAdditionalOptions();
    }

    public function decreaseSpecQuantity($specId)
    {
        if (!isset($this->selected_specifications[$specId])) {
            $this->selected_specifications[$specId] = 0;
            return;
        }

        if ($this->selected_specifications[$specId] > 0) {
            $this->selected_specifications[$specId]--;
            $this->calculateAdditionalOptions();
        }
    }

    public function resetSpecQuantity($specId)
    {
        $this->selected_specifications[$specId] = 0;
        $this->calculateAdditionalOptions();
    }

    public function calculateRentalDuration()
    {
        if ($this->pickup_date && $this->return_date) {
            try {
                $pickup = Carbon::parse($this->pickup_date . ' ' . ($this->pickup_time ?: '10:00'));
                $return = Carbon::parse($this->return_date . ' ' . ($this->return_time ?: '10:00'));

                if ($return->gt($pickup)) {
                    // Calculate duration in days (partial days count as full days)
                    $duration = ceil($pickup->floatDiffInDays($return));
                    $this->rental_duration = max(1, $duration); // Minimum 1 day
                } else {
                    $this->rental_duration = 0;
                }
            } catch (\Exception $e) {
                $this->rental_duration = 0;
            }
        } else {
            $this->rental_duration = 0;
        }

        $this->calculateTotalPrice();
    }

    public function calculateAdditionalOptions()
    {
        $this->additional_options = 0;

        foreach ($this->selected_specifications as $specId => $quantity) {
            if ($quantity > 0) {
                $spec = Specification::find($specId);
                if ($spec) {
                    $this->additional_options += $quantity * $spec->price;
                }
            }
        }

        $this->calculateTotalPrice();
    }

    public function calculateTotalPrice()
    {
        $this->total_price = ($this->rental_duration * $this->base_price) + $this->additional_options;
    }

    public function render()
    {
        // Load specifications in the render method to ensure they're always fresh
        $this->specifications = Specification::all();

        return view('livewire.car-rental-calculator');
    }
}
