@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Add New Brand</h2>

    <form action="{{ route('brands.store') }}" method="POST" class="brand-form">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="brand">Brand Name</label>
                <input type="text" id="brand" name="brand" class="form-input" value="{{ old('brand') }}" placeholder="Enter brand name">
                @error('brand')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Add Brand</button>
            <a href="{{ route('brands.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
