@extends('admin.layouts.app')

@section('content')
<div class="form-container">
    <h2>Add new brand</h2>

    <form action="{{ route('brands.store') }}" method="POST" class="brand-form">
        @csrf

        <div class="form-group">
            <label for="brand">brand name</label>
            <input type="text" id="brand" name="brand" class="form-input" value="{{ old('brand') }}" placeholder="Entrez le nom de la marque">
            @error('brand')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Add brand</button>
            <a href="{{ route('brands.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
