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
                <li class="nav-item">
                    <a href="{{ url('/admin/analytics') }}"
                        class="nav-link {{ request()->is('admin/analytics') ? 'active' : '' }}">
                        <i class="fas fa-chart-line nav-icon"></i>
                        <span class="nav-text">Analytics</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Management</div>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="{{ url('/admin/matches') }}"
                        class="nav-link {{ request()->is('admin/matches') ? 'active' : '' }}">
                        <i class="fas fa-futbol nav-icon"></i>
                        <span class="nav-text">Matches</span>
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
                        <span class="nav-text">stadiums</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/admin/teams') }}"
                        class="nav-link {{ request()->is('admin/teams') ? 'active' : '' }}">
                        <i class="fas fa-users nav-icon"></i>
                        <span class="nav-text">Teams</span>
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
                    <a href="{{ url('/admin/forums') }}"
                        class="nav-link {{ request()->is('admin/forums') ? 'active' : '' }}">
                        <i class="fas fa-comments nav-icon"></i>
                        <span class="nav-text">Forums</span>
                        <span class="nav-badge">12</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Settings</div>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="{{ url('/admin/settings') }}"
                        class="nav-link {{ request()->is('admin/settings') ? 'active' : '' }}">
                        <i class="fas fa-cog nav-icon"></i>
                        <span class="nav-text">Settings</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/admin/settings') }}#security" class="nav-link">
                        <i class="fas fa-user-shield nav-icon"></i>
                        <span class="nav-text">Permissions</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="sidebar-footer">
        <div class="sidebar-footer-text">World Cup 2030 Admin v1.0</div>
    </div>
</aside>

<!-- Header -->
<header class="admin-header">
    <div class="header-left">
        <div class="menu-toggle" id="menu-toggle">
            <i class="fas fa-bars"></i>
        </div>
        <h1 class="page-title">
            @yield('title', 'Dashboard')
        </h1>
    </div>

    <div class="header-right">
        <div class="header-search">
            <input type="text" class="search-input" placeholder="Search...">
            <i class="fas fa-search search-icon"></i>
        </div>

        <div class="header-actions">
            <div class="action-btn">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">5</span>
            </div>
            <div class="action-btn">
                <i class="fas fa-envelope"></i>
                <span class="notification-badge">3</span>
            </div>
        </div>

        <div class="user-profile">
            <div class="user-avatar">
                <img src="https://cdn-icons-png.flaticon.com/128/6024/6024190.png" alt="Admin Avatar">
            </div>
            <div class="user-info">
                <div class="user-name">John Doe</div>
                <div class="user-role">Administrator</div>
            </div>
        </div>
    </div>
</header>
