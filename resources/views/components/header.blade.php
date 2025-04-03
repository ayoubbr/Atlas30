<header>
    <div class="container">
        <nav class="navbar">
            <a href="#" class="logo">
                <i class="fas fa-futbol"></i> World Cup 2030
            </a>
            <ul class="nav-links">
                <li><a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ url('/matches') }}" class="{{ Request::is('matches') ? 'active' : '' }}">Matches</a></li>
                <li><a href="{{ url('/match') }}" class="{{ Request::is('match') ? 'active' : '' }}">Match Details</a></li>
                <li><a href="{{ url('/forum') }}" class="{{ Request::is('forum') ? 'active' : '' }}">Community</a></li>
                <li><a href="{{ url('/payment') }}" class="{{ Request::is('payment') ? 'active' : '' }}">Payment</a></li>
                <li><a href="{{ url('/profile') }}" class="{{ Request::is('profile') ? 'active' : '' }}">Profile</a></li>
                <li><a href="{{ url('/auth') }}" class="{{ Request::is('auth') ? 'active' : '' }}">Sign In</a></li>
            </ul>
            <div class="mobile-menu">
                <i class="fas fa-bars"></i>
            </div>
        </nav>
    </div>
</header>