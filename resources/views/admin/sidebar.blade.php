<!-- Sidebar -->
<aside class="admin-sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <div class="logo-icon">
                <i class="fas fa-futbol"></i>
            </div>
            <span>World Cup 2030</span>
        </div>
    </div>

    <div class="sidebar-content">
        <div class="nav-section">
            <div class="nav-section-title">Main</div>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="{{ url('/admin/dashboard') }}"
                        class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Management</div>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="{{ url('/admin/games') }}"
                        class="nav-link {{ request()->is('admin/games') ? 'active' : '' }}">
                        <i class="fas fa-futbol nav-icon"></i>
                        <span class="nav-text">Games</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/admin/tickets') }}"
                        class="nav-link {{ request()->is('admin/tickets') ? 'active' : '' }}">
                        <i class="fas fa-ticket-alt nav-icon"></i>
                        <span class="nav-text">Tickets</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/admin/stadiums') }}"
                        class="nav-link {{ request()->is('admin/stadiums') ? 'active' : '' }}">
                        <i class="fas fa-map-marker-alt nav-icon"></i>
                        <span class="nav-text">Stadiums</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/admin/teams') }}"
                        class="nav-link {{ request()->is('admin/teams') ? 'active' : '' }}">
                       <i class="fa-brands fa-font-awesome nav-icon"></i>
                        <span class="nav-text">Teams</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/admin/roles') }}"
                        class="nav-link {{ request()->is('admin/roles') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-gear nav-icon"></i>
                        <span class="nav-text">Roles</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Community</div>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="{{ url('/admin/users') }}"
                        class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}">
                        <i class="fas fa-user nav-icon"></i>
                        <span class="nav-text">Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/admin/forum') }}"
                        class="nav-link {{ request()->is('admin/forum') ? 'active' : '' }}">
                        <i class="fas fa-comments nav-icon"></i>
                        <span class="nav-text">Forum</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Logout</div>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="{{ url('logout') }}" class="nav-link {{ request()->is('logout') ? 'active' : '' }}">
                        <i class="fa-solid fa-right-from-bracket nav-icon"></i>
                        <span class="nav-text">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="sidebar-footer">
        <div class="sidebar-footer-text">World Cup 2030 Admin v1.0</div>
    </div>
</aside>
{{-- header --}}
<header class="admin-header">
    <div class="header-left">
        <div class="menu-toggle" id="menu-toggle">
            <i class="fas fa-bars"></i>
        </div>
        <h1 class="page-title"> @yield('header-title', 'Dashboard')</h1>
    </div>

    <div class="header-right">
        @auth
            <div class="user-profile" id="admin-profile-link">
                <div class="user-avatar">
                    <img src="{{ asset(Auth::user()->image) ?? 'https://via.placeholder.com/40x40' }}" alt="Admin Avatar">
                </div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</div>
                    <div class="user-role">{{ Auth::user()->role->name }}</div>
                </div>
            </div>
        @endauth
    </div>
</header>

<script>
    const adminProfileLink = document.getElementById('admin-profile-link');
    if (adminProfileLink) {
        adminProfileLink.addEventListener('click', function() {
            window.location.href = "{{ route('admin.profile') }}";
        });
    }
</script>
