@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Add New Car Feature</h2> <!-- Changed from 'Specification' to 'Feature' -->
    <form action="{{ route('car_features.store') }}" method="POST" enctype="multipart/form-data" class="car-feature-form"> <!-- Changed route and class name -->
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="car_id">Car</label>
                <select id="car_id" name="car_id" class="form-input">
                    <option value="">Select Car</option>
                    @foreach($cars as $car)
                        <option value="{{ $car->id }}" {{ old('car_id') == $car->id ? 'selected' : '' }}>{{ $car->model }}</option>
                    @endforeach
                </select>
                @error('car_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="feature_id">Feature</label> <!-- Changed from 'Specification' to 'Feature' -->
                <select id="feature_id" name="feature_id" class="form-input"> <!-- Changed from 'specification_id' to 'feature_id' -->
                    <option value="">Select Feature</option> <!-- Changed from 'Specification' to 'Feature' -->
                    @foreach($features as $feature) <!-- Changed variable from $specifications to $features -->
                        <option value="{{ $feature->id }}" {{ old('feature_id') == $feature->id ? 'selected' : '' }}>{{ $feature->feature }}</option> <!-- Changed from 'specification' to 'feature' -->
                    @endforeach
                </select>
                @error('feature_id') <!-- Changed from 'specification_id' to 'feature_id' -->
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Create Car Feature</button> <!-- Changed from 'Create Car Specification' to 'Create Car Feature' -->
            <a href="{{ route('car_features.index') }}" class="cancel-btn">Cancel</a> <!-- Changed route from 'car_spefications.index' to 'car_features.index' -->
        </div>
    </form>
</div>
@endsection
