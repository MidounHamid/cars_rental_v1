<div class="page-container">
    {{-- Sidebar --}}
    <div class="inspect-filter-form-wrapper">
        <div class="sidebar-header">
            <h3 class="sidebar-header-title">Filter</h3>
            <span class="sidebar-header-button" wire:click="resetFilters">Reset</span>
        </div>

        <form>
            <!-- Quick Search for Brand -->
            <div class="filter-widget">
                <h2 class="filter-widget-title">Quick Search</h2>
                <div class="filter-widget-content">
                    <input type="search" wire:model.live="car_brand" placeholder="Choose brand"
                        class="sidebar-search-input">
                </div>
            </div>
            <!-- Choose model -->
            <div class="filter-widget">
                <h2 class="filter-widget-title">Choose Model</h2>
                <div class="filter-widget-content">
                    <div class="custom-select-container">
                        <div class="select-search-wrapper">
                            <input type="text" wire:model.live="car_model_search" class="select-search"
                                placeholder="Choose model">
                        </div>
                        <div class="select-options">
                            @foreach ($carModels as $car)
                                <div class="select-option" wire:click="selectModel('{{ $car->model }}')">
                                    {{ $car->model }}
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" wire:model="car_model" class="select-value">
                    </div>
                </div>
            </div>

<!-- Date Picker -->
<div class="filter-widget">
    <h2 class="filter-widget-title">Choose Dates</h2>
    <div class="filter-widget-content">
        <div class="date-picker-wrapper" wire:ignore>
            <input type="text" id="daterange" class="date-picker-input" placeholder="Enter date start and end"
                wire:model="daterange" readonly>
        </div>
    </div>
</div>

<!-- Inclure les styles et scripts directement dans le composant -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

@push('scripts')
<script>
$(document).ready(function() {
    $('#daterange').daterangepicker({
        opens: 'right',
        autoUpdateInput: false,
        locale: {
            format: 'DD/MM/YYYY',
            separator: ' - ',
            applyLabel: 'Apply',
            cancelLabel: 'Clear',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            weekLabel: 'W',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        }
    });

    $('#daterange').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        @this.set('start_date', picker.startDate.format('YYYY-MM-DD'));
        @this.set('end_date', picker.endDate.format('YYYY-MM-DD'));
    });

    $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        @this.set('start_date', null);
        @this.set('end_date', null);
    });
});
</script>
@endpush

<style>
.date-picker-wrapper {
    position: relative;
    width: 100%;
}

.date-picker-input {
    width: 100%;
    padding: 11px 12px 10px 35px;
    border: 1px solid #e6e6e6;
    border-radius: 4px;
    font-size: 14px;
    color: #333;
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23333' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='2' ry='2'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3C/svg%3E") no-repeat 10px center;
    cursor: pointer;
}

.date-picker-input:focus {
    outline: none;
    border-color: #000;
}

/* DateRangePicker Styles */
.daterangepicker {
    font-family: inherit;
    border-color: #333;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin-top: 5px;
}

.daterangepicker.opensright:before {
    left: 9px;
}

.daterangepicker.opensright:after {
    left: 10px;
}

.daterangepicker:before {
    border-bottom: 7px solid #333;
}

.daterangepicker:after {
    border-bottom: 6px solid #fff;
}

.daterangepicker td.active, 
.daterangepicker td.active:hover {
    background-color: #333;
}

.daterangepicker td.in-range {
    background-color: #f5f5f5;
    color: #333;
}

.daterangepicker .calendar-table {
    border: none;
    background-color: #fff;
}

.daterangepicker .calendar-table .next span, 
.daterangepicker .calendar-table .prev span {
    border-color: #333;
}

.daterangepicker .ranges li.active {
    background-color: #333;
}

.daterangepicker .drp-buttons .btn {
    border: 1px solid #333;
}

.daterangepicker .drp-buttons .btn-primary {
    background-color: #333;
    color: #fff;
}

.daterangepicker .drp-buttons .btn-default {
    color: #333;
}

.daterangepicker .calendar-table .next,
.daterangepicker .calendar-table .prev,
.daterangepicker .calendar-table .next.available,
.daterangepicker .calendar-table .prev.available {
    border: none;
    background: transparent;
}

.daterangepicker .calendar-table th, 
.daterangepicker .calendar-table td {
    color: #999;
}

.daterangepicker .calendar-table th.month {
    color: #333;
    font-weight: 600;
}

.daterangepicker td.off, 
.daterangepicker td.off.in-range, 
.daterangepicker td.off.start-date, 
.daterangepicker td.off.end-date {
    background-color: #fff;
    color: #999;
}

.daterangepicker .drp-calendar {
    padding: 8px;
}

.daterangepicker .drp-calendar.left {
    padding-right: 8px;
}

.daterangepicker .drp-calendar.right {
    padding-left: 8px;
}

/* Radio Button Styles */
.radio-container {
    margin: 0 auto;
    max-width: 100%;
    color: #333;
}

.radio-wrapper {
    margin-bottom: 12px;
}

.radio-button {
    display: flex;
    align-items: center;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
}

.radio-button:hover {
    transform: translateY(-2px);
}

.radio-button input[type="radio"] {
    display: none;
}

.radio-checkmark {
    display: inline-block;
    position: relative;
    width: 16px;
    height: 16px;
    margin-right: 10px;
    border: 2px solid #333;
    border-radius: 50%;
}

.radio-checkmark:before {
    content: "";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0);
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background-color: #333;
    transition: all 0.2s ease-in-out;
}

.radio-button input[type="radio"]:checked ~ .radio-checkmark:before {
    transform: translate(-50%, -50%) scale(1);
}

.radio-label {
    font-size: 14px;
    font-weight: 500;
    color: #333;
}
</style>

            <!-- Pickup Location Fix -->
            <div class="filter-widget">
                <h2 class="filter-widget-title">Pickup Location</h2>
                <div class="filter-widget-content">
                    <div class="custom-select-container">
                        <div class="select-search-wrapper">
                            <input type="text" class="select-search" placeholder="Choose Location"
                                wire:model.live="pickup_location_search">
                            <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </div>
                        <div class="select-options">
                            @foreach ($locations as $location)
                                <div class="select-option"
                                    wire:click="selectPickupLocation('{{ $location->id }}', '{{ trim($location->name) }}')"
                                    @if ($pickup_location == $location->id) class="selected" @endif>
                                    {{ trim($location->name) }} - {{ ucfirst(str_replace('_', ' ', $location->type)) }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>


            <!-- Choose car type Fix -->
            <div class="filter-widget">
                <h2 class="filter-widget-title">Choose type of car</h2>
                <div class="filter-widget-content">
                    <div class="custom-select-container">
                        <div class="select-search-wrapper">
                            <input type="text" class="select-search" placeholder="Choose car type"
                                wire:model.live="car_type_search">
                            <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </div>
                        <div class="select-options">
                            @foreach ($typeCars as $type)
                                <div class="select-option"
                                    wire:click="selectCarType('{{ $type->id }}', '{{ trim($type->name) }}')"
                                    @if ($car_type == $type->id) class="selected" @endif>
                                    {{ trim($type->name) }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fuel Type -->
            <div class="filter-widget">
                <h2 class="filter-widget-title">Fuel Type</h2>
                <div class="filter-widget-content">
                    <div class="radio-container">
                        @foreach ($fuelTypes as $fuelType)
                            <div class="radio-wrapper">
                                <label class="radio-button">
                                    <input type="radio" 
                                           wire:model="fuel_type" 
                                           value="{{ $fuelType->id }}"
                                           name="fuel_type">
                                    <span class="radio-checkmark"></span>
                                    <span class="radio-label">{{ trim($fuelType->fuel_type) }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Specifications -->
            <div class="filter-widget">
                <h2 class="filter-widget-title">Specifications</h2>
                <div class="filter-widget-content">
                    <div class="checkbox-group">
                        @foreach ($specifications as $specification)
                            <label class="checkbox-label">
                                <input type="checkbox" wire:model="specifications_checked"
                                    value="{{ $specification->id }}" class="hidden-checkbox">
                                <span class="checkbox-custom">
                                    <svg viewBox="0 0 64 64" height="100%" width="100%">
                                        <path
                                            d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16"
                                            class="path"></path>
                                    </svg>
                                </span>
                                <span class="label-text">{{ $specification->specification }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Main Content --}}
    <main class="main-content">
        <div class="results-count">
            <span>{{ $cars->total() }} items found</span>
        </div>
        <div class="cars-grid">
            @if ($cars->isEmpty())
                <p>No cars available at the moment.</p>
            @else
                @foreach ($cars as $car)
                    <div class="car-card">
                        <div class="car-image">
                            @php
                                $primaryImage = $car->carImages->firstWhere('is_primary', true);
                            @endphp
                            @if ($primaryImage)
                                <img src="{{ asset('storage/' . $primaryImage->image_path) }}"
                                    alt="{{ $car->brand->brand }} {{ $car->model }}">
                            @else
                                <img src="{{ asset('storage/defaultcarimage.png') }}" alt="Default Image">
                            @endif
                        </div>
                        <div class="car-info">
                            <div class="car-header">
                                <h2>{{ strtoupper($car->brand->brand) }} {{ strtoupper($car->model) }}</h2>
                                <span class="status-badge {{ $car->is_available ? 'available' : 'unavailable' }}">
                                    <i class="fas fa-{{ $car->is_available ? 'check-circle' : 'times-circle' }}"></i>
                                    {{ $car->is_available ? 'Available' : 'Unavailable' }}
                                </span>
                            </div>
                            <div class="car-specs">
                                <div class="car-spec-item">
                                    <i class="fas fa-car"></i>
                                    <span>{{ $car->carType->name }}</span>
                                </div>
                                <div class="car-spec-item">
                                    <i class="fas fa-building"></i>
                                    <span>{{ $car->agency->name ?? 'N/A' }}</span>
                                </div>
                                <div class="car-spec-item">
                                    <i class="fas fa-gas-pump"></i>
                                    <span>{{ $car->fuelType->fuel_type }}</span>
                                </div>
                                <div class="car-spec-item">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>{{ $car->insurance_type ?? 'Standard Insurance' }}</span>
                                </div>
                                <div class="car-spec-item">
                                    <i class="fas fa-users"></i>
                                    <span>{{ $car->seats }} Seats</span>
                                </div>
                                <div class="car-spec-item">
                                    <i class="fas fa-star" style="color: #ffc107;"></i>
                                    <span>({{ $car->rating ?? '4.8' }} reviews)</span>
                                </div>
                            </div>
                            <div class="car-description">
                                {{ $car->description ?? 'Luxurious car with premium features, perfect for both city driving and long trips.' }}
                            </div>
                            <div class="car-footer">
                                <div class="car-price">
                                    <span class="price">{{ number_format($car->price_per_day, 0, ',', ' ') }}</span>
                                    <span class="price-currency">DH/Day</span>
                                </div>
                                <button class="book-now">BOOK NOW</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Pagination -->
        <div class="pagination-container">
            {{ $cars->links('vendor.pagination.custom-car-home') }}
        </div>
    </main>
</div>
