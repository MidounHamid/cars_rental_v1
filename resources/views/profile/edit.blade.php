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
            transition: background-color 0.3s;
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
    </style>

    <div class="container">
        <div class="sidebar">
            <div class="profile-header">
                <div class="profile-avatar">
                    <img  src="{{ $profileImage }}" alt="Profile Image" style="width: 120px; height: 120px; border-radius: 8px; object-fit: cover;">
                </div>
                <div class="profile-info">
                    <div class="profile-name">{{ auth()->user()->name }}</div>
                    <div class="profile-status">Member since {{ auth()->user()->created_at->format('d M Y') }}</div>
                </div>
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
                        <label class="form-label">Driver's License</label>
                        <input type="file" name="driver_license" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                        <x-input-error class="mt-2" :messages="$errors->get('driver_license')" />
                        @if(auth()->user()->driver_license)
                            <p class="mt-2 text-sm text-gray-600">Current file: {{ basename(auth()->user()->driver_license) }}</p>
                        @endif
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
</script>
