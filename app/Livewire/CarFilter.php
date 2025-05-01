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
    public $daterange = '';

    public $pickup_location;
    public $car_brand;
    public $car_model;
    public $car_type;
    public $fuel_type = null;
    public $specifications_checked = [];

    public $pickup_location_search = '';
    public $car_type_search = '';
    public $car_model_search = '';

    public $pickup_location_name = '';
    public $car_type_name = '';

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'set-dates' => 'setDates',
        'clear-dates' => 'clearDates',
    ];



    public function setDates($start, $end, $display = null)
    {
        $this->start_date = $start;
        $this->end_date = $end;
        $this->daterange = $display ?? $this->daterange;
        $this->resetPage();
    }
    public function mount()
    {
        $this->locations = Location::orderBy('name')->get();
        $this->fuelTypes = FuelType::select('id', 'fuel_type')->distinct()->orderBy('fuel_type')->get();
        $this->typeCars = CarType::select('id', 'name')->distinct()->orderBy('name')->get();
        $this->specifications = Specification::orderBy('specification')->get();
    }

    public function updated($propertyName)
    {
        $this->resetPage();
    }


    public function clearDates()
    {
        $this->start_date = null;
        $this->end_date = null;
        $this->daterange = '';
        $this->resetPage();
    }

    public function selectModel($model)
    {
        $this->car_model = trim($model);
        $this->car_model_search = trim($model);
        $this->resetPage();
        $this->dispatch('model-selected');
    }

    public function selectPickupLocation($id, $name)
    {
        $this->pickup_location = $id;
        $this->pickup_location_name = $name;
        $this->pickup_location_search = $name;
        $this->resetPage();
    }

    public function selectCarType($id, $name)
    {
        $this->car_type = $id;
        $this->car_type_name = $name;
        $this->car_type_search = $name;
        $this->resetPage();
    }

    public function filterCars()
    {
        $query = Car::with(['brand', 'carType', 'fuelType', 'carImages', 'agency']);

        if ($this->car_brand) {
            $query->whereHas('brand', function ($q) {
                $q->where('brand', 'like', '%' . $this->car_brand . '%');
            });
        }

        if ($this->pickup_location) {
            $query->whereHas('deliveryLocations', function ($q) {
                $q->where('id', $this->pickup_location);
            });
        }

        if ($this->car_model) {
            $query->where('model', 'like', '%' . $this->car_model . '%');
        }

        if ($this->car_type) {
            $query->where('car_type_id', $this->car_type);
        }


        if ($this->fuel_type) {
            $query->whereHas('fuelType', function ($q) {
                $q->where('id', $this->fuel_type);
            });
        }


        if (!empty($this->specifications_checked)) {
            $query->whereHas('specifications', function ($q) {
                $q->whereIn('specifications.id', $this->specifications_checked);
            });
        }

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

        return $query->paginate(10);
    }

    public function resetFilters()
    {
        $this->reset([
            'pickup_location',
            'pickup_location_name',
            'car_brand',
            'car_model',
            'car_type',
            'car_type_name',
            'fuel_type',
            'specifications_checked',
            'start_date',
            'end_date',
            'daterange',
            'pickup_location_search',
            'car_type_search',
            'car_model_search'
        ]);

        $this->resetPage();
    }

    public function render()
    {
        $carModels = Car::select('cars.id', 'cars.model')
            ->when($this->car_brand, function ($query) {
                $query->join('brands', 'cars.brand_id', '=', 'brands.id')
                      ->where('brands.brand', 'like', '%' . $this->car_brand . '%');
            })
            ->when($this->car_model_search, function ($query) {
                $query->where('cars.model', 'like', '%' . $this->car_model_search . '%');
            })
            ->distinct('cars.model')
            ->orderBy('cars.model')
            ->get()
            ->map(function ($car) {
                $car->model = trim($car->model);
                return $car;
            });

        $filteredLocations = $this->locations->filter(function ($location) {
            return $this->pickup_location_search === '' ||
                stripos($location->name, $this->pickup_location_search) !== false;
        });

        $filteredCarTypes = $this->typeCars->filter(function ($type) {
            return $this->car_type_search === '' ||
                stripos($type->name, $this->car_type_search) !== false;
        });

        return view('livewire.car-filter', [
            'cars' => $this->filterCars(),
            'carModels' => $carModels,
            'locations' => $filteredLocations,
            'fuelTypes' => $this->fuelTypes,
            'typeCars' => $filteredCarTypes,
            'specifications' => $this->specifications,
        ]);
    }
}
