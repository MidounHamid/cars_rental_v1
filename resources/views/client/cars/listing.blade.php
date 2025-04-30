<x-app-layout>
    <div class="page-container">
        {{-- Sidebar --}}
        <div class="inspect-filter-form-wrapper">
            <div class="sidebar-header">
                <h3 class="sidebar-header-title">Filter</h3>
                <span class="sidebar-header-button">Reset</span>
            </div>
    
            <form id="inspect-filter-form">
                <!-- Quick Search -->
                <div class="filter-widget">
                    <h2 class="filter-widget-title">Quick Search</h2>
                    <div class="filter-widget-content">
                        <input type="search" name="text-search" placeholder="Ex. Audi" class="sidebar-search-input">
                    </div>
                </div>
    
                <!-- Date Picker -->
                <div class="filter-widget">
                    <h2 class="filter-widget-title">Choose Dates</h2>
                    <div class="filter-widget-content">
                        <div class="date-picker-wrapper">
                            <span class="calendar-icon">
                                <img src="https://turbo.redq.io/wp-content/uploads/2023/05/date-picker-icon.png" alt="calendar">
                            </span>
                            <input type="text" class="date-picker" placeholder="Choose dates" readonly>
                        </div>
                    </div>
                </div>
    
                <!-- Pickup Location -->
                <div class="filter-widget">
                    <h2 class="filter-widget-title">Pickup Location</h2>
                    <div class="filter-widget-content">
                        <div class="custom-select-container">
                            <div class="select-search-wrapper">
                                <input type="text" class="select-search" placeholder="Choose Location">
                                <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                            </div>
                            <div class="select-options">
                                <div class="select-option" data-value="chicago-il">Chicago, IL</div>
                                <div class="select-option" data-value="los-angeles-ca">Los Angeles, CA</div>
                                <div class="select-option" data-value="miami-fl">Miami, FL</div>
                                <div class="select-option" data-value="new-york-city-ny">New York City, NY</div>
                                <div class="select-option" data-value="seattle-wa">Seattle, WA</div>
                            </div>
                            <input type="hidden" name="pickup_location" class="select-value">
                        </div>
                    </div>
                </div>
    
                <!-- Return Location -->
                <div class="filter-widget">
                    <h2 class="filter-widget-title">Return Location</h2>
                    <div class="filter-widget-content">
                        <div class="custom-select-container">
                            <div class="select-search-wrapper">
                                <input type="text" class="select-search" placeholder="Choose Location">
                                <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                            </div>
                            <div class="select-options">
                                <div class="select-option" data-value="chicago-il">Chicago, IL</div>
                                <div class="select-option" data-value="los-angeles-ca">Los Angeles, CA</div>
                                <div class="select-option" data-value="miami-fl">Miami, FL</div>
                                <div class="select-option" data-value="new-york-city-ny">New York City, NY</div>
                                <div class="select-option" data-value="seattle-wa">Seattle, WA</div>
                            </div>
                            <input type="hidden" name="return_location" class="select-value">
                        </div>
                    </div>
                </div>
    
                <!-- Categories -->
                <div class="filter-widget">
                    <h2 class="filter-widget-title">Categories</h2>
                    <div class="filter-widget-content">
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="categories[]" value="damage-weiver">
                                <span class="checkbox-custom">
                                    <svg viewBox="0 0 64 64" height="100%" width="100%">
                                        <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16" class="path"></path>
                                    </svg>
                                </span>
                                <span class="label-text">Damage weiver</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="categories[]" value="engine-oil">
                                <span class="checkbox-custom">
                                    <svg viewBox="0 0 64 64" height="100%" width="100%">
                                        <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16" class="path"></path>
                                    </svg>
                                </span>
                                <span class="label-text">Engine oil 2 Litre</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="categories[]" value="spare-tyre">
                                <span class="checkbox-custom">
                                    <svg viewBox="0 0 64 64" height="100%" width="100%">
                                        <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16" class="path"></path>
                                    </svg>
                                </span>
                                <span class="label-text">Spare Tyre</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="categories[]" value="tool-box">
                                <span class="checkbox-custom">
                                    <svg viewBox="0 0 64 64" height="100%" width="100%">
                                        <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16" class="path"></path>
                                    </svg>
                                </span>
                                <span class="label-text">Tool Box</span>
                            </label>
                        </div>
                    </div>
                </div>
    
                <!-- Resources -->
                <div class="filter-widget">
                    <h2 class="filter-widget-title">Resources</h2>
                    <div class="filter-widget-content">
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="resources[]" value="baby-seat">
                                <span class="checkbox-custom">
                                    <svg viewBox="0 0 64 64" height="100%" width="100%">
                                        <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16" class="path"></path>
                                    </svg>
                                </span>
                                <span class="label-text">Baby Seat</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="resources[]" value="gps">
                                <span class="checkbox-custom">
                                    <svg viewBox="0 0 64 64" height="100%" width="100%">
                                        <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16" class="path"></path>
                                    </svg>
                                </span>
                                <span class="label-text">GPS</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="resources[]" value="plein-carburant">
                                <span class="checkbox-custom">
                                    <svg viewBox="0 0 64 64" height="100%" width="100%">
                                        <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16" class="path"></path>
                                    </svg>
                                </span>
                                <span class="label-text">Plein Carburant</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="resources[]" value="siege-auto-bebe">
                                <span class="checkbox-custom">
                                    <svg viewBox="0 0 64 64" height="100%" width="100%">
                                        <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16" class="path"></path>
                                    </svg>
                                </span>
                                <span class="label-text">Siège Auto Bébé</span>
                            </label>
                        </div>
                    </div>
                </div>
    
                <!-- Features -->
                <div class="filter-widget">
                    <h2 class="filter-widget-title">Features</h2>
                    <div class="filter-widget-content">
                        <div class="search-box">
                            <input type="search" class="sidebar-search-input" placeholder="Enter to Search">
                            <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </div>
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="features[]" value="gps">
                                <span class="checkbox-custom">
                                    <svg viewBox="0 0 64 64" height="100%" width="100%">
                                        <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16" class="path"></path>
                                    </svg>
                                </span>
                                <span class="label-text">GPS</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="features[]" value="kilometrage">
                                <span class="checkbox-custom">
                                    <svg viewBox="0 0 64 64" height="100%" width="100%">
                                        <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16" class="path"></path>
                                    </svg>
                                </span>
                                <span class="label-text">Kilométrage illimité</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="features[]" value="navette">
                                <span class="checkbox-custom">
                                    <svg viewBox="0 0 64 64" height="100%" width="100%">
                                        <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16" class="path"></path>
                                    </svg>
                                </span>
                                <span class="label-text">Navette gratuite</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="features[]" value="politique-carburant">
                                <span class="checkbox-custom">
                                    <svg viewBox="0 0 64 64" height="100%" width="100%">
                                        <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16" class="path"></path>
                                    </svg>
                                </span>
                                <span class="label-text">Politique carburant: Plein/Plein</span>
                            </label>
                        </div>
                    </div>
                </div>
    
                <!-- Attributes -->
                <div class="filter-widget">
                    <h2 class="filter-widget-title">Attributes</h2>
                    <div class="filter-widget-content">
                        <div class="search-box">
                            <input type="search" class="sidebar-search-input" placeholder="Enter to Search">
                            <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </div>
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="attributes[]" value="clutch">
                                <span class="checkbox-custom">
                                    <svg viewBox="0 0 64 64" height="100%" width="100%">
                                        <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16" class="path"></path>
                                    </svg>
                                </span>
                                <span class="label-text">Clutch</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="attributes[]" value="doors">
                                <span class="checkbox-custom">
                                    <svg viewBox="0 0 64 64" height="100%" width="100%">
                                        <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16" class="path"></path>
                                    </svg>
                                </span>
                                <span class="label-text">Doors</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="attributes[]" value="fuel">
                                <span class="checkbox-custom">
                                    <svg viewBox="0 0 64 64" height="100%" width="100%">
                                        <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16" class="path"></path>
                                    </svg>
                                </span>
                                <span class="label-text">Fuel</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="attributes[]" value="transmission">
                                <span class="checkbox-custom">
                                    <svg viewBox="0 0 64 64" height="100%" width="100%">
                                        <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16" class="path"></path>
                                    </svg>
                                </span>
                                <span class="label-text">Transmission</span>
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        {{-- Main Content --}}
        <main class="main-content">
            <div class="results-count">
                <span>{{ $cars->count() }} items found</span>
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
                                    <img src="{{ asset('storage/' . $primaryImage->image_path) }}" alt="{{ $car->brand->brand }} {{ $car->model }}">
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
                                        <!-- <span>{{ $car->rating ?? '4.8' }} ({{ $car->reviews_count ?? '120' }} reviews)</span> -->
                                        <span>({{ $car->rating ?? '4.8' }}reviews)</span>
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
        </main>
    </div>


          <!-- Add pagination links here -->
          <div class="pagination-container">
            {{ $cars->links('vendor.pagination.custom-car-home') }}
        </div>


        
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</x-app-layout>
