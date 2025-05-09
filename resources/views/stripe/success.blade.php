@extends('layouts.app')

@section('content')
    <div class="success-container">
        <div class="success-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
            </svg>
        </div>
        <div class="success-title">Payment Successful!</div>
        <div class="success-info">Your booking has been confirmed and is ready to go.</div>

        <div class="success-card">
            <h3>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M19 4h-4V2h-6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V6h14v14zM7 10h5v5H7z" />
                </svg>
                Booking Details
            </h3>
            <p><span>Booking Reference:</span> <span>#{{ $booking->id }}</span></p>
            <p><span>Car:</span> <span>{{ $booking->car->brand->brand }} {{ $booking->car->model }}</span></p>
            <p><span>Pickup Date:</span> <span>{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }} at
                    {{ $booking->start_time }}</span></p>
            <p><span>Return Date:</span> <span>{{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }} at
                    {{ $booking->end_time }}</span></p>
        </div>

        <div class="success-card">
            <h3>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z" />
                </svg>
                Payment Information
            </h3>
            <p><span>Transaction ID:</span> <span>{{ $payment->transaction_id }}</span></p>
            <p><span>Amount Paid:</span> <span>${{ number_format($payment->amount, 2) }}</span></p>
        </div>

        <div class="button-container">
            <a href="{{ $pdfUrl }}" class="success-link" download="receipt-{{ $booking->id }}.pdf">
                Download Receipt
            </a>
            <button onclick="openReviewPopup('{{ $booking->car->id }}')" class="review-button">
                Rate Your Experience
            </button>
            <a href="{{ route('dashboard') }}" class="success-link secondary">
                Back to Dashboard
            </a>
        </div>
    </div>

    @include('client.reviews.review-popup')
@endsection

@push('styles')
    <style>
        .success-container {
            max-width: 650px;
            margin: 50px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            position: relative;
            z-index: 1;
        }

        .success-icon {
            width: 70px;
            height: 70px;
            background: rgba(220, 30, 45, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .success-icon svg {
            width: 40px;
            height: 40px;
            fill: #DC1E2D;
        }

        .success-title {
            color: #DC1E2D;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .success-info {
            margin: 15px 0 30px;
            font-size: 1.2rem;
            color: #555;
        }

        .success-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 25px;
            text-align: left;
            margin-bottom: 25px;
            border-left: 4px solid #DC1E2D;
        }

        .success-card h3 {
            color: #222;
            font-size: 1.2rem;
            margin-bottom: 15px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .success-card h3 svg {
            width: 18px;
            height: 18px;
            margin-right: 8px;
            fill: #DC1E2D;
        }

        .success-card p {
            margin: 0 0 12px 0;
            color: #444;
            display: flex;
            justify-content: space-between;
        }

        .success-card p:last-child {
            margin-bottom: 0;
        }

        .success-card p span:first-child {
            font-weight: 500;
            color: #555;
        }

        .success-card p span:last-child {
            font-weight: 400;
        }

        .button-container {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }

        .success-link {
            display: inline-block;
            padding: 12px 25px;
            background: #DC1E2D;
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
            box-shadow: 0 4px 6px rgba(220, 30, 45, 0.15);
        }

        .success-link:hover {
            background: #c01825;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(220, 30, 45, 0.2);
            color: #fff;
            text-decoration: none;
        }

        .success-link.secondary {
            background: #f1f2f3;
            color: #333;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.08);
        }

        .success-link.secondary:hover {
            background: #e5e6e7;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.12);
        }

        .review-button {
            display: inline-block;
            padding: 12px 25px;
            background: #4CAF50;
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
            box-shadow: 0 4px 6px rgba(76, 175, 80, 0.15);
            border: none;
            cursor: pointer;
        }

        .review-button:hover {
            background: #43A047;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(76, 175, 80, 0.2);
        }

        @media (max-width: 767px) {
            .success-container {
                margin: 20px 15px;
                padding: 25px;
            }

            .button-container {
                flex-direction: column;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Check if URL contains payment_intent
            const urlParams = new URLSearchParams(window.location.search);
            const paymentIntent = urlParams.get('payment_intent');

            if (paymentIntent) {
                // Clean the URL first
                const newUrl = window.location.pathname;
                window.history.replaceState({}, document.title, newUrl);
            }
        });
    </script>
@endpush
