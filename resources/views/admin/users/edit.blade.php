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
                    <input type="text" name="name" id="name" class="form-input"
                        value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-input"
                        value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password <small>(leave blank to keep current)</small></label>
                    <input type="password" name="password" id="password" class="form-input">
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" name="phone" id="phone" class="form-input"
                        value="{{ old('phone', $user->phone) }}" required>
                    @error('phone')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" class="form-input"
                        value="{{ old('address', $user->address) }}">
                    @error('address')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" class="form-input" min="18"
                        value="{{ old('age', $user->age) }}">
                    @error('age')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="driver_license">Driver License Image</label>
                    <div class="file-upload">
                        <input type="file" name="driver_license" id="driver_license" class="file-input"
                            accept="image/*,.pdf">
                        <label for="driver_license" class="file-label">Choose File</label>
                    </div>
                    @error('driver_license')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                    <div class="logo-preview mt-2" style="text-align: center;">
                        <img id="driver-license-preview"
                            src="{{ $user->driver_license ? asset('storage/' . $user->driver_license) : '' }}"
                            style="{{ $user->driver_license ? '' : 'display: none;' }} max-height: 150px; border-radius: 10px; border: 2px solid #ccc; margin-top: 10px;"
                            alt="Driver License Preview">
                    </div>

                    @if ($user->driver_license)
                        <div class="form-check mt-2">
                            <input type="checkbox" name="remove_driver_license" id="remove_driver_license" class="checkbox">
                            <label for="remove_driver_license">Remove current driver license image</label>
                        </div>
                    @endif
                </div>

                <!-- CIN Document -->
                <div class="form-group">
                    <label for="cin">CIN Document</label>
                    <div class="file-upload">
                        <input type="file" name="cin" id="cin" class="file-input" accept="image/*,.pdf">
                        <label for="cin" class="file-label">Upload CIN</label>
                    </div>
                    @error('cin')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                    <!-- CIN Preview -->
                    <div class="logo-preview mt-2" style="text-align: center;">
                        @if ($user->cin)
                            <img id="cin-preview" src="{{ asset('storage/' . $user->cin) }}"
                                style="max-height: 150px; border-radius: 10px; border: 2px solid #ccc; margin-top: 10px;"
                                alt="CIN Preview">
                        @else
                            <img id="cin-preview"
                                style="display: none; max-height: 150px; border-radius: 10px; border: 2px solid #ccc; margin-top: 10px;"
                                alt="CIN Preview">
                            <span id="no-cin-text">No CIN image</span>
                        @endif
                    </div>

                    @if ($user->cin)
                        <div class="form-check mt-2">
                            <input type="checkbox" name="remove_cin" id="remove_cin" class="checkbox">
                            <label for="remove_cin">Remove current CIN image</label>
                        </div>
                    @endif
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
                        <img id="image-preview-img" src="{{ $user->image ? asset('storage/' . $user->image) : '' }}"
                            alt="Image Preview"
                            style="{{ $user->image ? '' : 'display: none;' }} max-height: 150px; border-radius: 10px; border: 2px solid #ccc; margin-top: 10px;">
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
                        <input type="checkbox" id="is_admin" name="is_admin" class="checkbox" value="1"
                            {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
                        <label for="is_admin" class="checkbox-text">Make this user an administrator</label>
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

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Profile image preview
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('image-preview-img');
            const removeImageCheckbox = document.getElementById('remove_image');

            // CIN document preview
            const cinInput = document.getElementById('cin');
            const cinPreview = document.getElementById('cin-preview');
            const noCinText = document.getElementById('no-cin-text');
            const removeCinCheckbox = document.getElementById('remove_cin');

            // Driver license preview
            const driverLicenseInput = document.getElementById('driver_license');
            const driverLicensePreview = document.getElementById('driver-license-preview');
            const removeDriverLicenseCheckbox = document.getElementById('remove_driver_license');

            // Profile image handling
            if (imageInput) {
                imageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (!file || !file.type.startsWith('image/')) return;

                    const reader = new FileReader();
                    reader.onload = function(event) {
                        imagePreview.src = event.target.result;
                        imagePreview.style.display = 'block';

                        // Uncheck the remove checkbox if a new image is selected
                        if (removeImageCheckbox) removeImageCheckbox.checked = false;
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

                            // Uncheck the remove checkbox if a new file is selected
                            if (removeCinCheckbox) removeCinCheckbox.checked = false;
                        };
                        reader.readAsDataURL(file);
                    } else if (file.type === 'application/pdf') {
                        // For PDFs show an icon or text indicator
                        cinPreview.src = '/images/pdf-icon.png'; // Replace with your PDF icon path
                        cinPreview.style.display = 'block';
                        if (noCinText) noCinText.style.display = 'none';

                        // Uncheck the remove checkbox if a new file is selected
                        if (removeCinCheckbox) removeCinCheckbox.checked = false;
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

                            // Uncheck the remove checkbox if a new file is selected
                            if (removeDriverLicenseCheckbox) removeDriverLicenseCheckbox.checked =
                                false;
                        };
                        reader.readAsDataURL(file);
                    } else if (file.type === 'application/pdf') {
                        // For PDFs show an icon or text indicator
                        driverLicensePreview.src =
                            '/images/pdf-icon.png'; // Replace with your PDF icon path
                        driverLicensePreview.style.display = 'block';

                        // Uncheck the remove checkbox if a new file is selected
                        if (removeDriverLicenseCheckbox) removeDriverLicenseCheckbox.checked = false;
                    }
                });
            }
        });
    </script>
@endsection
