<x-app-layout>
    @push('header')
        <link rel="stylesheet" href="{{ asset('css/cardetails.css') }}">
    @endpush

    <header class="header">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}">Home</a> /
                <a href="#">{{ $car->carType->name }}</a> /
                {{ $car->brand->brand }} {{ $car->model }}
            </div>
        </div>
    </header>

    <main class="container">
        <div class="content-wrapper">
            <!-- Car Image Section with Gallery -->
            <div class="car-image-section">
                <div class="car-image-box">
                    @if($car->carImages->isNotEmpty())
                        <img src="{{ asset('storage/' . $car->carImages->first()->image_path) }}" alt="{{ $car->brand->brand }} {{ $car->model }}" class="car-image" id="main-image">
                    @else
                        <img src="{{ asset('images/defaultcarimage.png') }}" alt="{{ $car->brand->brand }} {{ $car->model }}" class="car-image" id="main-image">
                    @endif
                    <div class="logo-badge">AZIDCAR</div>
                </div>
                <div class="thumbnail-gallery">
                    @foreach($car->carImages as $image)
                        <img src="{{ asset('storage/' . $image->image_path) }}"
                             alt="{{ $car->brand->brand }} {{ $car->model }}"
                             class="thumbnail {{ $loop->first ? 'active' : '' }}"
                             data-src="{{ asset('storage/' . $image->image_path) }}">
                    @endforeach
                </div>
            </div>

            <!-- Car Details Section -->
            <div class="car-details">
                <h1 class="car-title">{{ $car->brand->brand }} {{ $car->model }}</h1>
                <p class="car-price">{{ number_format($car->price_per_day, 2) }}/Day</p>

                <!-- Pickup Form Section -->
                <div class="form-section">
                    <label class="form-label">Pickup Date & Time</label>
                    <div class="form-control-wrapper">
                        <svg class="form-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <input type="text" class="form-control pickup-date" placeholder="Pickup Date">
                    </div>
                    <div class="form-control-wrapper">
                        <svg class="form-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <input type="text" class="form-control pickup-time" placeholder="Pickup Time">
                    </div>
                </div>

                <!-- Return Form Section -->
                <div class="form-section">
                    <label class="form-label">Return Date & Time</label>
                    <div class="form-control-wrapper">
                        <svg class="form-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <input type="text" class="form-control return-date" placeholder="Return Date">
                    </div>
                    <div class="form-control-wrapper">
                        <svg class="form-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <input type="text" class="form-control return-time" placeholder="Return Time">
                    </div>
                </div>

                <!-- Specifications Table -->
                <div class="specifications-section">
                    <h3 class="section-title">
                        <svg class="section-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Specifications Table
                    </h3>
                    <div class="specifications-table">
                        <div class="spec-row">
                            <div class="spec-name">
                                <svg class="spec-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/><path d="M12 2v10l4.5 4.5"/>
                                </svg>
                                GPS Navigation
                            </div>
                            <div class="spec-quantity">
                                <button class="quantity-btn minus">-</button>
                                <span class="quantity-value" data-price="50">0</span>
                                <button class="quantity-btn plus">+</button>
                                <button class="reset-btn">
                                    <svg class="reset-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="spec-row">
                            <div class="spec-name">
                                <svg class="spec-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                                </svg>
                                Child Seat
                            </div>
                            <div class="spec-quantity">
                                <button class="quantity-btn minus">-</button>
                                <span class="quantity-value" data-price="30">0</span>
                                <button class="quantity-btn plus">+</button>
                                <button class="reset-btn">
                                    <svg class="reset-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="spec-row">
                            <div class="spec-name">
                                <svg class="spec-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12" y2="20"/>
                                </svg>
                                Wi-Fi Hotspot
                            </div>
                            <div class="spec-quantity">
                                <button class="quantity-btn minus">-</button>
                                <span class="quantity-value" data-price="25">0</span>
                                <button class="quantity-btn plus">+</button>
                                <button class="reset-btn">
                                    <svg class="reset-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="spec-row">
                            <div class="spec-name">
                                <svg class="spec-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                                Driver Service
                            </div>
                            <div class="spec-quantity">
                                <button class="quantity-btn minus">-</button>
                                <span class="quantity-value" data-price="200">0</span>
                                <button class="quantity-btn plus">+</button>
                                <button class="reset-btn">
                                    <svg class="reset-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing Info -->
                <div class="pricing-info">
                    <h3 class="section-title">
                        <svg class="section-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                        Pricing Info
                    </h3>
                    <div class="price-details">
                        <div class="price-row">
                            <span>Base Rate (per day)</span>
                            <span class="base-rate">{{ number_format($car->price_per_day, 2) }} MAD</span>
                        </div>
                        <div class="price-row">
                            <span>Rental Duration</span>
                            <span class="rental-duration">0 days</span>
                        </div>
                        <div class="price-row">
                            <span>Additional Options</span>
                            <span class="additional-options">0.00 MAD</span>
                        </div>
                        <div class="price-row total">
                            <span>Total Price</span>
                            <span class="total-price">0.00 MAD</span>
                        </div>
                    </div>
                </div>

                <!-- Book Now Button -->
                <button class="btn-book">Book Now</button>

                <!-- Category Info -->
                <div class="category-line">
                    Category: <a href="#" class="category-link">{{ $car->carType->name }}</a>
                </div>

                <!-- Accordion Sections -->
                <div class="accordion">
                    <div class="accordion-item collapsed">
                        <div class="accordion-header">
                            <span class="accordion-title">DESCRIPTION</span>
                            <span class="accordion-icon">▼</span>
                        </div>
                        <div class="accordion-content">
                            <p>{{ $car->description ?? 'No description available.' }}</p>
                        </div>
                    </div>

                    <div class="accordion-item collapsed">
                        <div class="accordion-header">
                            <span class="accordion-title">FEATURES</span>
                            <span class="accordion-icon">▼</span>
                        </div>
                        <div class="accordion-content">
                            <ul class="features-list">
                                @foreach($car->features as $feature)
                                    <li>• {{ $feature->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Explore Products Section -->
    <section class="container explore-section">
        <h2 class="explore-title">Explore Our Products</h2>
        <div class="products-grid">
            @foreach($relatedCars as $relatedCar)
                <div class="product-card">
                    <div class="product-image">
                        @if($relatedCar->carImages->isNotEmpty())
                            <img src="{{ asset('storage/' . $relatedCar->carImages->first()->image_path) }}" alt="{{ $relatedCar->brand->brand }} {{ $relatedCar->model }}">
                        @else
                            <img src="{{ asset('images/defaultcarimage.png') }}" alt="{{ $relatedCar->brand->brand }} {{ $relatedCar->model }}">
                        @endif
                    </div>
                    <div class="product-content">
                        <h3 class="product-name">{{ $relatedCar->brand->brand }} {{ $relatedCar->model }}</h3>
                        <div class="product-features">
                            <div class="feature">
                                <img src="{{ asset('images/icons/fuel.png') }}" alt="Fuel" class="feature-icon">
                                <span>{{ $relatedCar->fuelType->fuel_type }}</span>
                            </div>
                            <div class="feature">
                                <img src="{{ asset('images/icons/car.png') }}" alt="Type" class="feature-icon">
                                <span>{{ $relatedCar->carType->name }}</span>
                            </div>
                            <div class="feature">
                                <img src="{{ asset('images/icons/seat.png') }}" alt="Seats" class="feature-icon">
                                <span>{{ $relatedCar->seats }} Seats</span>
                            </div>
                        </div>
                        <div class="product-footer">
                            <div class="price">${{ number_format($relatedCar->price_per_day, 2) }}/Day</div>
                            <a href="{{ route('cars.detail', $relatedCar->id) }}" class="read-more">Read More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</x-app-layout>

@push('scripts')
    <script src="{{ asset('js/cardetails.js') }}"></script>
@endpush
