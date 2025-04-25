@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Edit Car</h2>
    <form action="{{ route('cars.update', $car->id) }}" method="POST" class="agency-form">
        @csrf
        @method('PUT')

        <!-- Car Basic Information -->
        <div class="form-section">
            <h3>Basic Information</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="brand_id">Brand</label>
                    <select name="brand_id" id="brand_id" class="form-input">
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id', $car->brand_id) == $brand->id ? 'selected' : '' }}>
                                {{ $brand->brand }}
                            </option>
                        @endforeach
                    </select>
                    @error('brand_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="model">Model</label>
                    <input type="text" name="model" id="model" class="form-input" value="{{ old('model', $car->model) }}">
                    @error('model')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="car_type_id">Car Type</label>
                    <select name="car_type_id" id="car_type_id" class="form-input">
                        @foreach($carTypes as $type)
                            <option value="{{ $type->id }}" {{ old('car_type_id', $car->car_type_id) == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('car_type_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="agency_id">Agency</label>
                    <select name="agency_id" id="agency_id" class="form-input">
                        @foreach($agencies as $agency)
                            <option value="{{ $agency->id }}" {{ old('agency_id', $car->agency_id) == $agency->id ? 'selected' : '' }}>
                                {{ $agency->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('agency_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Car Specifications -->
        <div class="form-section">
            <h3>Specifications</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="seats">Seats</label>
                    <input type="number" name="seats" id="seats" class="form-input" min="1" max="20" value="{{ old('seats', $car->seats) }}">
                    @error('seats')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="transmission">Transmission</label>
                    <select name="transmission" id="transmission" class="form-input">
                        @foreach(['Automatic', 'Manual', 'CVT', 'Semi-Automatic'] as $option)
                            <option value="{{ $option }}" {{ old('transmission', $car->transmission) === $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                    @error('transmission')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="fuel_types_id">Fuel Type</label>
                    <select name="fuel_types_id" id="fuel_types_id" class="form-input">
                        @foreach($fuelTypes as $fuel)
                            <option value="{{ $fuel->id }}" {{ old('fuel_types_id', $car->fuel_types_id) == $fuel->id ? 'selected' : '' }}>
                                {{ $fuel->fuel_type }}
                            </option>
                        @endforeach
                    </select>
                    @error('fuel_types_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="insurance_id">Insurance</label>
                    <select name="insurance_id" id="insurance_id" class="form-input">
                        @foreach($insurances as $insurance)
                            <option value="{{ $insurance->id }}" {{ old('insurance_id', $car->insurance_id) == $insurance->id ? 'selected' : '' }}>
                                {{ $insurance->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('insurance_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Rental Information -->
        <div class="form-section">
            <h3>Rental Information</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" name="city" id="city" class="form-input" value="{{ old('city', $car->city) }}">
                    @error('city')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price_per_day">Price per Day ($)</label>
                    <input type="number" step="0.01" min="0" name="price_per_day" id="price_per_day" class="form-input" value="{{ old('price_per_day', $car->price_per_day) }}">
                    @error('price_per_day')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="is_available">Available</label>
                    <select name="is_available" id="is_available" class="form-input">
                        <option value="1" {{ old('is_available', $car->is_available) == 1 ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ old('is_available', $car->is_available) == 0 ? 'selected' : '' }}>No</option>
                    </select>
                    @error('is_available')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="available_from">Available From</label>
                    <input type="date" name="available_from" id="available_from" class="form-input"
                        value="{{ old('available_from',
                            $car->available_from instanceof \DateTime ? $car->available_from->format('Y-m-d') :
                            ($car->available_from ? $car->available_from : ''))
                        }}">
                    @error('available_from')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="available_to">Available To</label>
                    <input type="date" name="available_to" id="available_to" class="form-input"
                        value="{{ old('available_to',
                            $car->available_to instanceof \DateTime ? $car->available_to->format('Y-m-d') :
                            ($car->available_to ? $car->available_to : ''))
                        }}">
                    @error('available_to')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Update Car</button>
            <a href="{{ route('cars.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set minimum for available_to to be at least available_from
        const availableFrom = document.getElementById('available_from');
        const availableTo = document.getElementById('available_to');

        availableFrom.addEventListener('change', function() {
            availableTo.min = this.value;
            if (availableTo.value && availableTo.value < this.value) {
                availableTo.value = this.value;
            }
        });

        // Initialize on page load
        if (availableFrom.value) {
            availableTo.min = availableFrom.value;
        }
    });
</script>
@endsection
