@php
    $profileImage = Auth::user()?->image && trim(Auth::user()?->image) !== ''
        ? asset('storage/' . Auth::user()->image)
        : asset('images/default.png');
@endphp

<nav class="navbar">
    <h2 class="logo">Logo</h2>
    <input type="text" id="search-box" class="search-input" placeholder="Search...">

    <div class="hamburger">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <ul class="navbar-links">
        <li class="navbar-item"><a href="#" class="navbar-link">Home</a></li>
        <li class="navbar-item"><a href="#" class="navbar-link">Browse Car</a></li>
        <li class="navbar-item"><a href="#" class="navbar-link">Promotion</a></li>
        <li class="navbar-item"><a href="#" class="navbar-link">Contact Us</a></li>

        @guest
            <li class="navbar-item"><a href="{{ route('login') }}" class="navbar-link-login">Login</a></li>
            <li class="navbar-item"><a href="{{ route('register') }}" class="navbar-link-signup">Register</a></li>
        @else
    </ul> <!-- close the ul before user menu -->

    <div class="user-menu">
        <div class="user-toggle">
            <img src="{{ $profileImage }}" alt="User Avatar" class="user-avatar">
            <span class="username">{{ Auth::user()->name }}</span>
            <i class="arrow-down"></i>
        </div>

        <div class="user-dropdown">
            <div class="user-info">
                <img src="{{ $profileImage }}" alt="User Avatar" class="user-avatar-large">
                <div class="user-details">
                    <div class="username">{{ Auth::user()->name }}</div>
                    <div class="role">{{ Auth::user()->role ?? 'User' }}</div>
                </div>
            </div>

            <ul>
                <li><a href="#">My Profile</a></li>
                <li><a href="#">Settings</a></li>
                <li><a href="#">Messages</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout">Sign out</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
    @endguest
</nav>

<script>
    const userToggle = document.querySelector('.user-toggle');
    const userDropdown = document.querySelector('.user-dropdown');
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.navbar-links');

    if (userToggle) {
        userToggle.addEventListener('click', () => {
            userDropdown.classList.toggle('active');
        });
    }

    if (hamburger) {
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            navLinks.classList.toggle('active');
        });
    }
</script>
