@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Add New Feature</h2>

    <form action="{{ route('features.store') }}" method="POST" class="car-feature-form">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="feature">Feature Name</label>
                <input type="text" id="feature" name="feature" class="form-input" value="{{ old('feature') }}" placeholder="Enter feature name">
                @error('feature')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Add Feature</button>
            <a href="{{ route('features.index') }}" class="cancel-btn">Cancel</a>
        </div>

    </form>
</div>
@endsection
