@php
    $profileImage = Auth::user()?->image && trim(Auth::user()?->image) !== ''
        ? asset('storage/' . Auth::user()->image)
        : asset('images/default.png');
@endphp

<nav class="navbar">
    <h2 class="logo">Logo</h2>

    <input type="text" id="search-box" class="search-input" placeholder="Search...">

    @auth
    <div class="mobile-profile">
        <button type="button" class="mobile-profile-trigger">
            <img src="{{ $profileImage }}" alt="Profile" class="profile-img">
            <span class="profile-name">{{ Auth::user()->name }}</span>
        </button>
        <div class="mobile-profile-dropdown">
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
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item text-danger">
                    <span class="material-symbols-rounded">logout</span>
                    <span>Sign out</span>
                </button>
            </form>
        </div>
    </div>
    @endauth

    <input type="checkbox" id="menu-toggle" class="menu-toggle">
    <label for="menu-toggle" class="hamburger">
        <span></span>
        <span></span>
        <span></span>
    </label>

    <ul class="navbar-links">
        <li class="navbar-item"><a href="#" class="navbar-link">Home</a></li>
        <li class="navbar-item"><a href="#" class="navbar-link">Browse Car</a></li>
        <li class="navbar-item"><a href="#" class="navbar-link">Promotion</a></li>
        <li class="navbar-item"><a href="#" class="navbar-link">Contact Us</a></li>

        @guest
            <li class="navbar-item"><a href="{{ route('login') }}" class="navbar-link-login">Login</a></li>
            <li class="navbar-item"><a href="{{ route('register') }}" class="navbar-link-signup">Register</a></li>
        @else
            <li class="navbar-item profile-menu">
                <button type="button" class="profile-trigger">
                    <img src="{{ $profileImage }}" alt="Profile" class="profile-img">
                    <span>{{ Auth::user()->name }}</span>
                    <span class="material-symbols-rounded">expand_more</span>
                </button>
                <div class="profile-dropdown">
                    <div class="dropdown-header">
                        <img src="{{ $profileImage }}" alt="Profile" class="profile-img-large">
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
            </li>
        @endguest
    </ul>
</nav>

<!-- Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const profileTrigger = document.querySelector('.profile-trigger');
        const profileMenu = document.querySelector('.profile-menu');

        profileTrigger?.addEventListener('click', function (e) {
            e.stopPropagation();
            profileMenu.classList.toggle('active');
        });

        document.addEventListener('click', function (e) {
            if (profileMenu && !profileMenu.contains(e.target)) {
                profileMenu.classList.remove('active');
            }
        });

        const mobileProfileTrigger = document.querySelector('.mobile-profile-trigger');
        const mobileProfileDropdown = document.querySelector('.mobile-profile-dropdown');

        mobileProfileTrigger?.addEventListener('click', function (e) {
            e.stopPropagation();
            mobileProfileDropdown.classList.toggle('active');
        });

        document.addEventListener('click', function (e) {
            if (mobileProfileDropdown && !mobileProfileTrigger?.contains(e.target)) {
                mobileProfileDropdown.classList.remove('active');
            }
        });

        const mobileLinks = document.querySelectorAll('.navbar-links .navbar-link, .navbar-links .navbar-link-login, .navbar-links .navbar-link-signup');
        const menuToggle = document.getElementById('menu-toggle');

        mobileLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    menuToggle.checked = false;
                }
            });
        });
    });
</script>
