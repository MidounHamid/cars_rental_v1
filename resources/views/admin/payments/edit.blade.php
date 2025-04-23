@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Edit Payment</h2>
    <form action="{{ route('payments.update', $payment->id) }}" method="POST" class="payment-form">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="booking_id">Booking ID</label>
                <select id="booking_id" name="booking_id" class="form-input">
                    @foreach ($bookings as $booking)
                        <option value="{{ $booking->id }}" @if ($booking->id == $payment->booking_id) selected @endif>{{ $booking->id }}</option>
                    @endforeach
                </select>
                @error('booking_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="text" id="amount" name="amount" class="form-input" value="{{ old('amount', $payment->amount) }}">
                @error('amount')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="method">Payment Method</label>
                <select id="method" name="method" class="form-input">
                    <option value="cash" @if ($payment->method == 'cash') selected @endif>Cash</option>
                    <option value="card" @if ($payment->method == 'card') selected @endif>Card</option>
                    <option value="paypal" @if ($payment->method == 'paypal') selected @endif>PayPal</option>
                    <option value="bank_transfer" @if ($payment->method == 'bank_transfer') selected @endif>Bank Transfer</option>
                </select>
                @error('method')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Payment Status</label>
                <select id="status" name="status" class="form-input">
                    <option value="pending" @if ($payment->status == 'pending') selected @endif>Pending</option>
                    <option value="successful" @if ($payment->status == 'successful') selected @endif>Successful</option>
                    <option value="failed" @if ($payment->status == 'failed') selected @endif>Failed</option>
                    <option value="refunded" @if ($payment->status == 'refunded') selected @endif>Refunded</option>
                </select>
                @error('status')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="mode_payment_id">Payment Mode</label>
                <select id="mode_payment_id" name="mode_payment_id" class="form-input">
                    @foreach ($modePayments as $modePayment)
                        <option value="{{ $modePayment->id }}" @if ($modePayment->id == $payment->mode_payment_id) selected @endif>{{ $modePayment->mode_payment }}</option>
                    @endforeach
                </select>
                @error('mode_payment_id')
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
