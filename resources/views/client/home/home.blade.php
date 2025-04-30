<x-app-layout>
    <!-- External Styles -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">Find Your Perfect Car</h1>
            <p class="hero-subtitle">
                Your go-to solution for vehicle rentals of all categories. Whether you need a compact car for city trips, a spacious SUV for family adventures, or a luxury car for a special occasion, we have what you need.
            </p>

            <!-- Search Form -->
            <div class="search-container">
                <form class="search-form" action="{{ route('cars.listing') }}" method="GET">
                    <div class="form-group">
                        <label for="from">WHERE YOU FROM</label>
                        <select name="from" id="from" class="address-input" required>
                            @foreach($locations as $location)
                                <option value="{{ $location->name }}">
                                    {{ $location->name }} - {{ ucfirst(str_replace('_', ' ', $location->type)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
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

    <!-- Car Listings -->
    <section class="car-listing-section">
        <div class="container">
            <h2 class="listing-title">Location de voitures au Maroc</h2>
            <div class="car-grid">
                @if ($cars->isEmpty())
                    <p>No cars available at the moment.</p>
                @else
                    @foreach ($cars as $car)
                        <div class="car-card-home">
                            @php $primaryImage = $car->carImages->firstWhere('is_primary', true); @endphp

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
                                    <div class="spec-item"><i class="fas fa-users"></i><span>{{ $car->seats }} seats</span></div>
                                    <div class="spec-item"><i class="fas fa-gas-pump"></i><span>{{ $car->fuelType->fuel_type }}</span></div>
                                    <div class="spec-item"><i class="fas fa-cog"></i><span>{{ $car->transmission }}</span></div>
                                    <div class="spec-item"><i class="fas fa-map-marker-alt"></i><span>{{ $car->city }}</span></div>
                                </div>

                                <div class="car-features">
                                    <div class="feature insurance-feature"><i class="fas fa-shield-alt"></i><span>Full Insurance</span></div>
                                    <div class="car-description">
                                        <div class="description-header"><i class="fas fa-info-circle"></i><span>Description</span></div>
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
                                    <div class="reviews"><i class="fas fa-star"></i><span>4.8 (120 reviews)</span></div>
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

   <!-- DateRangePicker Script -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    $(function() {
        // Get today and tomorrow dates
        const today = moment();
        const tomorrow = moment().add(1, 'days');

        // Initialize DateRangePicker
        $('#date-range').daterangepicker({
            startDate: today,
            endDate: tomorrow,
            minDate: today,
            opens: 'left',
            showDropdowns: false,
            showWeekNumbers: false,
            autoApply: false,
            locale: {
                format: 'YYYY-MM-DD',
                separator: ' to ',
                applyLabel: 'Apply',
                cancelLabel: 'Cancel',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                weekLabel: 'W',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            },
            ranges: {
                'Today': [moment(), moment()],
                'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
                'Next 7 Days': [moment(), moment().add(6, 'days')],
                'Next 30 Days': [moment(), moment().add(29, 'days')],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Next Month': [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')]
            }
        });

        // Add custom footer text if needed
        $('.daterangepicker').append('<div class="range-calendar-info">Double-click on a date to select it as a single-day range.</div>');

        // Update the input with the initial date range
        $('#date-range').val(today.format('YYYY-MM-DD') + ' to ' + tomorrow.format('YYYY-MM-DD'));
    });
</script>
</x-app-layout>
