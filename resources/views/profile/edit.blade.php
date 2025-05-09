<x-app-layout>
    @php
    $profileImage = Auth::user()?->image && trim(Auth::user()?->image) !== ''
        ? asset('storage/' . Auth::user()->image)
        : asset('images/default.png');
@endphp



    <!-- Ajout du lien vers Material Symbols -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        body {
            background-color: #f5f8fa;
            color: #333;
            line-height: 1.5;
        }

        .container {
            display: flex;
            max-width: 1200px;
            margin: 20px auto;
            min-height: calc(100vh - 40px);
        }

        /* Sidebar */
        .sidebar {
            width: 220px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-right: 20px;
        }

        .profile-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 8px;
            margin-right: 10px;
            margin-bottom: 15px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-info {
            width: 100%;
        }

        .profile-name {
            font-weight: 600;
            color: #333;
            font-size: 16px;
        }

        .profile-status {
            font-size: 12px;
            color: #888;
        }

        .menu-section {
            margin: 15px 0;
        }

        .menu-title {
            font-size: 12px;
            color: #888;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .menu-list {
            list-style: none;
        }

        .menu-item {
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .menu-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #333;
            font-size: 14px;
            padding: 5px 0;
        }

        .menu-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            margin-right: 10px;
        }

        .menu-icon .material-symbols-rounded {
            font-size: 20px;
            color: inherit;
        }

        .menu-item.active .menu-link {
            color: #e94f4f;
        }

        .menu-item.active .menu-icon {
            color: #e94f4f;
        }

        /* Main content */
        .main-content {
            flex: 1;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 20px;
        }

        .settings-title {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 20px;
            color: #333;
        }

        .settings-section {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #eee;
            border-radius: 8px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin: 0;
        }

        .form-label {
            display: block;
            font-size: 14px;
            margin-bottom: 8px;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-row .form-group {
            flex: 1;
            margin-bottom: 0;
        }

        .upload-section {
            display: flex;
            gap: 30px;
            margin-bottom: 30px;
        }

        .upload-preview {
            width: 200px;
            height: 200px;
            position: relative;
            border-radius: 8px;
            overflow: hidden;
        }

        .upload-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-form-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 200px;
            padding: 20px 0;
        }

        .upload-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .upload-hint {
            font-size: 12px;
            color: #888;
            margin-bottom: 5px;
        }

        .upload-formats {
            font-size: 12px;
            color: #888;
        }

        .edit-image-btn {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.3s;

        }

        .edit-image-btn:hover {
            background-color: #d43e3e;
            transform: translateY(-50%) scale(1.1);
        }

        .hidden-file-input {
            display: none;
        }

        .btn-group {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background-color: #e94f4f;
            color: white;
        }

        .btn-secondary {
            background-color: #e9ebee;
            color: #333;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 30px;
            gap: 10px;
            align-items: center;
        }

        .btn-cancel {
            background-color: #f5f5f5;
            color: #333;
        }

        .btn-save {
            background-color: #e94f4f;
            color: white;
        }

        .text-success {
            color: #28a745;
            margin-right: auto;
        }

        .text-danger {
            color: #dc3545;
        }

        .mt-2 {
            margin-top: 0.5rem;
        }

        .text-sm {
            font-size: 0.875rem;
        }

        .text-gray-600 {
            color: #666;
        }

        .password-field {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-field .form-control {
            padding-right: 40px;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            background: none;
            border: none;
            cursor: pointer;
            color: #666;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            margin: 0;
        }

        .toggle-password:hover {
            color: #333;
        }

        .toggle-password .material-symbols-rounded {
            font-size: 20px;
        }

        .form-input {
            width: 100%;
            padding: 10px 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            background: #f1f2f6;
            margin-bottom: 8px;
        }
        .file-upload {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
        }
        .file-input {
            display: none;
        }
        .file-label {
            display: block;
            background: #f1f2f6;
            color: #333;
            border-radius: 8px;
            padding: 12px 24px;
            cursor: pointer;
            font-weight: 500;
            margin-bottom: 8px;
            transition: background 0.2s;
            border: none;
            text-align: center;
            width: 100%;
        }
        .file-label:hover {
            background: #e2e6ea;
        }
        .logo-preview img {
            max-width: 100%;
            max-height: 150px;
            border-radius: 10px;
            border: 2px solid #ccc;
            margin-top: 10px;
        }
        .logo-preview span {
            display: block;
            color: #222;
            font-weight: 500;
            text-align: center;
            margin-top: 10px;
        }
    </style>

    <div class="container">
        <div class="sidebar">
            <div class="profile-header">
                <div class="profile-avatar">
                    <img src="{{ $profileImage }}" alt="Profile Image">
                </div>
                <div class="profile-info">
                    <div class="profile-name">{{ auth()->user()->name }}</div>
                    <div class="profile-status">Member since {{ auth()->user()->created_at->format('d M Y') }}</div>
                </div>
            </div>

            <div class="menu-section">
                <div class="menu-title">Main</div>
                <ul class="menu-list">
                    <li class="menu-item {{ request()->routeIs('profile.reservations') ? 'active' : '' }}">
                        <a href="{{ route('profile.reservations') }}" class="menu-link">
                            <span class="menu-icon">
                                <span class="material-symbols-rounded">calendar_month</span>
                            </span>
                            My Reservations
                        </a>
                    </li>
                </ul>
            </div>

            <div class="menu-section">
                <div class="menu-title">Account</div>
                <ul class="menu-list">
                    <li class="menu-item {{ request()->routeIs('profile.show') ? 'active' : '' }}">
                        <a href="{{ route('profile.show') }}" class="menu-link">
                            <span class="menu-icon">
                                <span class="material-symbols-rounded">person</span>
                            </span>
                            My Profile
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                        <a href="{{ route('profile.edit') }}" class="menu-link">
                            <span class="menu-icon">
                                <span class="material-symbols-rounded">settings</span>
                            </span>
                            Settings
                        </a>
                    </li>
                    <li class="menu-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" class="menu-link"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <span class="menu-icon">
                                    <span class="material-symbols-rounded">logout</span>
                                </span>
                                Logout
                            </a>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <h1 class="settings-title">Settings</h1>

                <div class="settings-section">
                    <h2 class="section-title">Basic Information</h2>

                    <div class="upload-section">
                        <div class="upload-preview">
                            <img src="{{ $profileImage }}" alt="Avatar">
                            <label for="image" class="edit-image-btn">
                                <span class="material-symbols-rounded">edit</span>
                            </label>
                            <input type="file" name="image" id="image" class="hidden-file-input" accept="image/*" onchange="previewImage(this)">
                        </div>

                        <div class="profile-form-section">
                            <div class="form-group">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="form-control" required>
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div class="form-group">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="form-control">
                                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-control" required>
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div class="form-group">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" value="{{ old('address', auth()->user()->address) }}" class="form-control" required>
                        <x-input-error class="mt-2" :messages="$errors->get('address')" />
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="age">Age</label>
                        <input type="number" name="age" id="age" value="{{ old('age', auth()->user()->age) }}" class="form-input" min="18" required>
                        <x-input-error class="mt-2" :messages="$errors->get('age')" />
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="cin">CIN Document</label>
                        <div class="file-upload">
                            <input type="file" name="cin" id="cin" class="file-input" accept=".pdf,.jpg,.jpeg,.png">
                            <label for="cin" class="file-label">Upload CIN</label>
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('cin')" />
                        <div class="logo-preview mt-2" style="text-align: center;">
                            @if(auth()->user()->cin)
                                <img id="cin-preview" src="{{ asset('storage/' . auth()->user()->cin) }}" style="max-height: 150px; border-radius: 10px; border: 2px solid #ccc; margin-top: 10px;" alt="CIN Preview">
                            @else
                                <img id="cin-preview" style="display: none; max-height: 150px; border-radius: 10px; border: 2px solid #ccc; margin-top: 10px;" alt="CIN Preview">
                                <span id="no-cin-text">No CIN image</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="driver_license">Driver License</label>
                        <div class="file-upload">
                            <input type="file" name="driver_license" id="driver_license" class="file-input" accept=".pdf,.jpg,.jpeg,.png">
                            <label for="driver_license" class="file-label">Upload License</label>
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('driver_license')" />
                        <div class="logo-preview mt-2" style="text-align: center;">
                            @if(auth()->user()->driver_license)
                                <img id="driver-license-preview" src="{{ asset('storage/' . auth()->user()->driver_license) }}" style="max-height: 150px; border-radius: 10px; border: 2px solid #ccc; margin-top: 10px;" alt="Driver License Preview">
                            @else
                                <img id="driver-license-preview" style="display: none; max-height: 150px; border-radius: 10px; border: 2px solid #ccc; margin-top: 10px;" alt="Driver License Preview">
                                <span id="no-driver-license-text">No License image</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="settings-section">
                    <h2 class="section-title">Password</h2>
                    <div class="form-group">
                        <label class="form-label">Current Password</label>
                        <div class="password-field">
                            <input type="password" name="current_password" class="form-control">
                            <button type="button" class="toggle-password" onclick="togglePassword(this)">
                                <span class="material-symbols-rounded">visibility</span>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                    </div>
                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <div class="password-field">
                            <input type="password" name="password" class="form-control">
                            <button type="button" class="toggle-password" onclick="togglePassword(this)">
                                <span class="material-symbols-rounded">visibility</span>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <div class="password-field">
                            <input type="password" name="password_confirmation" class="form-control">
                            <button type="button" class="toggle-password" onclick="togglePassword(this)">
                                <span class="material-symbols-rounded">visibility</span>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                <div class="form-actions">
                    @if (session('status') === 'profile-updated')
                        <p class="text-success">Profile updated successfully.</p>
                    @endif
                    <a href="{{ route('dashboard') }}" class="btn btn-cancel">Cancel</a>
                    <button type="submit" class="btn btn-save">Save</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
    function togglePassword(button) {
        const input = button.parentElement.querySelector('input');
        const icon = button.querySelector('.material-symbols-rounded');

        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = 'visibility_off';
        } else {
            input.type = 'password';
            icon.textContent = 'visibility';
        }
    }

    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        // CIN document preview
        const cinInput = document.getElementById('cin');
        const cinPreview = document.getElementById('cin-preview');
        const noCinText = document.getElementById('no-cin-text');

        if (cinInput) {
            cinInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        cinPreview.src = event.target.result;
                        cinPreview.style.display = 'block';
                        if (noCinText) noCinText.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                } else if (file.type === 'application/pdf') {
                    cinPreview.src = '/images/pdf-icon.png'; // Remplacez par le chemin de votre icône PDF
                    cinPreview.style.display = 'block';
                    if (noCinText) noCinText.style.display = 'none';
                }
            });
        }

        // Driver license preview
        const driverLicenseInput = document.getElementById('driver_license');
        const driverLicensePreview = document.getElementById('driver-license-preview');
        const noDriverLicenseText = document.getElementById('no-driver-license-text');

        if (driverLicenseInput) {
            driverLicenseInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        driverLicensePreview.src = event.target.result;
                        driverLicensePreview.style.display = 'block';
                        if (noDriverLicenseText) noDriverLicenseText.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                } else if (file.type === 'application/pdf') {
                    driverLicensePreview.src = '/images/pdf-icon.png'; // Remplacez par le chemin de votre icône PDF
                    driverLicensePreview.style.display = 'block';
                    if (noDriverLicenseText) noDriverLicenseText.style.display = 'none';
                }
            });
        }
    });
</script>
