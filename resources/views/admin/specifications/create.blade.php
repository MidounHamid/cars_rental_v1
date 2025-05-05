@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Add New Specification</h2>

    <form action="{{ route('specifications.store') }}" method="POST" class="car-feature-form">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="name">Specification Name</label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" placeholder="Enter specification name">
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Price </label>
                <input type="number" step="0.01" id="price" name="price" class="form-input" value="{{ old('price') }}" placeholder="Enter price">
                @error('price')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Add Specification</button>
            <a href="{{ route('specifications.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
