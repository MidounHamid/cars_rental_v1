@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Add New User</h2>
    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="agency-form">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-input" required>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone_number" class="form-input" value="{{ old('phone_number') }}">
                @error('phone')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="image">Profile Image</label>
                <div class="file-upload">
                    <input type="file" id="image" name="image" class="file-input" accept="image/*">
                    <label for="image" class="file-label">Choose File</label>
                    @error('image')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Image Preview -->
                <div class="logo-preview mt-2" style="text-align: center;">
                    <img id="image-preview-img" src="" alt="Image Preview"
                         style="display: none; max-height: 150px; border-radius: 10px; border: 2px solid #ccc; margin-top: 10px;">
                </div>
            </div>

            <div class="form-group">
                <label class="checkbox-label" for="is_admin">Administrator</label>
                <div class="styled-checkbox">
                    <input type="hidden" name="is_admin" value="0">
                    <input type="checkbox" id="is_admin" name="is_admin" class="checkbox" value="1" {{ old('is_admin') ? 'checked' : '' }}>
                    <label for="is_admin" class="checkbox-text">Make this user an administrator</label>
                </div>
                @error('is_admin')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Create User</button>
            <a href="{{ route('users.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview-img');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file || !file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = function(event) {
            imagePreview.src = event.target.result;
            imagePreview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endsection
