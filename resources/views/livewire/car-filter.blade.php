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
                                <div class="select-option" wire:click="{{ $car->model }}"
>
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
                    <div class="date-picker-wrapper" x-data="{
                        showDatePicker: false,
                        startDate: @entangle('start_date'),
                        endDate: @entangle('end_date'),
                        init() {
                            flatpickr('.date-picker-input', {
                                dateFormat: 'Y-m-d',
                                onChange: (selectedDates, dateStr, instance) => {
                                    if (selectedDates.length === 2) {
                                        this.startDate = selectedDates[0].toISOString().split('T')[0];
                                        this.endDate = selectedDates[1].toISOString().split('T')[0];
                                    }
                                }
                            });
                        }
                    }">
                        <span class="calendar-icon">
                            <img src="https://turbo.redq.io/wp-content/uploads/2023/05/date-picker-icon.png"
                                alt="calendar">
                        </span>
                        <input type="text" class="date-picker" placeholder="Choose dates" readonly
                            x-on:click="showDatePicker = true"
                            x-text="startDate && endDate ?
                                `${new Date(startDate).toLocaleDateString()} - ${new Date(endDate).toLocaleDateString()}` :
                                'Choose dates'">

                        <!-- Date Picker Dropdown -->
                        <div class="date-picker-dropdown" x-show="showDatePicker"
                            x-on:click.away="showDatePicker = false" x-transition>
                            <div class="date-picker-grid">
                                <div>
                                    <label>Start Date</label>
                                    <input type="date" wire:model="start_date" x-model="startDate"
                                        class="date-picker-input">
                                </div>
                                <div>
                                    <label>End Date</label>
                                    <input type="date" wire:model="end_date" x-model="endDate"
                                        class="date-picker-input">
                                </div>
                            </div>
                            <button class="date-picker-apply" x-on:click="showDatePicker = false">
                                Apply
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pickup Location -->
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
                                <div class="select-option" wire:click="$set('pickup_location', '{{ $location->id }}')"
                                    :class="{
                                        'selected': '{{ $location->id }}'
                                        === '{{ $pickup_location }}'
                                    }">
                                    {{ $location->name }} - {{ ucfirst(str_replace('_', ' ', $location->type)) }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Choose car type -->
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
                                <div class="select-option" wire:click="{{ $type->id }}">
                                    {{ $type->name }}
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
                    <div class="checkbox-group">
                        @foreach ($fuelTypes as $fuelType)
                            <label class="checkbox-label">
                                <input type="checkbox" wire:model="fuel_type" value="{{ $fuelType->id }}"
                                    class="hidden-checkbox">
                                <span class="checkbox-custom">
                                    <svg viewBox="0 0 64 64" height="100%" width="100%">
                                        <path
                                            d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16"
                                            class="path"></path>
                                    </svg>
                                </span>
                                <span class="label-text">{{ $fuelType->fuel_type }}</span>
                            </label>
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
