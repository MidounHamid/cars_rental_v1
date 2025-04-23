@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Add New Agency</h2>
    <form action="{{ route('agencies.store') }}" method="POST" enctype="multipart/form-data" class="agency-form">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="name">Agency Name</label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}">
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="city">City</label>
                <input type="text" id="city" name="city" class="form-input" value="{{ old('city') }}">
                @error('city')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" class="form-input" rows="3">{{ old('address') }}</textarea>
                @error('address')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="tel" id="phone" name="phone" class="form-input" value="{{ old('phone') }}">
                @error('phone')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="logo">Logo</label>
                <div class="file-upload">
                    <input type="file" id="logo" name="logo" class="file-input" accept="image/*">
                    <label for="logo" class="file-label">Choose File</label>
                    @error('logo')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="logo-preview mt-2">
                    <img id="logo-preview-img" src="#" alt="Logo Preview" style="display: none; max-height: 150px;">
                </div>
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Create Agency</button>
            <a href="{{ route('agencies.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>

{{-- JavaScript pour prévisualiser le logo --}}
<script>
    document.getElementById('logo').addEventListener('change', function (event) {
        const file = event.target.files[0];
        const preview = document.getElementById('logo-preview-img');

        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
            preview.src = '#';
        }
    });
</script>
@endsection
