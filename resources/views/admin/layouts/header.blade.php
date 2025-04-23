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
        <button class="nav-btn">
            <span class="material-symbols-rounded">notifications</span>
            <span class="badge">3</span>
        </button>

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
