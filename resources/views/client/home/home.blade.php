<x-app-layout>
    <div class="hero-section">
        <!-- Hero Content - Text to the left of car -->
        <div class="hero-content">
            <h1 class="hero-title">Find Your Perfect Car</h1>
            <p class="hero-subtitle">Your go-to solution for vehicle rentals of all categories. Whether you need a
                compact car for city trips, a spacious SUV for family adventures, or a luxury car for a special
                occasion, we have what you need.</p>

            <!-- Search Form with Input Fields -->
            <div class="search-container">
                <form class="search-form" action="" method="GET">
                    <div class="form-group">
                        <label for="from">WHERE YOU FROM</label>
                        <div class="address-input-wrapper">
                            <input type="text" id="from" name="from" class="address-input"
                                placeholder="Enter your address">
                            <div class="address-suggestions" id="from-suggestions">
                                <!-- Will be populated dynamically -->
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="to">WHERE YOU GO</label>
                        <div class="address-input-wrapper">
                            <input type="text" id="to" name="to" class="address-input"
                                placeholder="Enter destination">
                            <div class="address-suggestions" id="to-suggestions">
                                <!-- Will be populated dynamically -->
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>CHOOSE DATES</label>
                        <div class="date-range-container">
                            <div class="date-input-wrapper">
                                <input type="text" id="start-date" name="start_date" class="date-input"
                                    placeholder="From" readonly>
                            </div>
                            <div class="date-separator">-</div>
                            <div class="date-input-wrapper">
                                <input type="text" id="end-date" name="end_date" class="date-input" placeholder="To"
                                    readonly>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="search-button">Search</button>
                </form>
            </div>

            {{-- <a href="#" class="hero-button mt-8">about us</a> --}}
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
                        <div class="car-card">
                            @php
                                $primaryImage = $car->carImages->firstWhere('is_primary', true);
                            @endphp

                            @if ($primaryImage)
                                <img src="{{ asset('storage/car_images/' . $primaryImage->image_path) }}"
                                    alt="{{ $car->model }}" class="car-image">
                            @else
                                <img src="{{ asset('storage/default-car-image.jpg') }}" alt="Default Image"
                                    class="car-image">
                            @endif


                            <h3 class="car-model">{{ $car->brand->brand }} -- {{ $car->model }}</h3>
                            <ul class="features-list">
                                <li>{{ $car->seats }} Seats</li>
                            </ul>
                        </div>
                    @endforeach

                @endif
            </div>
        </div>
    </section>

    <script>
        // Function to fetch agency cities from the server using Laravel route
        async function fetchAgencyCities() {
            try {
                const response = await fetch('{{ route('agencies.cities') }}');
                if (!response.ok) {
                    throw new Error('Failed to fetch cities');
                }
                const cities = await response.json();
                return cities;
            } catch (error) {
                console.error('Error fetching agency cities:', error);
                return [];
            }
        }

        // Function to populate suggestion lists
        function populateSuggestions(cities) {
            const fromSuggestions = document.getElementById('from-suggestions');
            const toSuggestions = document.getElementById('to-suggestions');

            // Clear existing suggestions
            fromSuggestions.innerHTML = '';
            toSuggestions.innerHTML = '';

            // Add city suggestions to both lists
            cities.forEach(city => {
                // Create suggestion for "from" field
                const fromItem = document.createElement('div');
                fromItem.className = 'suggestion-item';
                fromItem.textContent = city;
                fromItem.onclick = function() {
                    selectAddress('from', city);
                };
                fromSuggestions.appendChild(fromItem);

                // Create suggestion for "to" field
                const toItem = document.createElement('div');
                toItem.className = 'suggestion-item';
                toItem.textContent = city;
                toItem.onclick = function() {
                    selectAddress('to', city);
                };
                toSuggestions.appendChild(toItem);
            });
        }

        // Function to handle address selection
        function selectAddress(field, address) {
            document.getElementById(field).value = address;
            // Hide suggestions after selection
            document.getElementById(field + '-suggestions').style.display = 'none';
        }

        // Function to show suggestions container
        function showSuggestions(fieldId) {
            document.getElementById(fieldId + '-suggestions').style.display = 'block';
        }

        // Function to filter suggestions based on input
        function filterSuggestions(field, inputValue) {
            const suggestionsContainer = document.getElementById(`${field}-suggestions`);
            suggestionsContainer.style.display = 'block';
            const items = suggestionsContainer.getElementsByClassName('suggestion-item');

            inputValue = inputValue.toLowerCase();

            for (let i = 0; i < items.length; i++) {
                const itemText = items[i].textContent.toLowerCase();
                if (itemText.includes(inputValue)) {
                    items[i].style.display = "block";
                } else {
                    items[i].style.display = "none";
                }
            }
        }

        // Initialize the page
        document.addEventListener('DOMContentLoaded', async function() {
            // Fetch and populate city suggestions
            const cities = await fetchAgencyCities();
            populateSuggestions(cities);

            // Add input event listeners for filtering
            const fromInput = document.getElementById('from');
            fromInput.addEventListener('input', function() {
                filterSuggestions('from', this.value);
            });
            fromInput.addEventListener('focus', function() {
                showSuggestions('from');
            });

            const toInput = document.getElementById('to');
            toInput.addEventListener('input', function() {
                filterSuggestions('to', this.value);
            });
            toInput.addEventListener('focus', function() {
                showSuggestions('to');
            });

            // Hide suggestions when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.address-input-wrapper')) {
                    document.getElementById('from-suggestions').style.display = 'none';
                    document.getElementById('to-suggestions').style.display = 'none';
                }
            });

            // Initialize date pickers
            if (typeof flatpickr === 'function') {
                // Start date picker
                const startDatePicker = flatpickr("#start-date", {
                    dateFormat: "m/d/Y",
                    minDate: "today",
                    onChange: function(selectedDates, dateStr) {
                        // Update end date minimum when start date changes
                        if (selectedDates[0]) {
                            endDatePicker.set('minDate', selectedDates[0]);
                        }
                    }
                });

                // End date picker
                const endDatePicker = flatpickr("#end-date", {
                    dateFormat: "m/d/Y",
                    minDate: "today"
                });

                // Set initial values to today and tomorrow
                const today = new Date();
                const tomorrow = new Date();
                tomorrow.setDate(today.getDate() + 1);

                startDatePicker.setDate(today);
                endDatePicker.setDate(tomorrow);
            }
        });
    </script>
</x-app-layout>
