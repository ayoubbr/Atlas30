<header class="site-header">
    <div class="container">
        <nav class="navbar">
            <a href="{{ url('/') }}" class="logo">
                <i class="fas fa-futbol"></i> Atlas30
            </a>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}" class="{{ Request::routeIs('home') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('games') }}" class="{{ Request::routeIs('games') ? 'active' : '' }}">Games</a></li>
                <li><a href="{{ route('teams') }}" class="{{ Request::routeIs('teams') ? 'active' : '' }}">Teams</a>
                </li>
                <li><a href="{{ route('forum.index') }}" class="{{ request()->is('forum') ? 'active' : '' }}">Community</a>
                </li>
            </ul>

            <div class="nav-actions">
                @auth
                    <div class="notifications-dropdown">
                        <button class="btn-icon notification-btn">
                            <i class="fas fa-bell"></i>
                            @php
                                $notif = auth()->user()->notifications()->where('status', 'unread')->get();
                            @endphp
                            @if ($notif->count() > 0)
                                <span class="notification-badge"> {{ $notif->count() }} </span>
                            @endif
                        </button>
                        <div class="dropdown-content">
                            <div class="dropdown-header">
                                <h4>Notifications</h4>
                                @if ($notif->count() > 0)
                                    <a href="{{ route('notifications.markAllAsRead') }}"
                                        class="mark-all-read">Mark all as read</a>
                                @endif
                            </div>
                            <div class="dropdown-body">
                                @forelse(auth()->user()->notifications()->take(5)->get() as $notification)
                                    <div  class="notification-item {{ $notification->status }}">
                                        <div class="notification-icon">
                                            <i class="fas fa-bullhorn"></i>
                                        </div>
                                        <div class="notification-content">
                                            <p>{{ $notification->content }}</p>
                                            <span
                                                class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="empty-notifications">
                                        <p>No notifications yet</p>
                                    </div>
                                @endforelse
                            </div>
                            <div class="dropdown-footer">
                                {{-- <a href="{{ route('notifications.index') }}">View all notifications</a> --}}
                            </div>
                        </div>
                    </div>

                    <div class="user-dropdown">
                        <button class="btn btn-user">
                            <span>{{ auth()->user()->firstname }}</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-content">
                            <a href="{{ route('profile') }}">
                                <i class="fas fa-user"></i> My Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline">Sign In</a>
                    <a href="{{ route('login') }}" class="btn btn-primary">Register</a>
                @endauth
            </div>

            <div class="mobile-menu">
                <i class="fas fa-bars"></i>
            </div>
        </nav>
    </div>
</header>
