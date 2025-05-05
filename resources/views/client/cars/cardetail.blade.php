<x-app-layout>
    @push('header')
        <link rel="stylesheet" href="{{ asset('css/cardetails.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <style>
            /* Additional styles to match screenshot */
            .specifications-table {
                margin-top: 20px;
            }

            .spec-row {
                display: flex;
                justify-content: space-around;
                align-items: center;
                padding: 12px 0;
                border-bottom: 1px solid #eee;
            }

            .spec-name {
                display: flex;
                align-items: center;
            }

            .spec-icon {
                margin-right: 10px;
                color: #555;
                width: 18px;
            }

            .spec-quantity {
                display: flex;
                align-items: center;
            }

            .quantity-btn {
                width: 30px;
                height: 30px;
                border-radius: 4px;
                background: #f5f5f5;
                border: 1px solid #ddd;
                cursor: pointer;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .quantity-value {
                margin: 0 10px;
                width: 30px;
                text-align: center;
            }

            .reset-btn {
                width: 30px;
                height: 30px;
                border-radius: 4px;
                background: #f5f5f5;
                border: 1px solid #ddd;
                cursor: pointer;
                margin-left: 5px;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .price-details {
                margin-top: 20px;
            }

            .price-row {
                display: flex;
                justify-content: space-between;
                padding: 8px 0;
                border-bottom: 1px solid #eee;
            }

            .price-row.total {
                font-weight: bold;
                border-top: 2px solid #eee;
                margin-top: 10px;
                padding-top: 15px;
            }

            .btn-book {
                width: 100%;
                padding: 15px;
                /* background: #3c82f6; */
                color: white;
                border: none;
                border-radius: 4px;
                font-weight: bold;
                cursor: pointer;
                margin-top: 20px;
            }

            /* Flatpickr custom styling */
            .flatpickr-calendar {
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
            }

            .flatpickr-day.selected {
                background: #3c82f6;
                border-color: #3c82f6;
            }

            .spec-circle {
                display: inline-block;
                width: 12px;
                height: 12px;
                background-color: #3c82f6;
                border-radius: 50%;
                margin-right: 8px;
            }
        </style>
        <script>
            // Check if jQuery is already loaded
            if (typeof jQuery === 'undefined') {
                console.log('jQuery not found, loading from CDN');
                document.write('<script src="https://code.jquery.com/jquery-3.6.0.min.js"><\/script>');
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
                    @if ($car->carImages->isNotEmpty())
                        <img src="{{ asset('storage/' . $car->carImages->first()->image_path) }}"
                            alt="{{ $car->brand->brand }} {{ $car->model }}" class="car-image" id="main-image">
                    @else
                        <img src="{{ asset('images/defaultcarimage.png') }}"
                            alt="{{ $car->brand->brand }} {{ $car->model }}" class="car-image" id="main-image">
                    @endif
                    <div class="logo-badge">AZIDCAR</div>
                </div>
                <div class="thumbnail-gallery">
                    @foreach ($car->carImages as $image)
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

                <!-- Livewire Car Rental Calculator Component -->
                @livewire('car-rental-calculator', ['car' => $car])

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
                                @foreach ($car->features as $feature)
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
            @foreach ($relatedCars as $relatedCar)
                <div class="product-card">
                    <div class="product-image">
                        @if ($relatedCar->carImages->isNotEmpty())
                            <img src="{{ asset('storage/' . $relatedCar->carImages->first()->image_path) }}"
                                alt="{{ $relatedCar->brand->brand }} {{ $relatedCar->model }}">
                        @else
                            <img src="{{ asset('images/defaultcarimage.png') }}"
                                alt="{{ $relatedCar->brand->brand }} {{ $relatedCar->model }}">
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Image carousel functionality
            initImageCarousel();

            // Accordion functionality
            initAccordion();
        });

        function initImageCarousel() {
            const mainImage = document.getElementById('main-image');
            const thumbnails = document.querySelectorAll('.thumbnail');
            let currentImageIndex = 0;

            if (mainImage && thumbnails.length > 0) {
                thumbnails.forEach((thumb, index) => {
                    thumb.addEventListener('click', () => {
                        mainImage.src = thumb.dataset.src;
                        thumbnails.forEach(t => t.classList.remove('active'));
                        thumb.classList.add('active');
                        currentImageIndex = index;
                    });
                });

                // Swipe functionality
                let touchStartX = 0;
                let touchEndX = 0;

                mainImage.addEventListener('touchstart', e => {
                    touchStartX = e.changedTouches[0].screenX;
                });

                mainImage.addEventListener('touchend', e => {
                    touchEndX = e.changedTouches[0].screenX;
                    handleSwipe();
                });

                function handleSwipe() {
                    const swipeThreshold = 50;
                    const diff = touchEndX - touchStartX;

                    if (Math.abs(diff) < swipeThreshold) return;

                    if (diff > 0 && currentImageIndex > 0) {
                        // Swipe right
                        currentImageIndex--;
                    } else if (diff < 0 && currentImageIndex < thumbnails.length - 1) {
                        // Swipe left
                        currentImageIndex++;
                    }

                    thumbnails[currentImageIndex].click();
                }
            }
        }

        function initAccordion() {
            const accordionHeaders = document.querySelectorAll('.accordion-header');

            accordionHeaders.forEach(header => {
                header.addEventListener('click', () => {
                    const item = header.parentElement;
                    item.classList.toggle('collapsed');
                });
            });
        }
    </script>
@endpush
