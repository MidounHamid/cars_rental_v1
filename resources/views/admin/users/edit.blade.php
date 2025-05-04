@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Edit User</h2>

    <form action="{{ route('users.update', $user) }}" method="POST" class="agency-form" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="password">Password (leave blank to keep)</label>
                <input type="password" name="password" id="password" class="form-input">
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone_number" class="form-input" value="{{ old('phone_number', $user->phone_number) }}">
                @error('phone_number')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="image">Profile Image</label>
                <div class="file-upload">
                    <input type="file" name="image" id="image" class="file-input" accept="image/*">
                    <label for="image" class="file-label">Choose File</label>
                </div>
                @error('image')
                    <span class="error-message">{{ $message }}</span>
                @enderror

                <div class="logo-preview mt-2" style="text-align: center;">
                    <img id="image-preview-img"
                         src="{{ $user->image ? asset('storage/' . $user->image) : '' }}"
                         style="{{ $user->image ? '' : 'display: none;' }} max-height: 150px; border-radius: 10px; border: 2px solid #ccc; margin-top: 10px;"
                         alt="Image Preview">
                </div>

                @if ($user->image)
                    <div class="form-check mt-2">
                        <input type="checkbox" name="remove_image" id="remove_image" class="checkbox">
                        <label for="remove_image">Remove current image</label>
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label class="checkbox-label" for="is_admin">Administrator</label>
                <div class="styled-checkbox">
                    <input type="hidden" name="is_admin" value="0">
                    <input type="checkbox" id="is_admin" name="is_admin" class="checkbox" value="1" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
                    <label for="is_admin" class="checkbox-text">Make this user an administrator</label>
                </div>
                @error('is_admin')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" class="form-input" value="{{ old('address', $user->address) }}">
                @error('address')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="driver_license">Driver License</label>
                <input type="text" id="driver_license" name="driver_license" class="form-input" value="{{ old('driver_license', $user->driver_license) }}">
                @error('driver_license')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="add-btn">Update User</button>
            <a href="{{ route('users.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>
@endsection


