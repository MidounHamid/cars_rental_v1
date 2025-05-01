<?php

namespace App\Livewire;

use App\Models\Car;
use App\Models\Location;
use App\Models\Specification;
use App\Models\CarType;
use App\Models\FuelType;
use App\Models\Brand;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class CarFilter extends Component
{
    use WithPagination;

    public $locations;
    public $fuelTypes;
    public $typeCars;
    public $specifications;
    public $start_date;
    public $end_date;
    public $pickup_location;
    public $car_brand;
    public $car_model;
    public $car_type;
    public $fuel_type = [];
    public $specifications_checked = [];
    public $features = [];

    // Search variables
    public $pickup_location_search = '';
    public $car_type_search = '';
    public $car_model_search = '';

    public function mount()
    {
        // Initialize filter options
        $this->locations = Location::orderBy('name')->get();
        $this->fuelTypes = FuelType::select('fuel_type')->distinct()->orderBy('fuel_type')->get();

        $this->typeCars = CarType::select('name')->distinct()->orderBy('name')->get();
        $this->specifications = Specification::orderBy('specification')->get();
    }

    public function updated($propertyName)
    {
        // Reset pagination when filters change
        $this->resetPage();
    }

    // Method to handle model selection from dropdown
    public function selectModel($model)
    {
        $this->car_model = trim($model);
        $this->car_model_search = trim($model);
        $this->resetPage();

        // Add this line to dispatch an event for the date picker
        $this->dispatch('model-selected');
    }

    public function filterCars()
    {
        $query = Car::with(['brand', 'carType', 'fuelType', 'carImages', 'agency']);

        // Filter by car brand
        if ($this->car_brand) {
            $query->whereHas('brand', function ($q) {
                $q->where('brand', 'like', '%' . $this->car_brand . '%');
            });
        }

        // Filter by pickup location
        if ($this->pickup_location) {
            $query->whereHas('deliveryLocations', function ($q) {
                $q->where('id', $this->pickup_location);
            });
        }

        // Filter by car model
        if ($this->car_model) {
            $query->where('model', 'like', '%' . $this->car_model . '%');
        }

        // Filter by car type
        if ($this->car_type) {
            $query->where('car_type_id', $this->car_type);
        }

        // Filter by fuel type
        if (!empty($this->fuel_type)) {
            $query->whereIn('fuel_type_id', $this->fuel_type);
        }

        // Filter by specifications
        if (!empty($this->specifications_checked)) {
            $query->whereHas('specifications', function ($q) {
                $q->whereIn('specifications.id', $this->specifications_checked);
            });
        }

        // Filter by features
        if (!empty($this->features)) {
            $query->where(function ($q) {
                foreach ($this->features as $feature) {
                    switch ($feature) {
                        case 'gps':
                            $q->orWhereHas('specifications', function ($sq) {
                                $sq->where('specification', 'like', '%GPS%');
                            });
                            break;
                        case 'unlimited_mileage':
                            $q->orWhereHas('specifications', function ($sq) {
                                $sq->where('specification', 'like', '%kilométrage illimité%');
                            });
                            break;
                        case 'free_shuttle':
                            $q->orWhereHas('specifications', function ($sq) {
                                $sq->where('specification', 'like', '%navette gratuite%');
                            });
                            break;
                        case 'fuel_policy':
                            $q->orWhereHas('specifications', function ($sq) {
                                $sq->where('specification', 'like', '%plein/plein%');
                            });
                            break;
                    }
                }
            });
        }

        // Filter by date range (availability check)
        if ($this->start_date && $this->end_date) {
            $start = Carbon::parse($this->start_date);
            $end = Carbon::parse($this->end_date);
            $query->whereDoesntHave('bookings', function ($q) use ($start, $end) {
                $q->where(function ($subQuery) use ($start, $end) {
                    $subQuery->whereDate('start_date', '<=', $end)
                        ->whereDate('end_date', '>=', $start);
                });
            });
        }

        // Paginate results
        return $query->paginate(10);
    }

    public function resetFilters()
    {
        // Reset all filters and pagination
        $this->reset([
            'pickup_location',
            'car_brand',
            'car_model',
            'car_type',
            'fuel_type',
            'specifications_checked',
            'features',
            'start_date',
            'end_date',
            'pickup_location_search',
            'car_type_search',
            'car_model_search'
        ]);
        $this->resetPage();
    }

    public function render()
    {
        // Get all distinct car models for the dropdown, filtered by selected brand if any
        $carModels = Car::select('cars.id', 'cars.model')
                       ->when($this->car_brand, function($query) {
                           $query->join('brands', 'cars.brand_id', '=', 'brands.id')
                                 ->where('brands.brand', 'like', '%' . $this->car_brand . '%');
                       })
                       ->when($this->car_model_search, function($query) {
                           $query->where('cars.model', 'like', '%' . $this->car_model_search . '%');
                       })
                       ->distinct('cars.model')
                       ->orderBy('cars.model')
                       ->get()
                       // Clean up spaces in model names
                       ->map(function($car) {
                           $car->model = trim($car->model);
                           return $car;
                       });

        // Return view with filtered data
        return view('livewire.car-filter', [
            'cars' => $this->filterCars(),
            'carModels' => $carModels,
            'locations' => $this->locations,
            'fuelTypes' => $this->fuelTypes,
            'typeCars' => $this->typeCars,
            'specifications' => $this->specifications,
        ]);
    }
}
