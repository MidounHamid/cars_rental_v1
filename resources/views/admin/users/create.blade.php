@extends('admin.layouts.app')

@section('content')
    <div class="table-container">
        <h2>Add New User</h2>
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="agency-form">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}"
                        required>
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}"
                        required>
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
                    <input type="tel" id="phone" name="phone" class="form-input" value="{{ old('phone') }}"
                        required>
                    @error('phone')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" class="form-input" value="{{ old('address') }}"
                        required>
                    @error('address')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" class="form-input" min="18"
                        value="{{ old('age') }}" required>
                    @error('age')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <!-- CIN File Upload -->
                <div class="form-group">
                    <label for="cin">CIN Document</label>
                    <div class="file-upload">
                        <input type="file" id="cin" name="cin" class="file-input" accept=".jpg,.jpeg,.png,.pdf"
                            required>
                        <label for="cin" class="file-label">Upload CIN</label>
                        @error('cin')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- CIN Preview -->
                    <div class="logo-preview mt-2" style="text-align: center;">
                        <img id="cin-preview" src="" alt="CIN Preview"
                            style="display: none; max-height: 150px; border-radius: 10px; border: 2px solid #ccc; margin-top: 10px;">
                        <span id="no-cin-text">No CIN image</span>
                    </div>
                </div>

                <!-- Driver License Upload -->
                <div class="form-group">
                    <label for="driver_license">Driver License</label>
                    <div class="file-upload">
                        <input type="file" id="driver_license" name="driver_license" class="file-input"
                            accept=".jpg,.jpeg,.png,.pdf" required>
                        <label for="driver_license" class="file-label">Upload License</label>
                        @error('driver_license')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Driver License Preview -->
                    <div class="logo-preview mt-2" style="text-align: center;">
                        <img id="driver-license-preview" src="" alt="Driver License Preview"
                            style="display: none; max-height: 150px; border-radius: 10px; border: 2px solid #ccc; margin-top: 10px;">
                    </div>
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
                        <input type="checkbox" id="is_admin" name="is_admin" class="checkbox" value="1"
                            {{ old('is_admin') ? 'checked' : '' }}>
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Profile image preview
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('image-preview-img');

            // CIN document preview
            const cinInput = document.getElementById('cin');
            const cinPreview = document.getElementById('cin-preview');
            const noCinText = document.getElementById('no-cin-text');

            // Driver license preview
            const driverLicenseInput = document.getElementById('driver_license');
            const driverLicensePreview = document.getElementById('driver-license-preview');

            // Profile image handling
            if (imageInput) {
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
            }

            // CIN document handling
            if (cinInput) {
                cinInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (!file) return;

                    // For image files, show preview
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            cinPreview.src = event.target.result;
                            cinPreview.style.display = 'block';
                            if (noCinText) noCinText.style.display = 'none';
                        };
                        reader.readAsDataURL(file);
                    } else if (file.type === 'application/pdf') {
                        // For PDFs show an icon or text indicator
                        cinPreview.src =
                            'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzODQgNTEyIj48cGF0aCBmaWxsPSIjZmYwMDAwIiBkPSJNMzY1LjMgOTMuMzhsLTc0LjYzLTc0LjY0QzI4OC42IDYuNzQzIDI4Mi4zIDAgMjc1LjQgMEg2NEM0Ni4zMyAwIDMyIDE0LjMzIDMyIDMydjQ0OGMwIDE3LjY3IDE0LjMzIDMyIDMyIDMyaDI4OGMxNy42NyAwIDMyLTE0LjMzIDMyLTMyVjEzOC42QzM4NCAxMzEuNyAzNzcuMyAxMjUuNCAzNjUuMyA5My4zOHpNMzA4LjEgMTM4LjZ2LTYuMDI4aDYuMDI4VjEzOC42SDMwOC4xek0yODggMzJ2OTYuMDA4YzAgOC44MzggNy4xOTggMTYgMTYgMTZoOTZWMzJIMjg4ek0zNTIgNDgwSDY0VjMySDIyNFYxMzhuLjAwMGMwLTEzLjI1IDEwLjc1LTI0IDI0LTI0aDEwMHYxMDRjMCAxMy4yNSAxMC43NSAyNCAyNCAyNGgxMDRWMzg0YzAgMTMuMjUgMTAuNzUgMjQgMjQgMjR6TTI0MCAyNTZjMCA4LjgzOC03LjE5OCAxNi0xNiAxNkgxNjBjLTguODM4IDAtMTYtNy4xNjItMTYtMTZ2LTMyYzAtOC44MzggNy4xNjItMTYgMTYtMTZoNjRjOC44MDIgMCAxNiA3LjE2MiAxNiAxNlYyNTZ6TTI0MCAzMjBjMCA4LjgzOC03LjE5OCAxNi0xNiAxNkgxNjBjLTguODM4IDAtMTYtNy4xNjItMTYtMTZ2LTMyYzAtOC44MzggNy4xNjItMTYgMTYtMTZoNjRjOC44MDIgMCAxNiA3LjE2MiAxNiAxNlYzMjB6Ii8+PC9zdmc+';
                        cinPreview.style.display = 'block';
                        if (noCinText) noCinText.style.display = 'none';
                    }
                });
            }

            // Driver license handling
            if (driverLicenseInput) {
                driverLicenseInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (!file) return;

                    // For image files, show preview
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            driverLicensePreview.src = event.target.result;
                            driverLicensePreview.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    } else if (file.type === 'application/pdf') {
                        // For PDFs show an icon or text indicator
                        driverLicensePreview.src =
                            'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzODQgNTEyIj48cGF0aCBmaWxsPSIjZmYwMDAwIiBkPSJNMzY1LjMgOTMuMzhsLTc0LjYzLTc0LjY0QzI4OC42IDYuNzQzIDI4Mi4zIDAgMjc1LjQgMEg2NEM0Ni4zMyAwIDMyIDE0LjMzIDMyIDMydjQ0OGMwIDE3LjY3IDE0LjMzIDMyIDMyIDMyaDI4OGMxNy42NyAwIDMyLTE0LjMzIDMyLTMyVjEzOC42QzM4NCAxMzEuNyAzNzcuMyAxMjUuNCAzNjUuMyA5My4zOHpNMzA4LjEgMTM4LjZ2LTYuMDI4aDYuMDI4VjEzOC42SDMwOC4xek0yODggMzJ2OTYuMDA4YzAgOC44MzggNy4xOTggMTYgMTYgMTZoOTZWMzJIMjg4ek0zNTIgNDgwSDY0VjMySDIyNFYxMzhuLjAwMGMwLTEzLjI1IDEwLjc1LTI0IDI0LTI0aDEwMHYxMDRjMCAxMy4yNSAxMC43NSAyNCAyNCAyNGgxMDRWMzg0YzAgMTMuMjUgMTAuNzUgMjQgMjQgMjR6TTI0MCAyNTZjMCA4LjgzOC03LjE5OCAxNi0xNiAxNkgxNjBjLTguODM4IDAtMTYtNy4xNjItMTYtMTZ2LTMyYzAtOC44MzggNy4xNjItMTYgMTYtMTZoNjRjOC44MDIgMCAxNiA3LjE2MiAxNiAxNlYyNTZ6TTI0MCAzMjBjMCA4LjgzOC03LjE5OCAxNi0xNiAxNkgxNjBjLTguODM4IDAtMTYtNy4xNjItMTYtMTZ2LTMyYzAtOC44MzggNy4xNjItMTYgMTYtMTZoNjRjOC44MDIgMCAxNiA3LjE2MiAxNiAxNlYzMjB6Ii8+PC9zdmc+';
                        driverLicensePreview.style.display = 'block';
                    }
                });
            }
        });
    </script>
@endsection
