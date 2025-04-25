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
        <li class="navbar-item"><a href="{{ route('login') }}" class="navbar-link">Login</a>
        </li>
        <li class="navbar-item"><a href="{{ route('register') }}" class="navbar-link">SignUp</a></li>
    </ul>
</nav>
