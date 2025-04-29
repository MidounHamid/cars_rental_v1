@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Add New Location</h2>
    <form action="{{ route('locations.store') }}" method="POST" class="location-form">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="name">Location Name</label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="type">Location Type</label>
                <select name="type" id="type" class="form-input" required>
                    <option value="city" {{ old('type') == 'city' ? 'selected' : '' }}>City</option>
                    <option value="airport" {{ old('type') == 'airport' ? 'selected' : '' }}>Airport</option>
                    <option value="train_station" {{ old('type') == 'train_station' ? 'selected' : '' }}>Train Station</option>
                </select>
                @error('type')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Create Location</button>
            <a href="{{ route('locations.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
