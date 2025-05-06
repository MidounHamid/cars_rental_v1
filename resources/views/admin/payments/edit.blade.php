@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Edit Payment</h2>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('payments.update', $payment->id) }}" method="POST" class="payment-form">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="booking_id">Booking ID</label>
                <select id="booking_id" name="booking_id" class="form-input">
                    @foreach ($bookings as $booking)
                        <option value="{{ $booking->id }}" @selected($booking->id == $payment->booking_id)>
                            {{ $booking->id }}
                        </option>
                    @endforeach
                </select>
                @error('booking_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="text" id="amount" name="amount" class="form-input"
                       value="{{ old('amount', $payment->amount) }}">
                @error('amount')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Payment Status</label>
                <select id="status" name="status" class="form-input">
                    @foreach (['pending', 'successful', 'failed', 'refunded'] as $statusOption)
                        <option value="{{ $statusOption }}" @selected($payment->status == $statusOption)>
                            {{ ucfirst($statusOption) }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="mode_payment_id">Payment Method</label>
                <select id="mode_payment_id" name="mode_payment_id" class="form-input">
                    @foreach ($modePayments as $modePayment)
                        <option value="{{ $modePayment->id }}" @selected($modePayment->id == $payment->mode_payment_id)>
                            {{ $modePayment->mode_payment }}
                        </option>
                    @endforeach
                </select>
                @error('mode_payment_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="transaction_id">Transaction ID (Optional)</label>
                <input type="text" id="transaction_id" name="transaction_id" class="form-input"
                       value="{{ old('transaction_id', $payment->transaction_id) }}">
                @error('transaction_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Update Payment</button>
            <a href="{{ route('payments.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
