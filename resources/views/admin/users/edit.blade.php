@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <h2>Edit User</h2>

    <form action="{{ route('users.update', $user) }}" method="POST" class="agency-form" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-row">
            <!-- Name -->
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-input" required>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-input" required>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <!-- Password -->
            <div class="form-group">
                <label for="password">Password (Leave blank to keep current)</label>
                <input type="password" name="password" id="password" class="form-input">
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Phone -->
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="form-input" maxlength="15">
                @error('phone')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <!-- Image Upload -->
            <div class="form-group">
                <label for="image">Profile Image</label>
                <div class="file-upload">
                    <input type="file" name="image" id="image" class="file-input" accept="image/*">
                    <label for="image" class="file-label">Choose File</label>
                </div>
                @error('image')
                    <span class="error-message">{{ $message }}</span>
                @enderror

                @if($user->image)
                    <div class="logo-preview mt-2" >
                        <img src="{{ asset('storage/' . $user->image) }}" alt="Current Image">
                        <div class="form-check mt-2">
                            <input type="checkbox" name="remove_image" id="remove_image" class="checkbox">
                            <label for="remove_image">Remove current image</label>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Admin Checkbox -->
            <div class="form-group">
                <label class="checkbox-label" for="is_admin">Administrator</label>
                <div class="styled-checkbox">
                    <input type="hidden" name="is_admin" value="0">
                    <input type="checkbox" name="is_admin" id="is_admin" class="checkbox" value="1" {{ $user->is_admin ? 'checked' : '' }}>
                    <label for="is_admin" class="checkbox-text">Grant admin privileges</label>
                </div>
                @error('is_admin')
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
