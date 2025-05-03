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
            padding: 0 20px;
        }

        /* Sidebar */
        .sidebar {
            width: 220px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-right: 20px;
            height: fit-content;
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
            margin-bottom: 15px;
            overflow: hidden;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
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
        }

        .menu-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #333;
            font-size: 14px;
            padding: 8px;
            border-radius: 4px;
            transition: all 0.3s ease;
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
            background-color: #fff1f1;
            color: #e94f4f;
        }

        /* Main content */
        .main-content {
            flex: 1;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 20px;
        }

        .profile-content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .profile-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
        }

        .edit-button {
            display: flex;
            align-items: center;
            padding: 8px 16px;
            background-color: #e94f4f;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .edit-button:hover {
            background-color: #d43e3e;
        }

        .edit-button .material-symbols-rounded {
            margin-right: 8px;
            font-size: 20px;
        }

        .profile-section {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .section-title {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .btn-edit {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            background-color: #e94f4f;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 13px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-edit:hover {
            background-color: #d43e3e;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .profile-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
        }

        .info-label {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .info-value {
            font-size: 16px;
            color: #333;
            font-weight: 500;
        }

        .info-value.empty {
            color: #999;
            font-style: italic;
        }

        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 8px;
            object-fit: cover;
            margin-bottom: 20px;
        }

        .info-group {
            margin-bottom: 20px;
        }

        .info-group label {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .info-group p {
            font-size: 16px;
            color: #333;
            font-weight: 500;
        }

        .profile-actions {
            margin-top: 20px;
        }
    </style>

    <div class="container">
        <div class="sidebar">
            <div class="profile-header">
                <div class="profile-avatar">
                    <img src="{{ $profileImage }}" alt="Profile Image" style="width: 120px; height: 120px; border-radius: 8px; object-fit: cover;">
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
            <h1 class="profile-title">My Profile</h1>

            <div class="profile-section">
                <h2 class="section-title">
                    Basic Information
                    <a href="{{ route('profile.edit') }}" class="btn-edit">Edit Profile</a>
                </h2>

                <div class="info-grid">
                    <div class="info-group">
                        <label>Full Name</label>
                        <p>{{ auth()->user()->name }}</p>
                    </div>

                    <div class="info-group">
                        <label>Email</label>
                        <p>{{ auth()->user()->email }}</p>
                    </div>

                    <div class="info-group">
                        <label>Phone Number</label>
                        <p>{{ auth()->user()->phone }}</p>
                    </div>

                    <div class="info-group">
                        <label>Address</label>
                        <p>{{ auth()->user()->address }}</p>
                    </div>

                    <div class="info-group">
                        <label>Driver's License</label>
                        @if(auth()->user()->driver_license)
                            <p>{{ basename(auth()->user()->driver_license) }}</p>
                        @else
                            <p>Not provided</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
