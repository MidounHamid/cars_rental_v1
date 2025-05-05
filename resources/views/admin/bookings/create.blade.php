@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <div class="table-header">
        <h2>Add New Booking</h2>
    </div>

    <form action="{{ route('bookings.store') }}" method="POST" class="booking-form">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="user_id">User</label>
                <select id="user_id" name="user_id" class="form-input" required>
                    <option value="">Select User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
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
                                {{ old('car_id') == $car->id ? 'selected' : '' }}
                                data-price="{{ $car->price }}">
                            {{ $car->brand->name ?? 'N/A' }} {{ $car->model }} ({{ $car->license_plate }}) - {{ number_format($car->price, 2) }}€/day
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
                       value="{{ old('start_date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                @error('start_date')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" id="end_date" name="end_date" class="form-input"
                       value="{{ old('end_date', date('Y-m-d', strtotime('+1 day'))) }}"
                       min="{{ date('Y-m-d') }}" required>
                @error('end_date')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input type="time" id="start_time" name="start_time" class="form-input"
                       value="{{ old('start_time', '09:00') }}" required>
                @error('start_time')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="end_time">End Time</label>
                <input type="time" id="end_time" name="end_time" class="form-input"
                       value="{{ old('end_time', '17:00') }}" required>
                @error('end_time')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-input" required>
                    <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
                @error('status')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="promotion_id">Promotion</label>
                <select id="promotion_id" name="promotion_id" class="form-input">
                    <option value="">No Promotion</option>
                    @foreach($promotions as $promo)
                        <option value="{{ $promo->id }}"
                                {{ old('promotion_id') == $promo->id ? 'selected' : '' }}
                                data-discount="{{ $promo->discount_percent }}">
                            {{ $promo->name }} ({{ $promo->discount_percent }}% Off)
                            @if(isset($promo->expires_at))
                            - Valid until {{ \Carbon\Carbon::parse($promo->expires_at)->format('M d, Y') }}
                            @endif
                        </option>
                    @endforeach
                </select>
                @error('promotion_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Specifications Section -->
        <div class="specifications-section">
            <h3>Additional Specifications</h3>
            <div class="specifications-list">
                @foreach($specifications ?? [] as $spec)
                <div class="specification-item">
                    <div class="spec-name">
                        <input type="checkbox" name="specifications[{{ $spec->id }}][selected]" id="spec_{{ $spec->id }}"
                            {{ old('specifications.'.$spec->id.'.selected') ? 'checked' : '' }}>
                        <label for="spec_{{ $spec->id }}">{{ $spec->name }} ({{ number_format($spec->price, 2) }}€)</label>
                    </div>
                    <div class="spec-quantity">
                        <label for="quantity_{{ $spec->id }}">Quantity:</label>
                        <input type="number" name="specifications[{{ $spec->id }}][quantity]"
                               id="quantity_{{ $spec->id }}" min="1" max="10" value="{{ old('specifications.'.$spec->id.'.quantity', 1) }}"
                               {{ old('specifications.'.$spec->id.'.selected') ? '' : 'disabled' }}>
                        <input type="hidden" name="specifications[{{ $spec->id }}][price]" value="{{ $spec->price }}">
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Price Calculation</label>
                <p>The final price will be calculated using the Booking model's getTotalPriceAttribute method based on your selected dates, car, and any applicable promotions.</p>
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Create Booking</button>
            <a href="{{ route('bookings.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>

<style>
    .booking-form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .form-row {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 15px;
        gap: 20px;
    }
    .form-group {
        flex: 1;
        min-width: 250px;
    }
    .form-input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }
    .form-footer {
        margin-top: 20px;
        display: flex;
        gap: 10px;
    }
    .add-btn {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
    }
    .cancel-btn {
        background-color: #f44336;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        font-weight: bold;
    }
    .error-message {
        color: #f44336;
        font-size: 12px;
        margin-top: 5px;
        display: block;
    }
    .specifications-section {
        margin: 20px 0;
        padding: 15px;
        background-color: #f9f9f9;
        border-radius: 8px;
    }
    .specifications-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 15px;
        margin-top: 10px;
    }
    .specification-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        border: 1px solid #eee;
        border-radius: 4px;
        background-color: white;
    }
    .spec-quantity {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .spec-quantity input[type="number"] {
        width: 60px;
        padding: 4px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Enable/disable quantity fields based on checkbox selection
        const specCheckboxes = document.querySelectorAll('input[type="checkbox"][name^="specifications"]');
        specCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const specId = this.id.split('_')[1];
                const quantityField = document.getElementById('quantity_' + specId);
                quantityField.disabled = !this.checked;
            });
        });
    });
</script>
@endsection
