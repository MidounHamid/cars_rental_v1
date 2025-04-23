@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Add New Car Type</h2>
    <form action="{{ route('car_types.store') }}" method="POST" class="car-type-form">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="name">Car Type Name</label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}">
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-input" rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Create Car Type</button>
            <a href="{{ route('car_types.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
