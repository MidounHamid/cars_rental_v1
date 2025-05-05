@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Edit Specification</h2>

    <form action="{{ route('specifications.update', $specification->id) }}" method="POST" class="car-feature-form">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="name">Specification Name</label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $specification->name) }}" placeholder="Enter specification name">
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Price </label>
                <input type="number" step="0.01" id="price" name="price" class="form-input" value="{{ old('price', $specification->price) }}" placeholder="Enter price">
                @error('price')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Update Specification</button>
            <a href="{{ route('specifications.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
