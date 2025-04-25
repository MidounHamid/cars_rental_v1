@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Add a New Car</h2>
    <form action="{{ route('cars.store') }}" method="POST" class="agency-form">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="model">Model</label>
                <input type="text" name="model" class="form-input" value="{{ old('model') }}">
                @error('model')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="city">City</label>
                <input type="text" name="city" class="form-input" value="{{ old('city') }}">
                @error('city')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="price_per_day">Price per Day</label>
                <input type="number" step="0.01" name="price_per_day" class="form-input" value="{{ old('price_per_day') }}">
                @error('price_per_day')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="seats">Seats</label>
                <input type="number" name="seats" class="form-input" value="{{ old('seats', 5) }}">
                @error('seats')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="transmission">Transmission</label>
                <select name="transmission" class="form-input">
                    <option value="">Choose...</option>
                    @foreach(['Automatic', 'Manual', 'CVT', 'Semi-Automatic'] as $option)
                        <option value="{{ $option }}" {{ old('transmission') === $option ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>
                @error('transmission')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="is_available">Available</label>
                <select name="is_available" class="form-input">
                    <option value="1" {{ old('is_available', true) == true ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ old('is_available') == false ? 'selected' : '' }}>No</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="available_from">Available From</label>
                <input type="date" name="available_from" class="form-input" value="{{ old('available_from') }}">
                @error('available_from')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="available_to">Available To</label>
                <input type="date" name="available_to" class="form-input" value="{{ old('available_to') }}">
                @error('available_to')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="car_type_id">Car Type</label>
            <select name="car_type_id" class="form-input">
                <option value="">Choose...</option>
                @foreach($carTypes as $type)
                    <option value="{{ $type->id }}" {{ old('car_type_id') == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
            @error('car_type_id')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="fuel_types_id">Fuel Type</label>
            <select name="fuel_types_id" class="form-input">
                <option value="">Choose...</option>
                @foreach($fuelTypes as $fuel)
                    <option value="{{ $fuel->id }}" {{ old('fuel_types_id') == $fuel->id ? 'selected' : '' }}>
                        {{ $fuel->fuel_type }}
                    </option>
                @endforeach
            </select>
            @error('fuel_types_id')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="agency_id">Agency</label>
            <select name="agency_id" class="form-input">
                <option value="">Choose...</option>
                @foreach($agencies as $agency)
                    <option value="{{ $agency->id }}" {{ old('agency_id') == $agency->id ? 'selected' : '' }}>
                        {{ $agency->name }}
                    </option>
                @endforeach
            </select>
            @error('agency_id')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="brand_id">Brand</label>
            <select name="brand_id" class="form-input">
                <option value="">Choose...</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                        {{ $brand->brand }}
                    </option>
                @endforeach
            </select>
            @error('brand_id')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="insurance_id">Insurance</label>
            <select name="insurance_id" class="form-input">
                <option value="">Choose...</option>
                @foreach($insurances as $insurance)
                    <option value="{{ $insurance->id }}" {{ old('insurance_id') == $insurance->id ? 'selected' : '' }}>
                        {{ $insurance->name }}
                    </option>
                @endforeach
            </select>
            @error('insurance_id')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Create</button>
            <a href="{{ route('cars.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
