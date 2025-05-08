<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Car;
use App\Models\Specification;
use Illuminate\Support\Facades\Auth;

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


    public function bookNow()
    {
        // Validate required fields
        if (!$this->pickup_date || !$this->return_date) {
            $this->addError('dates', 'Please select both pickup and return dates');
            return;
        }

        // Calculate final values before saving
        $this->calculateRentalDuration();
        $this->calculateTotalPrice();

        // Check if rental duration is valid
        if ($this->rental_duration <= 0) {
            $this->addError('dates', 'Invalid rental duration. Return date must be after pickup date.');
            return;
        }

        // Get related models that we need
        $fuelType = \App\Models\FuelType::find($this->car->fuel_types_id);
        $carType = \App\Models\CarType::find($this->car->car_type_id);
        $brand = \App\Models\Brand::find($this->car->brand_id);

        // Get specifications with prices
        $selectedSpecs = [];
        $specDetails = [];
        foreach ($this->selected_specifications as $specId => $quantity) {
            if ($quantity > 0) {
                $spec = \App\Models\Specification::find($specId);
                if ($spec) {
                    $selectedSpecs[$specId] = $quantity;
                    $specDetails[$specId] = [
                        'name' => $spec->name,
                        'price' => $spec->price,
                        'quantity' => $quantity
                    ];
                }
            }
        }

        // Calculate duration in days
        $pickupDate = Carbon::parse($this->pickup_date . ' ' . $this->pickup_time);
        $returnDate = Carbon::parse($this->return_date . ' ' . $this->return_time);
        $durationDays = $this->rental_duration;

        // Insurance and service fees
        $insuranceFee = $this->car->insurance->price_per_day ?? 0;
        $serviceFee = 15.00;

        // Calculate total with fees
        $totalPricewithoutFees = ($this->rental_duration * $this->base_price) + $this->additional_options + $insuranceFee + $serviceFee;

        // Get insurance information
        $insurance = \App\Models\Insurance::find($this->car->insurance_id);

        // Get agency information if available
        $agency = null;
        if ($this->car->agency_id) {
            $agency = \App\Models\Agency::find($this->car->agency_id);
        }

        // First create the booking record in the database
        if (!Auth::check()) {
            // If user is not logged in, redirect to login page
            return redirect()->route('login')->with('error', 'Please login to book a car.');
        }

        $booking = \App\Models\Booking::create([
            'user_id' => Auth::id(),
            'car_id' => $this->car->id,
            'start_date' => $this->pickup_date,
            'end_date' => $this->return_date,
            'start_time' => $this->pickup_time,
            'end_time' => $this->return_time,
            'status' => 'pending',
            'total_price' => $totalPricewithoutFees,  // Add total price to booking
            // No payment_id yet as payment hasn't been made
        ]);

        // Prepare all booking data with complete car information based on actual schema
        $bookingData = [
            'booking_id' => $booking->id, // Include the booking ID from the newly created record
            'pickup_date' => $this->pickup_date,
            'pickup_time' => $this->pickup_time,
            'return_date' => $this->return_date,
            'return_time' => $this->return_time,
            'selected_specifications' => $selectedSpecs,
            'spec_details' => $specDetails,
            'base_price' => $this->base_price,
            'rental_duration' => $this->rental_duration,
            'duration_days' => $durationDays,
            'additional_options' => $this->additional_options,
            'insurance_fee' => $insuranceFee,
            'service_fee' => $serviceFee,
            'total_price' => $totalPricewithoutFees,
            'rating' => 4.8, // Default or get from reviews if implemented
            'delivery_locations' => $this->car->deliveryLocations->map(function ($loc) {
                return $loc->name . ' ' . ucfirst($loc->type);
            })->toArray(),
            'car' => [
                'id' => $this->car->id,
                'model' => $this->car->model,
                'price_per_day' => $this->car->price_per_day,
                'seats' => $this->car->seats,
                'transmission' => $this->car->transmission,
                'is_available' => $this->car->is_available,
                'city' => $this->car->city,
                'brand' => $brand ? $brand->brand : 'Unknown Brand',
                'brand_id' => $this->car->brand_id,
                'type' => $carType ? $carType->name : 'Standard',
                'car_type_id' => $this->car->car_type_id,
                'fuel' => $fuelType ? $fuelType->fuel_type : 'N/A', // Corrected line
                'fuel_types_id' => $this->car->fuel_types_id,
                'insurance' => $insurance ? $insurance->name : 'Standard Insurance',
                'insurance_id' => $this->car->insurance_id,
                'agency' => $agency ? $agency->name : null,
                'agency_id' => $this->car->agency_id,
                'gearbox' => $this->car->transmission,
                'image' => $this->car->image
            ],
        ];

        // Store it in the session
        session(['booking_data' => $bookingData]);

        // Redirect properly in Livewire
        return redirect()->route('stripe.payment');
    }



    public function render()
    {
        // Load specifications in the render method to ensure they're always fresh
        $this->specifications = Specification::all();

        return view('livewire.car-rental-calculator');
    }
}
