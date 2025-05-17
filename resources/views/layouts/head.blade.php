@php
    $profileImage = Auth::user()?->image && trim(Auth::user()?->image) !== ''
        ? asset('storage/' . Auth::user()->image)
        : asset('images/default.png');
@endphp

<nav class="navbar">
    <h2 class="logo">
        <img src="{{asset('images/logo-azidcar.png')}}" alt="logo-azidcar" class="logo-img">
    </h2>

    <!-- <input type="text" id="search-box" class="search-input" placeholder="{{ __('Search...') }}"> -->

    <!-- Language Switcher -->
    @include('components.language-switcher')

    @auth
    <div class="mobile-profile">
        <button type="button" class="mobile-profile-trigger">
            <img src="{{ $profileImage }}" alt="Profile" class="profile-img" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
            <span class="profile-name">{{ Auth::user()->name }}</span>
        </button>
        <div class="mobile-profile-dropdown">
            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                <span class="material-symbols-rounded">person</span>
                <span>{{ __('messages.my_profile') }}</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                <span class="material-symbols-rounded">settings</span>
                <span>{{ __('messages.settings') }}</span>
            </a>
            <a href="#" class="dropdown-item">
                <span class="material-symbols-rounded">mail</span>
                <span>{{ __('messages.messages') }}</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item text-danger">
                    <span class="material-symbols-rounded">logout</span>
                    <span>{{ __('messages.sign_out') }}</span>
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
        <li class="navbar-item">

            <a href="{{route('dashboard')}}" class="navbar-link {{ request()->routeIs('dashboard') ? 'current' : '' }}">{{ __('messages.home') }}</a>
        </li>
        <li class="navbar-item">
            <a href="{{route('cars.listing')}}" class="navbar-link {{ request()->routeIs('cars.listing') ? 'current' : '' }}">{{ __('messages.browse_car') }}</a>
        </li>

        <li class="navbar-item">
            <a href="#" class="navbar-link {{ request()->routeIs('contact') ? 'current' : '' }}">{{ __('messages.contact_us') }}</a>
        </li>

        @guest
            <li class="navbar-item"><a href="{{ route('login') }}" class="navbar-link-login">{{ __('messages.login') }}</a></li>
            <li class="navbar-item"><a href="{{ route('register') }}" class="navbar-link-signup">{{ __('messages.register') }}</a></li>
        @else
            <li class="navbar-item profile-menu">
                <button type="button" class="profile-trigger">
                    <img src="{{ $profileImage }}" alt="Profile" class="profile-img" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                    <span>{{ Auth::user()->name }}</span>
                    <span class="material-symbols-rounded">expand_more</span>
                </button>
                <div class="profile-dropdown">
                    <div class="dropdown-header">
                        <img src="{{ $profileImage }}" alt="Profile" class="profile-img-large">
                        <div class="profile-info">
                            <h4>{{ Auth::user()->name }}</h4>
                            <p>{{ __('messages.administrator') }}</p>
                        </div>
                    </div>
                    <div class="dropdown-body">
                        <a href="{{ route('profile.show') }}" class="dropdown-item">
                            <span class="material-symbols-rounded">person</span>
                            <span>{{ __('messages.my_profile') }}</span>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <span class="material-symbols-rounded">settings</span>
                            <span>{{ __('messages.settings') }}</span>
                        </a>
                        <a href="#" class="dropdown-item">
                            <span class="material-symbols-rounded">mail</span>
                            <span>{{ __('messages.messages') }}</span>
                        </a>
                    </div>
                    <div class="dropdown-footer">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <span class="material-symbols-rounded">logout</span>
                                <span>{{ __('messages.sign_out') }}</span>
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
        // Profile dropdown functionality
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

        // Mobile profile dropdown functionality
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

        // Language switcher functionality is now in the language-switcher component

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
