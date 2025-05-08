@php
    $profileImage = Auth::user()->image && trim(Auth::user()->image) !== ''
        ? asset('storage/' . Auth::user()->image)
        : asset('images/default.png');
    $userName = Auth::user()->name ?? 'John Doe';
@endphp

<nav class="navbar">
    <div class="nav-left">
        <div class="search-box">
            <span class="material-symbols-rounded">search</span>
            <input type="text" placeholder="Search...">
        </div>
    </div>
    <div class="nav-right">
        <livewire:admin.notification-dropdown />

        <div class="profile-menu">
            <button class="profile-trigger">
                <img src="{{ $profileImage }}" alt="Profile" class="profile-img">
                <span>{{ $userName }}</span>
                <span class="material-symbols-rounded">expand_more</span>
            </button>
            <div class="profile-dropdown">
                <div class="dropdown-header">
                    <img src="{{ $profileImage }}" alt="Profile" class="profile-img-large">
                    <div class="profile-info">
                        <h4>{{ $userName }}</h4>
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
                </div>
                <div class="dropdown-footer">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <span class="material-symbols-rounded">logout</span>
                            <span>{{ __('Sign out') }}</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

@push('styles')
<style>
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .nav-left {
        flex: 1;
        max-width: 400px;
    }

    .search-box {
        display: flex;
        align-items: center;
        background: #f5f5f5;
        border-radius: 8px;
        padding: 0.5rem 1rem;
    }

    .search-box input {
        border: none;
        background: none;
        margin-left: 0.5rem;
        width: 100%;
        outline: none;
    }

    .nav-right {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .profile-menu {
        position: relative;
    }

    .profile-trigger {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: none;
        border: none;
        padding: 0.5rem;
        cursor: pointer;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }

    .profile-trigger:hover {
        background-color: #f5f5f5;
    }

    .profile-img {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
    }

    .profile-dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        width: 280px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        margin-top: 8px;
        display: none;
        z-index: 1000;
    }

    .profile-menu:hover .profile-dropdown {
        display: block;
    }

    .dropdown-header {
        padding: 1rem;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .profile-img-large {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
    }

    .profile-info h4 {
        margin: 0;
        font-size: 1rem;
        color: #333;
    }

    .profile-info p {
        margin: 0.25rem 0 0;
        font-size: 0.875rem;
        color: #666;
    }

    .dropdown-body {
        padding: 0.5rem 0;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        color: #333;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .dropdown-item:hover {
        background-color: #f5f5f5;
    }

    .dropdown-item.text-danger {
        color: #dc3545;
    }

    .dropdown-footer {
        padding: 0.5rem 0;
        border-top: 1px solid #eee;
    }

    .dropdown-footer .dropdown-item {
        width: 100%;
        text-align: left;
        background: none;
        border: none;
        cursor: pointer;
    }
</style>
@endpush
