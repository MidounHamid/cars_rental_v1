@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Edit Feature</h2>
    <form action="{{ route('features.update', $feature->id) }}" method="POST" class="car-feature-form">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="feature">Feature Name</label>
                <input type="text" id="feature" name="feature" class="form-input" value="{{ old('feature', $feature->feature) }}" required>
                @error('feature')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Update Feature</button>
            <a href="{{ route('features.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
