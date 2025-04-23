@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Add New Payment</h2>
    <form action="{{ route('payments.store') }}" method="POST" class="payment-form">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="booking_id">Booking ID</label>
                <select id="booking_id" name="booking_id" class="form-input">
                    @foreach ($bookings as $booking)
                        <option value="{{ $booking->id }}">{{ $booking->id }}</option>
                    @endforeach
                </select>
                @error('booking_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="text" id="amount" name="amount" class="form-input" value="{{ old('amount') }}">
                @error('amount')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="method">Payment Method</label>
                <select id="method" name="method" class="form-input">
                    <option value="cash">Cash</option>
                    <option value="card">Card</option>
                    <option value="paypal">PayPal</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>
                @error('method')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Payment Status</label>
                <select id="status" name="status" class="form-input">
                    <option value="pending">Pending</option>
                    <option value="successful">Successful</option>
                    <option value="failed">Failed</option>
                    <option value="refunded">Refunded</option>
                </select>
                @error('status')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="mode_payment_id">Payment Mode</label>
                <select id="mode_payment_id" name="mode_payment_id" class="form-input">
                    @foreach ($modePayments as $modePayment)
                        <option value="{{ $modePayment->id }}">{{ $modePayment->mode_payment }}</option>
                    @endforeach
                </select>
                @error('mode_payment_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Create Payment</button>
            <a href="{{ route('payments.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
