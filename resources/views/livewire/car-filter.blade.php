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
                        <input type="text" id="daterange" class="date-picker-input"
                            placeholder="Enter date start and end" wire:model="daterange" readonly>
                    </div>
                </div>
            </div>

            <!-- Inclure les styles et scripts directement dans le composant -->
            <link rel="stylesheet" type="text/css"
                href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

            @push('scripts')
                <script>
                    document.addEventListener('livewire:initialized', function() {
                        initDateRangePicker();

                        // Re-initialize when Livewire updates the DOM
                        Livewire.hook('morph.updated', () => {
                            initDateRangePicker();
                        });
                    });

                    function initDateRangePicker() {
                        if (document.getElementById('daterange')) {
                            // Destroy existing instance if it exists
                            if ($('#daterange').data('daterangepicker')) {
                                $('#daterange').data('daterangepicker').remove();
                            }

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
                                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                                        'September', 'October', 'November', 'December'
                                    ],
                                    firstDay: 1
                                }
                            });

                            $('#daterange').on('apply.daterangepicker', function(ev, picker) {
                                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
                                'DD/MM/YYYY'));

                                // Use Livewire's call() method instead of dispatch
                                @this.call('setDates',
                                    picker.startDate.format('YYYY-MM-DD'),
                                    picker.endDate.format('YYYY-MM-DD'),
                                    $(this).val()
                                );
                            });

                            $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
                                $(this).val('');
                                @this.call('clearDates');
                            });
                        }
                    }
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
                    border: none;
                    border-radius: 8px;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                    font-family: inherit;
                }

                .daterangepicker .calendar-table {
                    border: none;
                    background: white;
                }

                .daterangepicker td.active {
                    background-color: #2d3748 !important;
                    color: white !important;
                }

                .daterangepicker td.in-range {
                    background-color: #e2e8f0;
                    color: #2d3748;
                }

                .daterangepicker td.available:hover {
                    background-color: #f7fafc;
                }

                .daterangepicker .calendar-table th,
                .daterangepicker .calendar-table td {
                    width: 36px;
                    height: 36px;
                }

                .daterangepicker .drp-buttons {
                    border-top: 1px solid #e2e8f0;
                    padding: 1rem;
                }

                .daterangepicker .drp-selected {
                    font-size: 14px;
                    color: #4a5568;
                }

                .daterangepicker .applyBtn,
                .daterangepicker .cancelBtn {
                    padding: 8px 16px;
                    border-radius: 4px;
                    font-size: 14px;
                }

                .daterangepicker .applyBtn {
                    background-color: #2d3748;
                    border-color: transparent;
                }

                .daterangepicker .cancelBtn {
                    color: #4a5568;
                    border-color: #e2e8f0;
                    background: white;
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

                .radio-button input[type="radio"]:checked~.radio-checkmark:before {
                    transform: translate(-50%, -50%) scale(1);
                }

                .radio-label {
                    font-size: 14px;
                    font-weight: 500;
                    color: #333;
                }



            </style>

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


            <!-- Choose car type -->
            <div class="filter-widget">
                <h2 class="filter-widget-title">Choose type of car</h2>
                <div class="filter-widget-content">
                    <div class="custom-select-container">
                        <div class="select-search-wrapper">
                            <input type="text" class="select-search" placeholder="Choose car type"
                                wire:model.live="car_type_search">
                            <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="16"
                                height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                                    <input type="radio" wire:model.live="fuel_type" value="{{ $fuelType->id }}"
                                        name="fuel_type">
                                    <span class="radio-checkmark"></span>
                                    <span class="radio-label">{{ trim($fuelType->fuel_type) }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Car Specifications -->
            <div class="filter-widget">
                <h2 class="filter-widget-title">Car Features</h2>
                <div class="filter-widget-content">
                    <div class="search-box">
                        <input type="text" placeholder="Search features" class="sidebar-search-input">
                    </div>
                    <div class="checkbox-group">
                        @foreach ($features as $feature)
                            {{-- <label class="checkbox-label">
                            <input type="checkbox" wire:model.live="specifications_checked"
                            value="{{ $specification->id }}" class="hidden-checkbox">
                        <span class="checkbox-custom">
                            <svg viewBox="0 0 64 64" height="100%" width="100%">
                                <path
                                    d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16"
                                    class="path"></path>
                            </svg>
                        </span> --}}



                        <label class="container-checkbox">
                            <input type="checkbox" wire:model.live="features_checked" value="{{ $feature->id }}" />
                            <svg viewBox="0 0 64 64" height="2em" width="2em">
                              <path
                                d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16"
                                pathLength="575.0541381835938"
                                class="path"
                              ></path>
                            </svg>
                            <span class="label-text">{{ $feature->feature }}</span>
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
                                <img src="{{ asset('images/defaultcarimage.png') }}" alt="Default Image">
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
                            <div class="car-card-footer">
                                <div class="car-price">${{ number_format($car->price_per_day, 2) }}/Day</div>
                                <a href="{{ route('cars.detail', $car->id) }}" class="book-now">Book Now</a>
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
