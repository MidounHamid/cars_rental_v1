@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Edit Mode of Payment</h2>
    <form action="{{ route('mode_payments.update', $mode_payment->id) }}" method="POST" class="mode-payment-form">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="mode_payment">Payment Mode</label>
                <input type="text" id="mode_payment" name="mode_payment" class="form-input" value="{{ old('mode_payment', $mode_payment->mode_payment) }}">
                @error('mode_payment')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Update Payment Mode</button>
            <a href="{{ route('mode_payments.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
