<x-app-layout>
    <div class="container">
        <div class="payment-success">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>Payment Successful!</h1>
            <p>Your booking has been confirmed.</p>

            <div class="booking-details">
                <h2>Booking Details</h2>
                <div class="detail-row">
                    <div class="detail-label">Transaction ID:</div>
                    <div class="detail-value">{{ $payment->transaction_id }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Amount Paid:</div>
                    <div class="detail-value">${{ number_format($payment->amount, 2) }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Booking Status:</div>
                    <div class="detail-value">{{ ucfirst($booking->status) }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Start Date:</div>
                    <div class="detail-value">
                        {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }} at
                        {{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }}
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">End Date:</div>
                    <div class="detail-value">
                        {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }} at
                        {{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}
                    </div>
                </div>
            </div>

            <div class="actions">
                <a href="{{ route('dashboard') }}" class="btn-primary">Go to Dashboard</a>
                <a href="{{ route('dashboard') }}" class="btn-secondary">View My Bookings</a>
            </div>
        </div>
    </div>

    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .payment-success {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 40px;
            text-align: center;
        }

        .success-icon {
            font-size: 80px;
            color: #2ecc71;
            margin-bottom: 20px;
        }

        .payment-success h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }

        .payment-success p {
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
        }

        .booking-details {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            margin: 30px 0;
            text-align: left;
        }

        .booking-details h2 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 16px;
        }

        .detail-label {
            font-weight: 500;
            color: #666;
        }

        .detail-value {
            font-weight: 600;
            color: #333;
        }

        .actions {
            margin-top: 30px;
        }

        .btn-primary {
            display: inline-block;
            background-color: #DC1E2D;
            color: white;
            padding: 12px 24px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            margin-right: 10px;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #B81726;
        }

        .btn-secondary {
            display: inline-block;
            background-color: #f5f5f5;
            color: #333;
            padding: 12px 24px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .btn-secondary:hover {
            background-color: #e0e0e0;
        }

        @media (max-width: 600px) {
            .actions {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .btn-primary,
            .btn-secondary {
                margin-right: 0;
            }
        }
    </style>
</x-app-layout>
