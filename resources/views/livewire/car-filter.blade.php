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
        <div class="date-picker-wrapper" x-data="{
            showDatePicker: false,
            startDate: $wire.start_date,
            endDate: $wire.end_date,
            currentMonth: new Date().getMonth(),
            currentYear: new Date().getFullYear(),
            nextMonth: new Date().getMonth() + 1 > 11 ? 0 : new Date().getMonth() + 1,
            nextYear: new Date().getMonth() + 1 > 11 ? new Date().getFullYear() + 1 : new Date().getFullYear(),
            weekdays: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],

            init() {
                // Initialize with current date if none provided
                if (!this.startDate) {
                    const today = new Date();
                    this.startDate = today.toISOString().split('T')[0];
                }

                // Listen for model-selected event from Livewire
                $wire.$on('model-selected', () => {
                    this.startDate = $wire.start_date;
                    this.endDate = $wire.end_date;
                });
            },

            toggleDatePicker() {
                this.showDatePicker = !this.showDatePicker;
            },

            formatDateForDisplay(dateStr) {
                if (!dateStr) return '';
                const date = new Date(dateStr);
                return date.toLocaleDateString('en-US', { month: '2-digit', day: '2-digit', year: 'numeric' });
            },

            formatDateRange() {
                if (this.startDate && !this.endDate) {
                    return this.formatDateForDisplay(this.startDate);
                } else if (this.startDate && this.endDate) {
                    return `${this.formatDateForDisplay(this.startDate)}`;
                }
                return 'Choose dates';
            },

            getDaysInMonth(year, month) {
                return new Date(year, month + 1, 0).getDate();
            },

            getFirstDayOfMonth(year, month) {
                return new Date(year, month, 1).getDay();
            },

            isSelectedDate(date, month, year) {
                const currentDate = new Date(year, month, date).toISOString().split('T')[0];

                if (this.startDate && this.endDate) {
                    return currentDate >= this.startDate && currentDate <= this.endDate;
                }

                return this.startDate === currentDate;
            },

            isToday(date, month, year) {
                const today = new Date();
                return date === today.getDate() && month === today.getMonth() && year === today.getFullYear();
            },

            selectDate(date, month, year) {
                const selectedDate = new Date(year, month, date).toISOString().split('T')[0];

                if (!this.startDate || (this.startDate && this.endDate) || selectedDate < this.startDate) {
                    // Start a new selection
                    this.startDate = selectedDate;
                    this.endDate = null;
                } else {
                    // Complete the range
                    this.endDate = selectedDate;

                    // Update Livewire component values
                    $wire.start_date = this.startDate;
                    $wire.end_date = this.endDate;

                    // Close the picker after selection
                    this.showDatePicker = false;

                    // Refresh the component
                    $wire.$refresh();
                }
            },

            nextMonthPanel() {
                this.currentMonth = (this.currentMonth + 1) % 12;
                if (this.currentMonth === 0) this.currentYear++;

                this.nextMonth = (this.nextMonth + 1) % 12;
                if (this.nextMonth === 0) this.nextYear++;
            },

            prevMonthPanel() {
                this.currentMonth = (this.currentMonth - 1 + 12) % 12;
                if (this.currentMonth === 11) this.currentYear--;

                this.nextMonth = (this.nextMonth - 1 + 12) % 12;
                if (this.nextMonth === 11) this.nextYear--;
            }
        }">
            <div class="input-wrapper" @click="toggleDatePicker()">
                <span class="calendar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </span>
                <input type="text"
                    class="date-picker-input"
                    placeholder="Choose dates"
                    readonly
                    x-bind:value="formatDateRange()">
            </div>

            <!-- Date Picker Dropdown -->
            <div class="date-picker-dropdown" x-show="showDatePicker" @click.away="showDatePicker = false">
                <div class="date-picker-header">
                    <button type="button" class="prev-month-btn" @click="prevMonthPanel">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                    </button>
                    <div class="date-picker-months">
                        <div class="month-display">
                            <span x-text="months[currentMonth] + ' ' + currentYear"></span>
                        </div>
                        <div class="month-display">
                            <span x-text="months[nextMonth] + ' ' + nextYear"></span>
                        </div>
                    </div>
                    <button type="button" class="next-month-btn" @click="nextMonthPanel">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </button>
                </div>

                <div class="date-picker-calendars">
                    <!-- Current Month Calendar -->
                    <div class="calendar-month">
                        <div class="calendar-weekdays">
                            <template x-for="day in weekdays">
                                <div class="weekday" x-text="day"></div>
                            </template>
                        </div>
                        <div class="calendar-days">
                            <!-- Empty cells for days before the 1st -->
                            <template x-for="i in getFirstDayOfMonth(currentYear, currentMonth)">
                                <div class="day-cell empty"></div>
                            </template>

                            <!-- Actual days -->
                            <template x-for="day in getDaysInMonth(currentYear, currentMonth)">
                                <div
                                    class="day-cell"
                                    :class="{
                                        'current-day': isToday(day, currentMonth, currentYear),
                                        'selected': isSelectedDate(day, currentMonth, currentYear)
                                    }"
                                    @click="selectDate(day, currentMonth, currentYear)"
                                >
                                    <span x-text="day"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Next Month Calendar -->
                    <div class="calendar-month">
                        <div class="calendar-weekdays">
                            <template x-for="day in weekdays">
                                <div class="weekday" x-text="day"></div>
                            </template>
                        </div>
                        <div class="calendar-days">
                            <!-- Empty cells for days before the 1st -->
                            <template x-for="i in getFirstDayOfMonth(nextYear, nextMonth)">
                                <div class="day-cell empty"></div>
                            </template>

                            <!-- Actual days -->
                            <template x-for="day in getDaysInMonth(nextYear, nextMonth)">
                                <div
                                    class="day-cell"
                                    :class="{
                                        'current-day': isToday(day, nextMonth, nextYear),
                                        'selected': isSelectedDate(day, nextMonth, nextYear)
                                    }"
                                    @click="selectDate(day, nextMonth, nextYear)"
                                >
                                    <span x-text="day"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.date-picker-wrapper {
    position: relative;
    width: 100%;
}

.input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    cursor: pointer;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    padding: 8px 12px;
    background-color: #fff;
}

.calendar-icon {
    margin-right: 8px;
    color: #666;
}

.date-picker-input {
    border: none;
    outline: none;
    width: 100%;
    font-size: 14px;
    padding: 4px 0;
    cursor: pointer;
}

.date-picker-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 999;
    width: 600px;
    background-color: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin-top: 8px;
    padding: 16px;
}

.date-picker-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.date-picker-months {
    display: flex;
    justify-content: space-around;
    width: 100%;
}

.month-display {
    text-align: center;
    font-weight: 600;
    font-size: 14px;
    width: 50%;
}

.prev-month-btn, .next-month-btn {
    background: none;
    border: none;
    cursor: pointer;
    padding: 4px 8px;
    color: #666;
}

.date-picker-calendars {
    display: flex;
    justify-content: space-between;
    gap: 16px;
}

.calendar-month {
    width: 50%;
}

.calendar-weekdays {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    margin-bottom: 8px;
}

.weekday {
    text-align: center;
    font-size: 12px;
    font-weight: 600;
    color: #666;
    padding: 4px 0;
}

.calendar-days {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 4px;
}

.day-cell {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 32px;
    width: 32px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 13px;
    margin: 0 auto;
}

.day-cell:hover {
    background-color: #f5f5f5;
}

.day-cell.empty {
    pointer-events: none;
}

.day-cell.current-day {
    background-color: #e6f7ff;
    font-weight: 600;
}

.day-cell.selected {
    background-color: #1a73e8;
    color: white;
}

@media (max-width: 768px) {
    .date-picker-dropdown {
        width: 100%;
    }

    .date-picker-calendars {
        flex-direction: column;
    }

    .calendar-month {
        width: 100%;
        margin-bottom: 16px;
    }
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

            <!-- Fuel Type Fix -->
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
                                <span class="label-text">{{ trim($fuelType->fuel_type) }}</span>
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
