@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Edit Location</h2>
    <form action="{{ route('locations.update', $location->id) }}" method="POST" class="location-form">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="name">Location Name</label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $location->name) }}" required>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="type">Location Type</label>
                <select name="type" id="type" class="form-input" required>
                    <option value="city" {{ old('type', $location->type) == 'city' ? 'selected' : '' }}>City</option>
                    <option value="airport" {{ old('type', $location->type) == 'airport' ? 'selected' : '' }}>Airport</option>
                    <option value="train_station" {{ old('type', $location->type) == 'train_station' ? 'selected' : '' }}>Train Station</option>
                </select>
                @error('type')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Update Location</button>
            <a href="{{ route('locations.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
