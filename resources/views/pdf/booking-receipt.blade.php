<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Booking Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #DC1E2D;
            padding-bottom: 10px;
        }

        .logo {
            max-width: 200px;
            margin-bottom: 10px;
        }

        .receipt-title {
            color: #DC1E2D;
            font-size: 24px;
            margin: 0;
        }

        .booking-details {
            margin-bottom: 30px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            color: #333;
            font-size: 18px;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .label {
            font-weight: bold;
            color: #666;
        }

        .value {
            color: #333;
        }

        .total-section {
            margin-top: 30px;
            border-top: 2px solid #ddd;
            padding-top: 20px;
        }

        .total-row {
            font-size: 18px;
            font-weight: bold;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1 class="receipt-title">Booking Receipt</h1>
        <p>Booking Reference: #{{ $booking->id }}</p>
    </div>

    <div class="booking-details">
        <div class="section">
            <h2 class="section-title">Car Information</h2>
            <div class="detail-row">
                <span class="label">Car Model:</span>
                <span class="value">{{ $booking->car->brand->brand }} {{ $booking->car->model }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Type:</span>
                <span class="value">{{ $booking->car->carType->name }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Seats:</span>
                <span class="value">{{ $booking->car->seats }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Fuel Type:</span>
                <span class="value">{{ $booking->car->fuelType->fuel_type }}</span>
            </div>
        </div>

        <div class="section">
            <h2 class="section-title">Rental Details</h2>
            <div class="detail-row">
                <span class="label">Pickup Date:</span>
                <span class="value">{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }} at
                    {{ $booking->start_time }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Return Date:</span>
                <span class="value">{{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }} at
                    {{ $booking->end_time }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Duration:</span>
                <span
                    class="value">{{ $booking->duration_days ?? \Carbon\Carbon::parse($booking->start_date)->diffInDays($booking->end_date) }}
                    days</span>
            </div>
        </div>

        <div class="section">
            <h2 class="section-title">Customer Information</h2>
            <div class="detail-row">
                <span class="label">Name:</span>
                <span class="value">{{ $booking->user->name }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Email:</span>
                <span class="value">{{ $booking->user->email }}</span>
            </div>
        </div>

        <div class="section total-section">
            <h2 class="section-title">Payment Summary</h2>

            @if (isset($basePrice) && $basePrice > 0)
                <div class="detail-row">
                    <span class="label">Base Price:</span>
                    <span class="value">${{ number_format($basePrice, 2) }}</span>
                </div>
            @endif

            @if (isset($insuranceFee) && $insuranceFee > 0)
                <div class="detail-row">
                    <span class="label">Insurance Fee:</span>
                    <span class="value">${{ number_format($insuranceFee, 2) }}</span>
                </div>
            @endif

            @if (isset($serviceFee) && $serviceFee > 0)
                <div class="detail-row">
                    <span class="label">Service Fee:</span>
                    <span class="value">${{ number_format($serviceFee, 2) }}</span>
                </div>
            @endif

            @if (isset($booking->specifications) && count($booking->specifications) > 0)
                @foreach ($booking->specifications as $specification)
                    @if ($specification->price > 0)
                        <div class="detail-row">
                            <span class="label">{{ $specification->name }}:</span>
                            <span class="value">${{ number_format($specification->price, 2) }}</span>
                        </div>
                    @endif
                @endforeach
            @endif

            <div class="detail-row total-row">
                <span class="label">Total Amount:</span>
                <span class="value">${{ number_format($totalPrice, 2) }}</span>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Thank you for choosing our car rental service!</p>
        <p>This receipt serves as proof of your booking.</p>
        <p>For any questions, please contact our customer service.</p>
    </div>
</body>

</html>
