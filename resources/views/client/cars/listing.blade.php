<x-app-layout>
    <div class="page-container">
        <aside class="sidebar">
            <h2>Filters</h2>
            <form class="filter-form">
                <div class="filter-group">
                    <label for="is-available">Availability</label>
                    <select id="is-available" name="is-available">
                        <option value="">-- Select --</option>
                        <option value="yes">Available</option>
                        <option value="no">Unavailable</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="modelsname">Model Name</label>
                    <input type="text" id="modelsname" name="modelsname" placeholder="Enter model name">
                </div>
                <div class="filter-group">
                    <label for="type-car">Car Type</label>
                    <select id="type-car" name="type-car">
                        <option value="">-- Select --</option>
                        <option value="suv">SUV</option>
                        <option value="sedan">Sedan</option>
                        <option value="hatchback">Hatchback</option>
                        <option value="luxury">Luxury</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="fueltype">Fuel Type</label>
                    <select id="fueltype" name="fueltype">
                        <option value="">-- Select --</option>
                        <option value="petrol">Petrol</option>
                        <option value="diesel">Diesel</option>
                        <option value="electric">Electric</option>
                        <option value="hybrid">Hybrid</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="startdate">Start Date</label>
                    <input type="date" id="startdate" name="startdate">
                </div>
                <div class="filter-group">
                    <label for="enddate">End Date</label>
                    <input type="date" id="enddate" name="enddate">
                </div>
                <div class="filter-group">
                    <label for="brand">Brand</label>
                    <input type="text" id="brand" name="brand" placeholder="Enter brand name">
                </div>
                <div class="filter-group">
                    <label for="seats">Number of Seats</label>
                    <input type="number" id="seats" name="seats" min="1" placeholder="Enter number of seats">
                </div>
                <div class="filter-group">
                    <label for="agency">Agency</label>
                    <input type="text" id="agency" name="agency" placeholder="Enter agency name">
                </div>
            </form>
        </aside>
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


        <script src="car-listing.js"></script>
</x-app-layout>
