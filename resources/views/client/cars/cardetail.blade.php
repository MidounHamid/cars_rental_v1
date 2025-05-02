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
                <p class="car-price">${{ number_format($car->price_per_day, 2) }}/Day</p>

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

                <!-- Book Now Button -->
                <button class="btn-book">Book Now</button>

                <!-- Category Info -->
                <div class="category-line">
                    Category: <a href="#" class="category-link">{{ $car->carType->name }}</a>
                </div>

                <!-- Pricing Info Box -->
                <div class="pricing-box">
                    <h3 class="pricing-title">Pricing Info</h3>
                    <p class="pricing-text">Pricing for {{ $car->brand->brand }} {{ $car->model }}</p>
                    <p>Day based pricing :
                    </p>
                    <span>{{$car->price_per_day}}/ days</span>
                </div>

                <!-- Accordion Sections -->
                <div class="accordion">
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <span class="accordion-title">Description</span>
                            <span class="accordion-icon">▼</span>
                        </div>
                        <div class="accordion-content">
                            <p>{{ $car->description ?? 'No description available.' }}</p>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <div class="accordion-header">
                            <span class="accordion-title">Features</span>
                            <span class="accordion-icon">▼</span>
                        </div>
                        <div class="accordion-content">
                            <ul style="list-style-type: none; padding-left: 10px;">
                                @foreach($car->specifications as $spec)
                                    <li>• {{ $spec->specification }}</li>
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
                            <img src="{{ asset('images/cars/default.jpg') }}" alt="{{ $relatedCar->brand->brand }} {{ $relatedCar->model }}">
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
