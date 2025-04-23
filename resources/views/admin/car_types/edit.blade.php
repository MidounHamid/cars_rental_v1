@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Edit Car Type</h2>
    <form action="{{ route('car_types.update', $carType->id) }}" method="POST" class="car-type-form">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="name">Car Type Name</label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $carType->name) }}">
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-input" rows="3">{{ old('description', $carType->description) }}</textarea>
                @error('description')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Update Car Type</button>
            <a href="{{ route('car_types.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
