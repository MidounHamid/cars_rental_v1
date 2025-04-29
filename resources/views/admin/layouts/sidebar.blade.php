@php
    $profileImage = Auth::user()->image && trim(Auth::user()->image) !== ''
        ? asset('storage/' . Auth::user()->image)
        : asset('images/default.png');
@endphp

<aside class="sidebar">
    <header class="sidebar-header">
        <a href="#" class="header-logo">
            <img src="{{ asset('images/car_rental.png') }}" alt="Company Logo">
        </a>
        <div class="mobile-actions">
            <div class="mobile-profile">
                <button class="nav-link profile-link">
                    <img src="{{ $profileImage }}" alt="User Image" class="nav-icon profile-icon">
                </button>
                <div class="mobile-dropdown">
                    <div class="dropdown-header">
                        <img src="{{ $profileImage }}" alt="User Image" class="profile-img-large">
                        <div class="profile-info">
                            <h4>{{ Auth::user()->name }}</h4>
                            <p>Administrator</p>
                        </div>
                    </div>
                    <div class="dropdown-body">
                        <a href="#" class="dropdown-item">
                            <span class="material-symbols-rounded">person</span>
                            <span>My Profile</span>
                        </a>
                        <a href="#" class="dropdown-item">
                            <span class="material-symbols-rounded">settings</span>
                            <span>Settings</span>
                        </a>
                        <a href="#" class="dropdown-item">
                            <span class="material-symbols-rounded">mail</span>
                            <span>Messages</span>
                        </a>
                        <!-- Logout inside mobile dropdown -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item logout-button">
                                <span class="material-symbols-rounded">logout</span>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <button class="mobile-menu-button" aria-label="Toggle mobile menu">
                <span class="material-symbols-rounded">menu</span>
            </button>
        </div>
        <button class="toggler sidebar-toggler" aria-label="Collapse sidebar">
            <span class="material-symbols-rounded">chevron_left</span>
        </button>
    </header>

    <nav class="sidebar-nav">
        <div class="nav-content">
            {{-- <ul class="nav-list primary-nav">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon material-symbols-rounded">dashboard</span>
                        <span class="nav-label">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon material-symbols-rounded">calendar_month</span>
                        <span class="nav-label">Calendar</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon material-symbols-rounded">notifications</span>
                        <span class="nav-label">Notifications</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon material-symbols-rounded">group</span>
                        <span class="nav-label">Team</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon material-symbols-rounded">analytics</span>
                        <span class="nav-label">Analytics</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon material-symbols-rounded">bookmark</span>
                        <span class="nav-label">Bookmarks</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon material-symbols-rounded">settings</span>
                        <span class="nav-label">Settings</span>
                    </a>
                </li>
            </ul> --}}
            <ul class="nav-list primary-nav">
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <span class="nav-icon material-symbols-rounded">people</span>
                        <span class="nav-label">Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('agencies.index')}}" class="nav-link">
                        <span class="nav-icon material-symbols-rounded">apartment</span>
                        <span class="nav-label">Agencies</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('bookings.index')}}" class="nav-link">
                        <span class="nav-icon material-symbols-rounded">event_available</span>
                        <span class="nav-label">Booking</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('brands.index')}}" class="nav-link">
                        <span class="nav-icon material-symbols-rounded">sell</span>
                        <span class="nav-label">Brands</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('car_images.index')}}" class="nav-link">
                        <span class="nav-icon material-symbols-rounded">directions_car</span>
                        <span class="nav-label">Car Image</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('car_spefications.index')}}" class="nav-link">
                        <span class="nav-icon material-symbols-rounded">tune</span>
                        <span class="nav-label">Car Specification</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('car_types.index')}}" class="nav-link">
                        <span class="nav-icon material-symbols-rounded">category</span>
                        <span class="nav-label">Car Type</span>

                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('cars.index')}}" class="nav-link">
                        <span class="nav-icon material-symbols-rounded">directions_car</span>
                        <span class="nav-label">Car</span>

                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('fuel_types.index')}}" class="nav-link">
                        <span class="nav-icon material-symbols-rounded">local_gas_station</span>
                        <span class="nav-label">Fuel Type</span>

                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('insurances.index')}}" class="nav-link">
                        <span class="nav-icon material-symbols-rounded">verified_user</span>
                        <span class="nav-label">Insurance</span>

                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('mode_payments.index')}}" class="nav-link">
                        <span class="nav-icon material-symbols-rounded">account_balance_wallet</span>
                        <span class="nav-label">Mode Payement</span>

                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('payments.index')}}" class="nav-link">
                        <span class="nav-icon material-symbols-rounded">payments</span>
                        <span class="nav-label">Payement</span>

                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('promotions.index')}}" class="nav-link">
                        <span class="nav-icon material-symbols-rounded">campaign</span>
                        <span class="nav-label">promotions</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('reviews.index')}}" class="nav-link">
                        <span class="nav-icon material-symbols-rounded">rate_review</span>
                        <span class="nav-label">Reviews</span>

                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('specifications.index')}}" class="nav-link">
                        <span class="nav-icon material-symbols-rounded">list_alt</span>
                        <span class="nav-label">Specifications</span>

                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('locations.index')}}" class="nav-link">
                        <span class="nav-icon material-symbols-rounded">list_alt</span>
                        <span class="nav-label">Locations</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('car_delivery_locations.index')}}" class="nav-link">
                        <span class="nav-icon material-symbols-rounded">list_alt</span>
                        <span class="nav-label">Car delivery locations</span>
                    </a>
                </li>
            </ul>

            {{-- <ul class="nav-list secondary-nav">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <img src="{{ $profileImage }}" alt="User Image" class="nav-icon profile-icon">
                        <span class="nav-label">Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link logout-button">
                            <span class="nav-icon material-symbols-rounded">logout</span>
                            <span class="nav-label">Logout</span>
                        </button>
                    </form>
                </li>
            </ul> --}}
        </div>
    </nav>
</aside>
