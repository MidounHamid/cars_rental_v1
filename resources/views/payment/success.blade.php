<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
            <div class="text-center mb-8">
                <i class="fas fa-check-circle text-green-500 text-5xl mb-4"></i>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Payment Successful!</h1>
                <p class="text-gray-600">Your booking has been confirmed.</p>
            </div>

            <div class="space-y-6">
                <div class="border-t border-gray-200 pt-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Booking Details</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Booking Reference</p>
                            <p class="font-medium">#{{ $booking->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Car</p>
                            <p class="font-medium">{{ $booking->car->brand->brand }} {{ $booking->car->model }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Pickup Date</p>
                            <p class="font-medium">{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }} at
                                {{ $booking->start_time }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Return Date</p>
                            <p class="font-medium">{{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }} at
                                {{ $booking->end_time }}</p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Payment Information</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Transaction ID</p>
                            <p class="font-medium">{{ $payment->transaction_id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Amount Paid</p>
                            <p class="font-medium">${{ number_format($payment->amount, 2) }}</p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <div class="flex justify-center space-x-4">
                        <a href="{{ $pdfUrl }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            <i class="fas fa-download mr-2"></i>
                            Download Receipt
                        </a>
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            <i class="fas fa-home mr-2"></i>
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
