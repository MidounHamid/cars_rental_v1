<x-app-layout>
    @php
    $profileImage = Auth::user()?->image && trim(Auth::user()?->image) !== ''
        ? asset('storage/' . Auth::user()->image)
        : asset('images/default.png');
    @endphp

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

        .reservations-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .reservations-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
        }

        .reservation-card {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .reservation-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }

        .reservation-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .reservation-id {
            font-weight: 600;
            color: #333;
        }

        .reservation-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-active {
            background-color: #e3f2fd;
            color: #2196f3;
        }

        .status-completed {
            background-color: #e8f5e9;
            color: #4caf50;
        }

        .status-cancelled {
            background-color: #ffebee;
            color: #f44336;
        }

        .reservation-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 15px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
        }

        .detail-label {
            font-size: 12px;
            color: #888;
            margin-bottom: 4px;
        }

        .detail-value {
            font-weight: 500;
            color: #333;
        }

        .reservation-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .action-button {
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }

        .view-button {
            background-color: #f5f5f5;
            color: #333;
        }

        .view-button:hover {
            background-color: #e0e0e0;
        }

        .cancel-button {
            background-color: #ffebee;
            color: #f44336;
        }

        .cancel-button:hover {
            background-color: #ffcdd2;
        }
    </style>

    <div class="container">
        <!-- Sidebar -->
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
                            My bookings
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
            <div class="reservations-header">
                <h1 class="reservations-title">My bookings</h1>
            </div>

            @forelse($reservations as $reservation)
                <div class="reservation-card" style="display: flex; flex-direction: column; gap: 20px;">
                    <div style="display: flex; flex-direction: row; gap: 24px; align-items: flex-start; flex-wrap;">
                        <!-- Car Image -->
                        <div style="min-width: 180px; max-width: 220px; flex: 1; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 8px; height: 140px; overflow: hidden;">
                            @if(isset($reservation->car->image) && $reservation->car->image)
                                <img src="{{ asset('storage/' . $reservation->car->image) }}" alt="Car Image" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <span style="color: #bbb; font-size: 1.1em;">No Image</span>
                            @endif
                        </div>
                        <!-- Car Info & Reservation Details -->
                        <div style="flex: 3; display: flex; flex-direction: column; gap: 8px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                {{-- <span style="font-size: 1.2em; font-weight: 600; text-transform: uppercase;">{{ strtoupper($reservation->car->brand ?? '') }} {{ strtoupper($reservation->car->model ?? '') }}</span>
                                @if(isset($reservation->car->status) && $reservation->car->status === 'available')
                                    <span style="background: #e8f5e9; color: #43a047; font-size: 0.85em; border-radius: 12px; padding: 2px 10px; font-weight: 500;">AVAILABLE</span>
                                @endif --}}
                            </div>
                            <div style="display: flex; flex-wrap: wrap; gap: 18px; font-size: 0.98em; color: #555;">
                                <span><b>Type:</b> {{ $reservation->car->model ?? '-' }}</span>
                                <span><b>Seats:</b> {{ $reservation->car->seats ?? '-' }}</span>
                                <span><b>Transmission:</b> {{ $reservation->car->transmission ?? '-' }}</span>
                                <span><b>Fuel:</b> {{ $reservation->car->fuelType->fuel_type ?? '-' }}</span>
                            </div>
                            <div style="display: flex; flex-wrap: wrap; gap: 18px; font-size: 0.98em; color: #555;">
                                <span><b>Pickup:</b> {{ $reservation->start_date ? $reservation->start_date->format('d M Y, H:i') : '-' }}</span>
                                <span><b>Return:</b> {{ $reservation->end_date ? $reservation->end_date->format('d M Y, H:i') : '-' }}</span>
                                <span><b>Status:</b> <span class="reservation-status status-{{ strtolower($reservation->status) }}">{{ ucfirst($reservation->status) }}</span></span>
                            </div>
                            <div style="margin-top: 8px; font-size: 1.1em; color: #222; font-weight: 500;">
                                <span>Total: ${{ number_format($reservation->total_price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <p class="text-gray-500">You haven't made any reservations yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout> 