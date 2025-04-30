<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> <!-- Flatpickr CSS -->

    <div class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">Find Your Perfect Car</h1>
            <p class="hero-subtitle">Your go-to solution for vehicle rentals of all categories. Whether you need a compact car for city trips, a spacious SUV for family adventures, or a luxury car for a special occasion, we have what you need.</p>

            <!-- Search Form with Input Fields -->
            <div class="search-container">
                <form class="search-form" action="{{ route('cars.listing') }}" method="GET">
                    <!-- FROM LOCATION -->
                    <div class="form-group">
                        <label for="from">WHERE YOU FROM</label>
                        <select name="from" id="from" class="address-input" required>
                            @foreach($locations as $location)
                                <option value="{{ $location->name }}">{{ $location->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- DATE RANGE -->
                    <div class="form-group">
                        <label>CHOOSE DATES</label>
                        <div class="date-range-container">
                            <input type="text" id="start-date" name="start_date" class="date-input" placeholder="From" readonly>
                            <input type="text" id="end-date" name="end_date" class="date-input" placeholder="To" readonly>
                        </div>
                    </div>

                    <button type="submit" class="search-button">Search</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Car Listing Section -->
    <section class="car-listing-section">
        <div class="container">
            <h2 class="listing-title">Location de voitures au Maroc</h2>
            <div class="car-grid">
                @if ($cars->isEmpty())
                    <p>No cars available at the moment.</p>
                @else
                    @foreach ($cars as $car)
                        <div class="car-card-home">
                            @php
                                $primaryImage = $car->carImages->firstWhere('is_primary', true);
                            @endphp

                            <div class="car-image-home">
                                @if ($primaryImage)
                                    <img src="{{ asset('storage/' . $primaryImage->image_path) }}" alt="{{ $car->model }}">
                                @else
                                    <img src="{{ asset('storage/defaultcarimage.png') }}" alt="Default Car Image">
                                @endif
                            </div>

                            <div class="car-details">
                                <div class="car-header">
                                    <h2 class="car-model">{{ $car->brand->brand }} {{ $car->model }}</h2>
                                    <span class="car-brand">{{ $car->brand->brand }}</span>
                                </div>

                                <div class="car-specs">
                                    <div class="spec-item">
                                        <i class="fas fa-users"></i>
                                        <span>{{ $car->seats }} seats</span>
                                    </div>
                                    <div class="spec-item">
                                        <i class="fas fa-gas-pump"></i>
                                        <span>{{ $car->fuelType->fuel_type }}</span>
                                    </div>
                                    <div class="spec-item">
                                        <i class="fas fa-cog"></i>
                                        <span>{{ $car->transmission }}</span>
                                    </div>
                                    <div class="spec-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>{{ $car->city }}</span>
                                    </div>
                                </div>

                                <div class="car-features">
                                    <div class="feature insurance-feature">
                                        <i class="fas fa-shield-alt"></i>
                                        <span>Full Insurance</span>
                                    </div>
                                    <div class="car-description">
                                        <div class="description-header">
                                            <i class="fas fa-info-circle"></i>
                                            <span>Description</span>
                                        </div>
                                        <p>{{ $car->insurance->description ?? 'No insurance info' }}</p>
                                    </div>
                                </div>

                                <div class="car-footer">
                                    <div class="price-section">
                                        <span class="price">€{{ $car->price_per_day }}</span>
                                        <span class="price-period">/Day</span>
                                    </div>
                                    <button class="book-now">BOOK NOW</button>
                                </div>

                                <div class="car-status">
                                    <span class="availability">{{ $car->is_available ? 'Available' : 'Not Available' }}</span>
                                    <div class="reviews">
                                        <i class="fas fa-star"></i>
                                        <span>4.8 (120 reviews)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="pagination-container">
                {{ $cars->links('vendor.pagination.custom-car-home') }}
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const startDatePicker = flatpickr("#start-date", {
                dateFormat: "Y-m-d",
                minDate: "today",
                onChange: function (selectedDates) {
                    if (selectedDates[0]) {
                        endDatePicker.set('minDate', selectedDates[0]);
                    }
                }
            });

            const endDatePicker = flatpickr("#end-date", {
                dateFormat: "Y-m-d",
                minDate: "today",
            });

            const today = new Date();
            const tomorrow = new Date();
            tomorrow.setDate(today.getDate() + 1);

            startDatePicker.setDate(today);
            endDatePicker.setDate(tomorrow);
        });
    </script>
</x-app-layout>
