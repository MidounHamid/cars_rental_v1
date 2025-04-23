@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Add New Car Image</h2>
    <form action="{{ route('car_images.store') }}" method="POST" enctype="multipart/form-data" class="car-image-form">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="car_id">Car</label>
                <select id="car_id" name="car_id" class="form-input">
                    <option value="">Select a Car</option>
                    @foreach($cars as $car)
                        <option value="{{ $car->id }}" {{ old('car_id') == $car->id ? 'selected' : '' }}>{{ $car->name }}</option>
                    @endforeach
                </select>
                @error('car_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="image_path">Car Image</label>
                <input type="file" id="image_path" name="image_path" class="form-input" accept="image/*">
                @error('image_path')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="is_primary">Primary Image</label>
                <input type="checkbox" id="is_primary" name="is_primary" class="form-input" {{ old('is_primary') ? 'checked' : '' }}>
                @error('is_primary')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Create Car Image</button>
            <a href="{{ route('car_images.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
