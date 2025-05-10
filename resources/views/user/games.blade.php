@extends('user.layout')

@section('title', 'Games - World Cup 2030')

@section('css')
    <style>
        /* Filters Section */
        .filters-section {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 40px;
        }

        .filters-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .filters-title h2 {
            font-size: 1.5rem;
        }

        .filters-toggle {
            background: none;
            border: none;
            color: var(--primary);
            font-size: 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .filters-toggle i {
            margin-left: 5px;
            transition: transform 0.3s ease;
        }

        .filters-toggle.collapsed i {
            transform: rotate(180deg);
        }

        .filters-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .filters-content.show {
            max-height: 500px;
        }

        .filters-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--gray-300);
            border-radius: 4px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(230, 57, 70, 0.2);
        }

        .filters-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        /* Search Bar */
        .search-bar {
            display: flex;
            margin-bottom: 30px;
        }

        .search-input {
            flex: 1;
            padding: 12px 20px;
            border: 1px solid var(--gray-300);
            border-right: none;
            border-radius: 4px 0 0 4px;
            font-size: 1rem;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .search-btn {
            padding: 0 20px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            background-color: #d32f2f;
        }

        /* Matches Section */
        .matches-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .matches-count {
            font-size: 1.1rem;
            color: var(--gray-700);
        }

        .matches-count span {
            font-weight: 700;
            color: var(--primary);
        }

        .matches-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .match-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
        }

        .match-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .match-stage {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: var(--accent);
            color: var(--dark);
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 1;
        }

        .match-header {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://source.unsplash.com/random/400x200/?stadium') no-repeat center center/cover;
            padding: 20px;
            color: white;
            position: relative;
        }

        .match-date {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .match-day {
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }

        .match-day i {
            margin-right: 5px;
            color: var(--accent);
        }

        .match-time {
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }

        .match-time i {
            margin-right: 5px;
            color: var(--accent);
        }

        .match-venue {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
        }

        .match-venue i {
            margin-right: 5px;
            color: var(--accent);
        }

        .match-teams {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
        }

        .match-team {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 40%;
        }

        .team-flag {
            width: 60px;
            height: 40px;
            margin-bottom: 10px;
            background-size: cover;
            background-position: center;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .team-name {
            font-weight: 600;
            margin-bottom: 5px;

        }

        .team-code {
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        .match-score {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 20%;
            padding-top: 25px;
        }

        .score-display {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .match-status {
            font-size: 0.7rem;
            padding: 3px 8px;
            border-radius: 20px;
            background-color: var(--gray-200);
            color: var(--gray-700);
            margin-top: 50px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .match-status.upcoming {
            background-color: var(--info);
            color: white;
        }

        .match-status.live {
            background-color: var(--primary);
            color: white;
            animation: pulse 1.3s infinite;
        }

        .match-status.completed {
            background-color: var(--success);
            color: white;
        }

        .match-status.postponed {
            background-color: var(--gray-600);
            color: white;
        }

        .match-status.canceled {
            background-color: var(--gray-900);
            color: white;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }

            100% {
                opacity: 1;
            }
        }

        .match-footer {
            padding: 15px 20px;
            border-top: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .match-group {
            font-size: 0.9rem;
            color: var(--gray-600);
        }

        .match-actions {
            display: flex;
            gap: 10px;
        }

        .stadium-info {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .stadium-image {
            width: 80px;
            height: 60px;
            border-radius: 4px;
            margin-right: 15px;
            background-size: cover;
            background-position: center;
        }

        .stadium-details h4 {
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .stadium-details p {
            font-size: 0.9rem;
            color: var(--gray-600);
        }

        .referee-info {
            display: flex;
            align-items: center;
        }

        .referee-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 15px;
            background-size: cover;
            background-position: center;
        }

        .referee-details h4 {
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .referee-details p {
            font-size: 0.9rem;
            color: var(--gray-600);
        }

        .ticket-info {
            background-color: white;
            border-radius: 4px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .ticket-categories {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
            margin-bottom: 15px;
        }

        .ticket-category {
            padding: 10px;
            border: 1px solid var(--gray-300);
            border-radius: 4px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .ticket-category:hover {
            border-color: var(--primary);
            background-color: var(--light);
        }

        .ticket-category.selected {
            border-color: var(--primary);
            background-color: var(--light);
        }

        .ticket-category h5 {
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .ticket-price {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary);
        }

        .ticket-availability {
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        .ticket-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .ticket-quantity {
            display: flex;
            align-items: center;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--gray-200);
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .quantity-btn:hover {
            background-color: var(--gray-300);
        }

        .quantity-input {
            width: 40px;
            height: 30px;
            text-align: center;
            border: 1px solid var(--gray-300);
            margin: 0 5px;
            font-size: 0.9rem;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            margin-top: 40px;
            margin-bottom: 60px;
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 4px;
            background-color: white;
            color: var(--gray-700);
            font-weight: 500;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .pagination a:hover {
            background-color: var(--gray-200);
            color: var(--dark);
        }

        .pagination a.active {
            background-color: var(--primary);
            color: white;
        }

        .pagination a.disabled {
            background-color: var(--gray-100);
            color: var(--gray-400);
            cursor: not-allowed;
            pointer-events: none;
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .matches-grid {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .mobile-menu {
                display: block;
            }

            .page-header h1 {
                font-size: 2rem;
            }

            .matches-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .matches-grid {
                grid-template-columns: 1fr;
            }

            .ticket-categories {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 576px) {
            .filters-form {
                grid-template-columns: 1fr;
            }

            .match-teams {
                flex-direction: column;
                gap: 20px;
            }

            .match-team {
                width: 100%;
            }

            .match-score {
                width: 100%;
                margin: 15px 0;
            }

            .score-display {
                font-size: 1.5rem;
            }

            .match-footer {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .match-actions {
                width: 100%;
                justify-content: space-between;
            }

            .ticket-categories {
                grid-template-columns: 1fr;
            }

            .ticket-actions {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }

        /* Add this to fix the match-stage positioning */
        .match-stage {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: var(--accent);
            color: var(--dark);
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 10;
            /* Increase z-index to ensure it's above other elements */
        }

        /* Fix the match-header to ensure proper positioning context */
        .match-header {
            background-position: center center;
            background-size: cover;
            background-repeat: no-repeat;
            padding: 20px;
            color: white;
            position: relative;
            /* Ensure this is set for absolute positioning of children */
        }

        /* Fix the match details section */
        .match-details {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease;
            /* Increase transition time for smoother animation */
            background-color: var(--gray-100);
            border-top: 1px solid var(--gray-200);
        }

        .match-details.show {
            max-height: 800px;
            /* Increase max-height to ensure content fits */
        }
    </style>
@endsection

@section('content')
    <section class="page-header">
        <div class="container">
            <h1>World Cup 2030 Matches</h1>
            <ul class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/games') }}">Matches</a></li>
            </ul>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container">
        <section class="filters-section">
            <div class="filters-title">
                <h2>Filter Matches</h2>
                <button class="filters-toggle">
                    Filter Options <i class="fas fa-chevron-up"></i>
                </button>
            </div>
            <div class="filters-content show">
                <form class="filters-form" action="{{ url('/games') }}" method="GET">
                    <div class="form-group">
                        <label for="date-range">Date Range</label>
                        <select class="form-control" id="date-range" name="date_range">
                            <option value="">All Dates</option>
                            <option value="today">Today</option>
                            <option value="tomorrow">Tomorrow</option>
                            <option value="this-week">This Week</option>
                            <option value="next-week">Next Week</option>
                            <option value="this-month">This Month</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="team">Team</label>
                        <select class="form-control" id="team" name="team_id">
                            <option value="">All Teams</option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="venue">Venue</label>
                        <select class="form-control" id="venue" name="stadium_id">
                            <option value="">All Venues</option>
                            @foreach ($stadiums as $stadium)
                                <option value="{{ $stadium->id }}">{{ $stadium->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">All Statuses</option>
                            <option value="upcoming">upcoming</option>
                            <option value="live">Live</option>
                            <option value="completed">Completed</option>
                            <option value="postponed">Postponed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="filters-actions">
                        <button type="reset" class="btn btn-outline">Reset</button>
                        <button type="submit" class="btn">Apply Filters</button>
                    </div>
                </form>
            </div>
        </section>

        <div class="search-bar">
            <form action="{{ url('/games') }}" method="GET" style="display: flex; width: 100%;">
                <input type="text" class="search-input" name="search"
                    placeholder="Search for matches, teams, or venues...">
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <section class="matches-section">
            <div class="matches-header">
                <div class="matches-count">
                    Showing <span>{{ $games->count() }}</span> matches
                </div>
            </div>

            <div class="matches-grid">
                @foreach ($games as $game)
                    <div class="match-card">
                        <div class="match-header"
                            style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ $game->image ? asset($game->image) : 'https://source.unsplash.com/random/400x200/?stadium' }}')">
                            <div class="match-date">
                                <div class="match-day">
                                    <i class="far fa-calendar-alt"></i> {{ $game->start_date }}
                                </div>
                                <div class="match-time">
                                    <i class="far fa-clock"></i>
                                    {{ \Carbon\Carbon::parse($game->start_hour)->format('H:i') }}
                                </div>
                            </div>
                            <div class="match-venue">
                                <i class="fas fa-map-marker-alt"></i> {{ $game->stadium->name }},
                                {{ $game->stadium->location }}
                            </div>
                        </div>
                        <div class="match-teams">
                            <div class="match-team">
                                <div class="team-flag"
                                    style="background-image: url('{{ $game->homeTeam->flag ? asset($game->homeTeam->flag) : 'https://via.placeholder.com/60x40/3498db/ffffff?text=' . substr($game->homeTeam->name, 0, 3) }}')">
                                </div>
                                <div class="team-name">{{ $game->homeTeam->name }}</div>
                                <div class="team-code">{{ substr($game->homeTeam->name, 0, 3) }}</div>
                            </div>
                            <div class="match-score">
                                @if ($game->status == 'completed' || $game->status == 'live')
                                    <div class="score-display">{{ $game->home_team_goals }} - {{ $game->away_team_goals }}
                                    </div>
                                @else
                                    <div class="score-display">vs</div>
                                @endif

                                <div class="match-status {{ $game->status }}">
                                    @switch($game->status)
                                        @case('upcoming')
                                            <i class="fas fa-clock"></i> {{ ucfirst($game->status) }}
                                        @break

                                        @case('live')
                                            <i class="fas fa-broadcast-tower"></i> {{ ucfirst($game->status) }}
                                        @break

                                        @case('completed')
                                            <i class="fas fa-check-circle"></i> {{ ucfirst($game->status) }}
                                        @break

                                        @case('canceled')
                                            <i class="fa-solid fa-ban"></i> {{ ucfirst($game->status) }}
                                        @break

                                        @case('postponed')
                                            <i class="fa-solid fa-clock-rotate-left"></i> {{ ucfirst($game->status) }}
                                        @break

                                        @default
                                            <i class="fas fa-question-circle"></i> Unknown
                                    @endswitch
                                </div>
                            </div>
                            <div class="match-team">
                                <div class="team-flag"
                                    style="background-image: url('{{ $game->awayTeam->flag ? asset($game->awayTeam->flag) : 'https://via.placeholder.com/60x40/e74c3c/ffffff?text=' . substr($game->awayTeam->name, 0, 3) }}')">
                                </div>
                                <div class="team-name">{{ $game->awayTeam->name }}</div>
                                <div class="team-code">{{ substr($game->awayTeam->name, 0, 3) }}</div>
                            </div>
                        </div>
                        <div class="match-footer">
                            <div class="match-actions">

                                <a href="{{ route('games.show', $game->id) }}"
                                    class="btn btn-sm btn-outline match-details-btn"
                                    data-match="{{ $game->id }}">Details or Buy Ticket</a>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if ($games->count() == 0)
                    <div style="grid-column: 1 / -1; text-align: center; padding: 40px 0;">
                        <h3>No matches found</h3>
                        <p>Try adjusting your filters or search criteria.</p>
                    </div>
                @endif
            </div>

            <!-- Pagination - You can implement this if you're using Laravel's pagination -->
            @if (isset($games) && method_exists($games, 'links') && $games->hasPages())
                {{ $games->links() }}
            @else
                <ul class="pagination">
                    <li><a href="#" class="disabled"><i class="fas fa-chevron-left"></i></a></li>
                    <li><a href="#" class="active">1</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i></a></li>
                </ul>
            @endif
        </section>
    </main>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.querySelector('.mobile-menu');
            const navLinks = document.querySelector('.nav-links');

            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function() {
                    mobileMenuBtn.addEventListener('click', function() {
                        navLinks.classList.toggle('active');
                    });
                });
            }

            const filtersToggle = document.querySelector('.filters-toggle');
            const filtersContent = document.querySelector('.filters-content');

            if (filtersToggle && filtersContent) {
                filtersToggle.addEventListener('click', function() {
                    filtersContent.classList.toggle('show');
                    filtersToggle.classList.toggle('collapsed');
                });
            }
        });
    </script>
@endsection
