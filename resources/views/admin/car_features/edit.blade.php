@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Edit Car Feature</h2> <!-- Changed 'Specification' to 'Feature' -->

    <form
        action="{{ isset($car_feature) ? route('car_features.update', $car_feature->id) : route('car_features.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="car-feature-form"
    >
        @csrf
        @if(isset($car_feature)) <!-- Changed variable name from $car_spefication to $car_feature -->
            @method('PUT')
        @endif

        <div class="form-row">
            <div class="form-group">
                <label for="car_id">Car</label>
                <select id="car_id" name="car_id" class="form-input">
                    <option value="">Select Car</option>
                    @foreach($cars as $car)
                        <option value="{{ $car->id }}"
                            {{ old('car_id', $car_feature->car_id ?? '') == $car->id ? 'selected' : '' }} <!-- Updated variable name -->
                        >
                            {{ $car->model }}
                        </option>
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
                    @foreach($features as $feature) <!-- Changed from $specifications to $features -->
                        <option value="{{ $feature->id }}"
                            {{ old('feature_id', $car_feature->feature_id ?? '') == $feature->id ? 'selected' : '' }}> <!-- Updated variable name -->
                            {{ $feature->feature }} <!-- Changed from 'specification' to 'feature' -->
                        </option>
                    @endforeach
                </select>
                @error('feature_id') <!-- Updated variable name from 'specification_id' -->
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">
                {{ isset($car_feature) ? 'Update' : 'Create' }} Car Feature <!-- Changed 'Specification' to 'Feature' -->
            </button>
            <a href="{{ route('car_features.index') }}" class="cancel-btn">Cancel</a> <!-- Changed route from 'car_spefications.index' to 'car_features.index' -->
        </div>
    </form>
</div>
@endsection
