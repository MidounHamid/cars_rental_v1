@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Add New Car Delivery Location</h2>
    <form action="{{ route('car_delivery_locations.store') }}" method="POST" class="car-delivery-location-form">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="car_id">Car</label>
                <select name="car_id" id="car_id" class="form-input" required>
                    @foreach($cars as $car)
                        <option value="{{ $car->id }}" {{ old('car_id') == $car->id ? 'selected' : '' }}>
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
                <label for="location_id">Location</label>
                <select name="location_id" id="location_id" class="form-input" required>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                            {{ $location->name }}-{{ $location->type }}
                        </option>
                    @endforeach
                </select>
                @error('location_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Create Car Delivery Location</button>
            <a href="{{ route('car_delivery_locations.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
