@extends('client.layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-6">My Reservations</h2>

        <div class="grid gap-6">
            @foreach ($bookings as $booking)
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-xl font-semibold">{{ $booking->car->brand->name }} {{ $booking->car->model }}
                            </h3>
                            <p class="text-gray-600">Booking dates: {{ $booking->start_date->format('M d, Y') }} -
                                {{ $booking->end_date->format('M d, Y') }}</p>
                            <p class="text-gray-600">Status: <span
                                    class="font-semibold">{{ ucfirst($booking->status) }}</span></p>
                        </div>
                        <div class="flex items-center gap-4">
                            @if (
                                $booking->status === 'completed' &&
                                    !$booking->car->reviews()->where('user_id', auth()->id())->exists())
                                <button onclick="openReviewPopup('{{ $booking->car->id }}', '{{ $booking->id }}')"
                                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">
                                    Leave Review
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @include('client.reviews.review-popup')
@endsection
