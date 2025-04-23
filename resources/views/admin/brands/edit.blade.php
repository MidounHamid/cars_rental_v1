@extends('admin.layouts.app')

@section('content')
<div class="form-container">
    <h2>Edit Brand</h2>

    <form action="{{ route('brands.update', $brand->id) }}" method="POST" class="brand-form" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Brand Name</label>
            <input type="text" id="name" name="name" class="form-input"
                   value="{{ old('name', $brand->name) }}"
                   placeholder="Enter brand name">
            @error('name')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Update Brand</button>
            <a href="{{ route('brands.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
