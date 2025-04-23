@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Edit Insurance</h2>
    <form action="{{ route('insurances.update', $insurance->id) }}" method="POST" class="insurance-form">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="name">Insurance Name</label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $insurance->name) }}">
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-input">{{ old('description', $insurance->description) }}</textarea>
                @error('description')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="price_per_day">Price per Day</label>
                <input type="number" id="price_per_day" name="price_per_day" class="form-input" value="{{ old('price_per_day', $insurance->price_per_day) }}" step="0.01">
                @error('price_per_day')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Update Insurance</button>
            <a href="{{ route('insurances.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
