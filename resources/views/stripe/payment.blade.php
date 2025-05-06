<x-app-layout>

    <div class="container">
        <h1 class="page-title">Car Rental Payment</h1>

        <div class="main-content-wrapper">
            <!-- Car Details Section - Will stay fixed when scrolling -->
            <div class="car-details-container">
                <div class="car-details">
                    <div class="car-image">
                        @if (isset($bookingData['car']) && isset($bookingData['car']['image']))
                            <img src="{{ asset('storage/' . $bookingData['car']['image']) }}"
                                alt="{{ $bookingData['car']['brand'] ?? '' }} {{ $bookingData['car']['model'] ?? '' }}">
                        @else
                            <img src="{{ asset('images/car-placeholder.jpg') }}" alt="Car Image">
                        @endif
                    </div>
                    <div class="car-info">
                        <h2 class="car-model">
                            @if (isset($bookingData['car']))
                                {{ strtoupper($bookingData['car']['brand'] ?? '') }}
                                {{ strtoupper($bookingData['car']['model'] ?? '') }}
                            @else
                                CAR MODEL
                            @endif
                            <span class="available-badge">Available</span>
                        </h2>

                        <div class="section-divider"></div>

                        <div class="car-specs">
                            @if (isset($bookingData['car']))
                                <div class="spec-item">
                                    <div class="spec-icon"><i class="fas fa-car"></i></div>
                                    <div class="spec-text">{{ $bookingData['car']['type'] ?? 'N/A' }}</div>
                                </div>
                                <div class="spec-item">
                                    <div class="spec-icon"><i class="fas fa-user"></i></div>
                                    <div class="spec-text">{{ $bookingData['car']['seats'] ?? '5' }} Seats</div>
                                </div>
                                <div class="spec-item">
                                    <div class="spec-icon"><i class="fas fa-gas-pump"></i></div>
                                    <div class="spec-text">{{ $bookingData['car']['fuel'] ?? 'N/A' }}</div>
                                </div>
                                <div class="spec-item">
                                    <div class="spec-icon"><i class="fas fa-shield-alt"></i></div>
                                    <div class="spec-text">
                                        {{ $bookingData['car']['insurance'] ?? 'Standard Insurance' }}</div>
                                </div>
                                <div class="spec-item">
                                    <div class="spec-icon"><i class="fas fa-cog"></i></div>
                                    <div class="spec-text">{{ $bookingData['car']['gearbox'] ?? 'N/A' }}</div>
                                </div>
                            @else
                                <div class="spec-item">
                                    <div class="spec-text">Car specifications not available</div>
                                </div>
                            @endif
                        </div>

                        <div class="section-divider"></div>

                        <div class="rental-details">
                            <div class="rental-detail-item">
                                <div class="rental-detail-label"><i class="fas fa-calendar-alt"></i> Pickup Date</div>
                                <div class="rental-detail-value">
                                    @if (isset($bookingData['pickup_date']) && isset($bookingData['pickup_time']))
                                        {{ \Carbon\Carbon::parse($bookingData['pickup_date'] . ' ' . $bookingData['pickup_time'])->format('d M Y, h:i A') }}
                                    @else
                                        Not specified
                                    @endif
                                </div>
                            </div>
                            <div class="rental-detail-item">
                                <div class="rental-detail-label"><i class="fas fa-calendar-check"></i> Return Date</div>
                                <div class="rental-detail-value">
                                    @if (isset($bookingData['return_date']) && isset($bookingData['return_time']))
                                        {{ \Carbon\Carbon::parse($bookingData['return_date'] . ' ' . $bookingData['return_time'])->format('d M Y, h:i A') }}
                                    @else
                                        Not specified
                                    @endif
                                </div>
                            </div>
                            <div class="rental-detail-item">
                                <div class="rental-detail-label"><i class="fas fa-map-marker-alt"></i> Location</div>
                                <div class="rental-detail-value">{{ $bookingData['delivery_locations'][0] ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="rental-detail-item">
                                <div class="rental-detail-label"><i class="fas fa-clock"></i> Duration</div>
                                <div class="rental-detail-value">
                                    {{ $bookingData['duration_days'] ?? ($bookingData['rental_duration'] ?? '0') }}
                                    Days
                                </div>
                            </div>
                        </div>

                        <div class="section-divider"></div>

                        <div class="reviews">
                            <div class="stars">
                                @php
                                    $rating = $bookingData['rating'] ?? 4.8;
                                @endphp
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($rating >= $i)
                                        <i class="fas fa-star"></i>
                                    @elseif($rating > $i - 1)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <div class="reviews-count">({{ $bookingData['rating'] ?? '4.8' }})</div>
                        </div>

                        <div class="car-price">
                            ${{ number_format($bookingData['car']['price_per_day'] ?? ($bookingData['base_price'] ?? 0), 2) }}<span
                                class="per-day">/Day</span>
                        </div>

                        <div class="payment-summary">
                            @php
                                $pricePerDay =
                                    $bookingData['car']['price_per_day'] ?? ($bookingData['base_price'] ?? 0);
                                $durationDays = $bookingData['duration_days'] ?? ($bookingData['rental_duration'] ?? 0);
                                $rentalSubtotal = $pricePerDay * $durationDays;
                                $insuranceFee = $bookingData['insurance_fee'];
                                $serviceFee = $bookingData['service_fee'] ?? 15.0;
                                $additionalOptions = $bookingData['additional_options'] ?? 0;
                                $totalPrice =
                                    $bookingData['total_price'] ??
                                    $rentalSubtotal + $insuranceFee + $serviceFee + $additionalOptions;
                            @endphp
                            <div class="summary-row">
                                <div>Car Rental ({{ $durationDays }} days)</div>
                                <div>${{ number_format($rentalSubtotal, 2) }}</div>
                            </div>

                            @if ($additionalOptions > 0)
                                <div class="summary-row">
                                    <div>Additional Options</div>
                                    <div>${{ number_format($additionalOptions, 2) }}</div>
                                </div>
                            @endif

                            <div class="summary-row">
                                <div>Insurance Fee</div>
                                <div>{{ number_format($insuranceFee, 2) }}</div>
                            </div>
                            <div class="summary-row">
                                <div>Service Fee</div>
                                <div>{{ number_format($serviceFee, 2) }}</div>
                            </div>
                            <div class="summary-row total">
                                <div>Total</div>
                                <div>{{ number_format($totalPrice, 2) }}</div>
                            </div>
                        </div>

                        <div class="timer">
                            <i class="far fa-clock"></i>
                            <span><span class="time">15:00</span> minutes left to guarantee this price</span>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ route('stripe.checkout') }}" method="POST" enctype="multipart/form-data" id="payment-form">
                @csrf


                <div class="payment-details-container">
                    <!-- Driver Information Section -->
                    <div class="payment-details">
                        <h2 class="section-title"><i class="fas fa-user-circle"></i>Driver Information</h2>

                        <div class="form-group">
                            <label for="full-name"><i class="fas fa-user"></i>Full Name</label>
                            <input type="text" id="full-name" name="full_name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="phone"><i class="fas fa-phone"></i>Phone</label>
                            <input type="tel" id="phone" name="phone" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="email"><i class="fas fa-envelope"></i>Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="cin"><i class="fas fa-id-card"></i>CIN</label>
                            <input type="file" id="cin" name="cin" class="form-control"
                                accept=".jpg,.jpeg,.png,.pdf" required>
                        </div>

                        <div class="form-group">
                            <label for="driver-license"><i class="fas fa-id-badge"></i>Driver License</label>
                            <input type="file" id="driver-license" name="driver_license" class="form-control"
                                accept=".jpg,.jpeg,.png,.pdf" required>
                        </div>

                        <div class="form-group">
                            <label for="address"><i class="fas fa-map-marker-alt"></i>Address</label>
                            <input type="text" id="address" name="address" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="age"><i class="fas fa-calendar-alt"></i>Age</label>
                            <input type="number" id="age" name="age" class="form-control" min="18"
                                required>
                        </div>

                        <div class="checkbox-group">
                            <input type="checkbox" id="terms" name="terms" required>
                            <label for="terms">
                                I have read and accept the <a href="#">terms and conditions</a>, legal notice and
                                privacy policy
                            </label>
                        </div>
                    </div>

                    <!-- Payment Section -->
                    <div class="payment-details">
                        <h2 class="section-title"><i class="fas fa-credit-card"></i>Payment Details</h2>

                        <div class="card-icons">
                            <img src="/api/placeholder/40/30" alt="Visa">
                            <img src="/api/placeholder/40/30" alt="MasterCard">
                            <img src="/api/placeholder/40/30" alt="American Express">
                            <img src="/api/placeholder/40/30" alt="Maestro">
                        </div>

                        <div class="card-form">
                            <div class="form-group">
                                <label for="card-number"><i class="far fa-credit-card"></i>Card Number</label>
                                <input type="text" id="card-number" name="card_number" class="form-control"
                                    placeholder="1234 5678 9012 3456" required>
                            </div>

                            <div class="form-group">
                                <label for="card-name"><i class="fas fa-signature"></i>Cardholder Name</label>
                                <input type="text" id="card-name" name="card_name" class="form-control" required>
                            </div>

                            <div class="expiry-security">
                                <div class="expiry-date">
                                    <label><i class="far fa-calendar-alt"></i>Expiry Date</label>
                                    <div class="expiry-inputs">
                                        <input type="text" name="expiry_month" class="form-control"
                                            placeholder="MM" required>
                                        <input type="text" name="expiry_year" class="form-control"
                                            placeholder="YY" required>
                                    </div>
                                </div>

                                <div class="security-code">
                                    <label for="cvv"><i class="fas fa-lock"></i>Security Code (CVV)</label>
                                    <input type="password" id="cvv" name="cvv" class="form-control"
                                        placeholder="123" required>
                                    <i class="fas fa-info-circle info-icon"></i>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-pay" id="checkout-button">
                            Pay Now - {{ number_format($totalPrice, 2) }}
                        </button>

                        <div class="payment-security">
                            <img src="/api/placeholder/60/30" alt="Secure Payment" class="security-logo">
                            <img src="/api/placeholder/60/30" alt="Verified by Visa" class="security-logo">
                            <img src="/api/placeholder/60/30" alt="MasterCard SecureCode" class="security-logo">
                            <img src="/api/placeholder/60/30" alt="SSL Encrypted" class="security-logo">
                        </div>

                        <div class="no-fees">No Credit Card Fees</div>
                    </div>
                </div>
            </form>


        </div>
    </div>
    <style>
        :root {
            --primary-red: #DC1E2D;
            --dark-red: #B81726;
            --light-gray: #f5f5f5;
            --medium-gray: #ddd;
            --dark-gray: #666;
            --white: #fff;
            --success-green: #2ecc71;
            --text-color: #333;
            --border-color: #e0e0e0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--light-gray);
            color: var(--text-color);
        }

        .container {
            width: 100%;
            max-width: 100%;
            padding: 0;
        }



        /* Main Content */
        .page-title {
            padding: 30px 20px;
            font-size: 24px;
            font-weight: 600;
            color: var(--text-color);
            max-width: 1400px;
            margin: 0 auto;
        }

        .main-content-wrapper {
            display: flex;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px 40px;
        }

        .car-details-container {
            flex: 1;
            position: sticky;
            top: 20px;
            height: fit-content;
            margin-right: 20px;
        }

        .payment-details-container {
            flex: 2;
        }

        .car-details {
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .car-image {
            background-color: var(--light-gray);
            padding: 20px;
            text-align: center;
        }

        .car-image img {
            max-width: 100%;
            height: auto;
        }

        .car-info {
            padding: 20px;
        }

        .car-model {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--text-color);
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }

        .available-badge {
            display: inline-block;
            background-color: #e8f5e9;
            color: var(--success-green);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            margin-left: 10px;
        }

        .section-divider {
            height: 1px;
            background-color: var(--border-color);
            margin: 15px 0;
        }

        .car-specs {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin: 20px 0;
        }

        .spec-item {
            display: flex;
            align-items: center;
        }

        .spec-icon {
            color: var(--primary-red);
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .spec-text {
            font-size: 14px;
        }

        .rental-details {
            margin: 20px 0;
        }

        .rental-detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 14px;
        }

        .rental-detail-label {
            display: flex;
            align-items: center;
            color: var(--dark-gray);
        }

        .rental-detail-label i {
            color: var(--primary-red);
            margin-right: 8px;
            width: 16px;
            text-align: center;
        }

        .rental-detail-value {
            font-weight: 500;
        }

        .reviews {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .stars {
            color: #FFD700;
            margin-right: 5px;
        }

        .reviews-count {
            font-size: 14px;
            color: var(--dark-gray);
        }

        .car-price {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-color);
            margin: 20px 0;
        }

        .per-day {
            font-size: 16px;
            font-weight: normal;
        }

        .payment-summary {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 15px;
        }

        .summary-row.total {
            border-top: 1px solid var(--medium-gray);
            padding-top: 12px;
            margin-top: 12px;
            font-size: 18px;
            font-weight: 600;
        }

        /* Payment Form */
        .payment-details {
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--text-color);
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .section-title i {
            color: var(--primary-red);
            margin-right: 10px;
        }

        .form-row {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .form-group label i {
            color: var(--primary-red);
            margin-right: 8px;
            width: 16px;
            text-align: center;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--medium-gray);
            border-radius: 4px;
            font-size: 15px;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-red);
            outline: none;
        }

        .info-text {
            display: flex;
            align-items: flex-start;
            font-size: 14px;
            color: var(--dark-gray);
            margin-top: 5px;
        }

        .info-text i {
            margin-right: 8px;
            color: var(--primary-red);
            margin-top: 2px;
        }

        .form-columns {
            display: flex;
            gap: 15px;
        }

        .form-columns .form-group {
            flex: 1;
        }

        .checkbox-group {
            display: flex;
            align-items: flex-start;
            margin-top: 20px;
        }

        .checkbox-group input {
            margin-right: 10px;
            margin-top: 3px;
        }

        .checkbox-group label {
            font-size: 14px;
            line-height: 1.4;
        }

        .checkbox-group a {
            color: var(--primary-red);
            text-decoration: none;
        }

        .timer {
            text-align: right;
            margin-top: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            color: var(--dark-gray);
        }

        .timer i {
            margin-right: 5px;
            color: var(--primary-red);
        }

        .timer .time {
            font-weight: 600;
            color: var(--primary-red);
        }

        /* Payment Section */
        .payment-section {
            margin-top: 30px;
        }

        .card-icons {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .card-icons img {
            height: 30px;
        }

        .card-form {
            margin-bottom: 30px;
        }

        .expiry-security {
            display: flex;
            gap: 20px;
        }

        .expiry-date {
            flex: 1;
        }

        .expiry-date label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .expiry-date label i {
            color: var(--primary-red);
            margin-right: 8px;
            width: 16px;
            text-align: center;
        }

        .expiry-inputs {
            display: flex;
            gap: 10px;
        }

        .security-code {
            flex: 1;
            position: relative;
        }

        .security-code label {
            display: flex;
            align-items: center;
        }

        .security-code label i {
            color: var(--primary-red);
            margin-right: 8px;
            width: 16px;
            text-align: center;
        }

        .security-code i.info-icon {
            position: absolute;
            right: 10px;
            top: 47px;
            color: var(--dark-gray);
            cursor: pointer;
        }

        .btn-pay {
            width: 100%;
            padding: 15px;
            background-color: var(--primary-red);
            color: var(--white);
            border: none;
            border-radius: 4px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-pay:hover {
            background-color: var(--dark-red);
        }

        .payment-security {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
        }

        .security-logo {
            height: 30px;
        }

        .no-fees {
            text-align: center;
            color: var(--success-green);
            font-weight: 500;
            margin-top: 10px;
        }

        /* Responsive */
        @media (max-width: 1000px) {
            .main-content-wrapper {
                flex-direction: column;
            }

            .car-details-container {
                position: static;
                margin-right: 0;
                margin-bottom: 20px;
                width: 100%;
            }

            .payment-details-container {
                width: 100%;
            }

            .expiry-security {
                flex-direction: column;
                gap: 15px;
            }

            .form-columns {
                flex-direction: column;
                gap: 0;
            }

            .nav-menu {
                display: none;
            }

            .search-bar {
                margin: 0 10px;
            }
        }
    </style>
<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const timeElement = document.querySelector('.time');
    const checkoutButton = document.getElementById("checkout-button");
    const form = document.getElementById('payment-form');

    if (timeElement) {
        // Timer code remains the same
        let countdownTime = 15 * 60; // 15 minutes in seconds

        const updateTimer = () => {
            const minutes = Math.floor(countdownTime / 60);
            const seconds = countdownTime % 60;
            timeElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        };

        const handleExpiry = () => {
            alert('Your booking session has expired. Please restart your booking.');
            window.location.href = "{{ route('dashboard') }}";
        };

        const interval = setInterval(() => {
            if (countdownTime <= 0) {
                clearInterval(interval);
                handleExpiry();
                return;
            }
            countdownTime--;
            updateTimer();
        }, 1000);

        updateTimer(); // Initial display
    }

    // Initialize Stripe
    const stripe = Stripe("{{ env('STRIPE_KEY') }}");

    // Handle checkout button click
    if (checkoutButton && form) {
        checkoutButton.addEventListener("click", function (e) {
            e.preventDefault();

            // Basic form validation
            const requiredFields = form.querySelectorAll('[required]');
            let formIsValid = true;

            requiredFields.forEach(field => {
                if (!field.value) {
                    formIsValid = false;
                    field.style.borderColor = 'red';
                } else {
                    field.style.borderColor = '';
                }
            });

            if (!formIsValid) {
                alert('Please fill in all required fields');
                return;
            }

            // Disable button to prevent multiple submissions
            checkoutButton.disabled = true;
            checkoutButton.textContent = "Processing...";

            // Create a FormData object for file uploads
            const formData = new FormData();

            // Get form data for user info but don't include card data
            // Those will be handled by Stripe directly
            const formElements = form.elements;
            for (let i = 0; i < formElements.length; i++) {
                const field = formElements[i];
                if (field.name && field.name !== 'card_number' &&
                    field.name !== 'card_name' && field.name !== 'expiry_month' &&
                    field.name !== 'expiry_year' && field.name !== 'cvv') {

                    if (field.type === 'file' && field.files.length > 0) {
                        formData.append(field.name, field.files[0]);
                    } else if (field.type !== 'file') {
                        formData.append(field.name, field.value);
                    }
                }
            }

            // Log form data for debugging (remove in production)
            console.log("Form data being submitted:");
            for (let pair of formData.entries()) {
                // Don't log file contents, just their presence
                if (pair[1] instanceof File) {
                    console.log(pair[0] + ': File uploaded - ' + pair[1].name);
                } else {
                    console.log(pair[0] + ': ' + pair[1]);
                }
            }

            // Send form data to create Checkout Session
            fetch("{{ route('stripe.checkout') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: formData
            })
            .then(response => {
                console.log("Response status:", response.status);

                if (!response.ok) {
                    return response.json().then(err => {
                        throw err;
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log("Success response:", data);

                if (data.sessionId) {
                    console.log("Redirecting to Stripe checkout with session ID:", data.sessionId);
                    return stripe.redirectToCheckout({ sessionId: data.sessionId });
                } else {
                    console.error("No session ID in response:", data);
                    throw { error: 'Session ID not received from server' };
                }
            })
            .then(result => {
                // Handle any errors from redirectToCheckout
                if (result && result.error) {
                    console.error("Stripe redirect error:", result.error);
                    throw result.error;
                }
            })
            .catch(error => {
                console.error("Error details:", error);

                let errorMessage = 'Payment processing failed. Please try again.';

                // Extract error message from various formats
                if (typeof error === 'string') {
                    errorMessage = error;
                } else if (error.message) {
                    errorMessage = error.message;
                } else if (error.error) {
                    if (typeof error.error === 'string') {
                        errorMessage = error.error;
                    } else if (typeof error.error === 'object') {
                        // Handle Laravel validation errors which come as nested objects
                        const validationErrors = [];
                        for (const field in error.error) {
                            if (Array.isArray(error.error[field])) {
                                validationErrors.push(error.error[field].join(', '));
                            }
                        }
                        if (validationErrors.length > 0) {
                            errorMessage = validationErrors.join('\n');
                        }
                    }
                }

                alert(errorMessage);
                checkoutButton.disabled = false;
                checkoutButton.textContent = "Pay Now - {{ number_format($totalPrice, 2) }}";
            });
        });
    } else {
        console.error("Checkout button or form not found");
    }
});
</script>






</x-app-layout>
