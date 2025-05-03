@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Edit Booking</h2>
    <form action="{{ route('bookings.update', $booking->id) }}" method="POST" class="booking-form">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="user_id">User</label>
                <select id="user_id" name="user_id" class="form-input" required>
                    <option value="">Select User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ (old('user_id', $booking->user_id) == $user->id) ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="car_id">Car</label>
                <select id="car_id" name="car_id" class="form-input" required>
                    <option value="">Select Car</option>
                    @foreach($cars as $car)
                        <option value="{{ $car->id }}"
                                {{ (old('car_id', $booking->car_id) == $car->id) ? 'selected' : '' }}>
                            {{ $car->model }}
                        </option>
                    @endforeach
                </select>
                @error('car_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror

            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="form-input"
                       value="{{ old('start_date', $booking->start_date->format('Y-m-d')) }}" required>
                @error('start_date')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" id="end_date" name="end_date" class="form-input"
                       value="{{ old('end_date', $booking->end_date->format('Y-m-d')) }}" required>
                @error('end_date')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="total_price">Total Price</label>
                <input type="number" step="0.01" id="total_price" name="total_price"
                       class="form-input" value="{{ old('total_price', $booking->total_price) }}" readonly>
                @error('total_price')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-input" required>
                    <option value="pending" {{ old('status', $booking->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ old('status', $booking->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ old('status', $booking->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                @error('status')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="promotion_id">Promotion</label>
                <select id="promotion_id" name="promotion_id" class="form-input">
                    <option value="">No Promotion</option>
                    @foreach($promotions as $promo)
                        <option value="{{ $promo->id }}"
                                {{ old('promotion_id', $booking->promotion_id) == $promo->id ? 'selected' : '' }}>
                            {{ $promo->name }} ({{ $promo->discount_percent }}% Off)
                            - Valid until {{ $promo->expires_at->format('M d, Y') }}
                        </option>
                    @endforeach
                </select>
                @error('promotion_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Update Booking</button>
            <a href="{{ route('bookings.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
