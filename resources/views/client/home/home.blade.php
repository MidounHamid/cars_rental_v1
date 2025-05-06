<x-app-layout>
    <!-- External Styles -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <div class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">Find Your Perfect Car</h1>
            <p class="hero-subtitle">
                Your go-to solution for vehicle rentals of all categories. Whether you need a compact car for city
                trips, a spacious SUV for family adventures, or a luxury car for a special occasion, we have what you
                need.
            </p>

            <!-- Search Form -->
            <div class="search-form-container">
                <form class="search-form" action="{{ route('cars.listing') }}" method="GET">
                    <div class="form-group">
                        <label>PICKUP LOCATION</label>
                        <div class="location-input-wrapper">
                            <input type="text" class="location-input" name="pickup_location_display"
                                id="from-location" placeholder="Choose Location" autocomplete="off">

                            <!-- Hidden input to store selected location ID -->
                            <input type="hidden" name="pickup_location" id="from-location-id">

                            <div class="location-dropdown">
                                @foreach ($locations as $location)
                                    <div class="location-option" data-value="{{ $location->id }}"
                                        data-name="{{ $location->name }} - {{ ucfirst(str_replace('_', ' ', $location->type)) }}">
                                        {{ $location->name }} - {{ ucfirst(str_replace('_', ' ', $location->type)) }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>CHOOSE DATES</label>
                        <div class="dates-input-wrapper">
                            <input type="text" class="dates-input" name="dates" placeholder="Select dates"
                                readonly>
                            <input type="hidden" name="start_date" id="start_date">
                            <input type="hidden" name="end_date" id="end_date">
                        </div>
                    </div>
                    <button type="submit" class="search-btn">Search</button>
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
                                    <img src="{{ asset('storage/' . $primaryImage->image_path) }}"
                                        alt="{{ $car->model }}">
                                @else
                                    <img src="{{ asset('images/defaultcarimage.png') }}" alt="Default Car Image">
                                @endif
                            </div>

                            <div class="car-details">
                                <div class="car-header">
                                    <h2 class="car-model">{{ $car->brand->brand }} {{ $car->model }}</h2>
                                    <span class="car-brand">{{ $car->brand->brand }}</span>
                                </div>

                                <div class="car-specs">
                                    <div class="spec-item"><i class="fas fa-users"></i><span>{{ $car->seats }}
                                            seats</span></div>
                                    <div class="spec-item"><i
                                            class="fas fa-gas-pump"></i><span>{{ $car->fuelType->fuel_type }}</span>
                                    </div>
                                    <div class="spec-item"><i
                                            class="fas fa-cog"></i><span>{{ $car->transmission }}</span></div>
                                    <div class="spec-item"><i
                                            class="fas fa-map-marker-alt"></i><span>{{ $car->city }}</span>
                                    </div>
                                </div>

                                <div class="car-features">
                                    <div class="feature insurance-feature"><i class="fas fa-shield-alt"></i>
                                        <span>{{ $car->insurance->name }}
                                        </span>
                                    </div>
                                    <div class="car-description">
                                        <div class="description-header"><i
                                                class="fas fa-info-circle"></i><span>Description</span></div>
                                        <p>{{ $car->insurance->description ?? 'No insurance info' }}</p>
                                    </div>
                                </div>

                                <div class="car-footer">
                                    <div class="price-section">
                                        <span class="price">{{ $car->price_per_day }}</span>
                                        <span class="price-period">/Day</span>
                                    </div>
                                    <button class="book-now"> <a href="{{ route('cars.detail', $car->id) }}"
                                            class="book-now">Book Now</a>
                                    </button>
                                </div>

                                <div class="car-status">
                                    <span class="status-badge {{ $car->is_available ? 'available' : 'unavailable' }}">
                                        <i
                                            class="fas fa-{{ $car->is_available ? 'check-circle' : 'times-circle' }}"></i>
                                        {{ $car->is_available ? 'Available' : 'Unavailable' }}
                                    </span>
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

    <!-- Scripts -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <style>
        .search-form-container {
            background: white;
            padding: 24px 32px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 90%;
        }

        .search-form {
            display: flex;
            gap: 24px;
            align-items: flex-end;
        }

        .form-group {
            flex: 1;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: #4a5568;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .location-input-wrapper {
            position: relative;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            min-width: 280px;
        }

        .location-input {
            width: 100%;
            padding: 12px;
            border: none;
            background: transparent;
            font-size: 14px;
            color: #2d3748;
            outline: none;
        }

        .location-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            margin-top: 4px;
            max-height: 200px;
            overflow-y: auto;
            display: none;
            z-index: 10;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .location-option {
            padding: 12px;
            cursor: pointer;
            color: #4a5568;
            font-size: 14px;
        }

        .location-option:hover {
            background-color: #f7fafc;
        }

        .dates-input-wrapper {
            position: relative;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            min-width: 280px;
        }

        .dates-input {
            width: 100%;
            padding: 12px;
            border: none;
            background: transparent;
            font-size: 14px;
            color: #2d3748;
            outline: none;
        }

        .search-btn {
            background-color: #2d3748;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
            height: 44px;
        }

        .search-btn:hover {
            background-color: #1a202c;
        }

        /* DateRangePicker customization */
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
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Location input handling
            const locationInput = document.querySelector('.location-input');
            const locationDropdown = document.querySelector('.location-dropdown');
            const locationOptions = document.querySelectorAll('.location-option');

            locationInput.addEventListener('focus', () => {
                locationDropdown.style.display = 'block';
            });

            locationInput.addEventListener('blur', () => {
                setTimeout(() => {
                    locationDropdown.style.display = 'none';
                }, 200);
            });

            locationInput.addEventListener('input', (e) => {
                const searchTerm = e.target.value.toLowerCase();
                locationOptions.forEach(option => {
                    const text = option.textContent.toLowerCase();
                    option.style.display = text.includes(searchTerm) ? 'block' : 'none';
                });
            });

            locationOptions.forEach(option => {
                option.addEventListener('click', () => {
                    const locationId = option.getAttribute('data-value');
                    const locationName = option.getAttribute('data-name');
                    locationInput.value = locationName;
                    locationInput.setAttribute('data-location-id', locationId);
                    locationDropdown.style.display = 'none';
                });
            });

            // Initialize DateRangePicker
            $('.dates-input').daterangepicker({
                autoUpdateInput: false,
                opens: 'center',
                showDropdowns: true,
                minDate: moment(),
                startDate: moment(),
                endDate: moment().add(1, 'days'),
                locale: {
                    format: 'YYYY-MM-DD',
                    separator: ' to ',
                    applyLabel: 'Apply',
                    cancelLabel: 'Cancel',
                    daysOfWeek: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                    monthNames: [
                        'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                        'September', 'October', 'November', 'December'
                    ],
                    firstDay: 1
                },
                linkedCalendars: true,
                showCustomRangeLabel: false,
                alwaysShowCalendars: true,
                autoApply: false
            });

            // When user applies the date range
            $('.dates-input').on('apply.daterangepicker', function(ev, picker) {
                // Update the display
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format(
                    'YYYY-MM-DD'));

                // Set hidden inputs with the correct format
                $('#start_date').val(picker.startDate.format('YYYY-MM-DD'));
                $('#end_date').val(picker.endDate.format('YYYY-MM-DD'));
            });

            // Optional: clear date input on cancel
            $('.dates-input').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                $('#start_date').val('');
                $('#end_date').val('');
            });

            // Handle form submission
            document.querySelector('.search-form').addEventListener('submit', function(e) {
                e.preventDefault();

                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                const locationId = locationInput.getAttribute('data-location-id');

                // Create the URL with query parameters
                const baseUrl = this.getAttribute('action');
                const params = new URLSearchParams();

                if (locationId) params.append('pickup_location', locationId);
                if (startDate) params.append('start_date', startDate);
                if (endDate) params.append('end_date', endDate);

                // Redirect to the listing page with the parameters
                window.location.href = `${baseUrl}?${params.toString()}`;
            });






            document.querySelectorAll('.location-option').forEach(option => {
                option.addEventListener('click', function() {
                    const name = this.dataset.name;
                    const id = this.dataset.value;

                    document.getElementById('from-location').value = name; // show name
                    document.getElementById('from-location-id').value = id; // send ID to backend
                });
            });

        });
    </script>
</x-app-layout>
