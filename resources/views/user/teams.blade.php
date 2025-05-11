@extends('user.layout')

@section('title', 'Teams - World Cup 2030')

@section('css')
    <style>
        .teams-header {
            background-color: var(--secondary);
            padding: 40px 0;
            color: white;
            margin-bottom: 40px;
        }

        .teams-header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .teams-header-text h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: white
        }

        .teams-header-text p {
            font-size: 1.1rem;
            opacity: 0.8;
            max-width: 600px;
        }

        .teams-stats {
            display: flex;
            gap: 20px;
        }

        .teams-stat-item {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 15px 25px;
            border-radius: 8px;
            text-align: center;
            min-width: 150px;
        }

        .teams-stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .teams-stat-label {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .teams-filter-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .teams-search {
            flex: 1;
            max-width: 400px;
            position: relative;
        }

        .teams-search input {
            width: 100%;
            padding: 12px 20px;
            padding-left: 45px;
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
        }

        .teams-search input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.1);
        }

        .teams-search i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-500);
        }

        .teams-sort {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .teams-sort-label {
            font-size: 0.9rem;
            color: var(--gray-700);
        }

        .teams-sort-select {
            padding: 10px 15px;
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            background-color: white;
        }

        .teams-sort-select:focus {
            outline: none;
            border-color: var(--primary);
        }

        .teams-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .team-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }

        .team-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .team-card-header {
            height: 160px;
            position: relative;
            overflow: hidden;
            background-color: var(--gray-100);
        }

        .team-flag {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .team-code {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: var(--primary);
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .team-card-body {
            padding: 20px;
        }

        .team-name {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--secondary);
        }

        .team-stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .team-stat {
            text-align: center;
        }

        .team-stat-value {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--gray-800);
        }

        .team-stat-label {
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        .team-card-footer {
            padding: 15px 20px;
            border-top: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .team-matches {
            font-size: 0.9rem;
            color: var(--gray-700);
        }

        .team-view-btn {
            padding: 8px 15px;
            background-color: var(--secondary);
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .team-view-btn:hover {
            background-color: #152a45;
            color: white;
        }

        .teams-pagination {
            margin-top: 40px;
            margin-bottom: 60px;
        }

        /* Empty State */
        .teams-empty {
            text-align: center;
            padding: 60px 20px;
            background-color: var(--gray-100);
            border-radius: 10px;
            margin-bottom: 40px;
        }

        .teams-empty-icon {
            font-size: 4rem;
            color: var(--gray-400);
            margin-bottom: 20px;
        }

        .teams-empty-title {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: var(--gray-700);
        }

        .teams-empty-text {
            font-size: 1rem;
            color: var(--gray-600);
            max-width: 500px;
            margin: 0 auto 20px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .teams-header-content {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }

            .teams-header-text {
                margin-bottom: 20px;
            }

            .teams-header-text p {
                margin: 0 auto;
            }
        }

        @media (max-width: 768px) {
            .teams-filter-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .teams-search {
                max-width: 100%;
            }

            .teams-stats {
                flex-wrap: wrap;
                justify-content: center;
            }

            .teams-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media (max-width: 576px) {
            .teams-grid {
                grid-template-columns: 1fr;
            }

            .teams-stat-item {
                min-width: 120px;
            }
        }
    </style>
@endsection

@section('content')
    <section class="teams-header">
        <div class="container">
            <div class="teams-header-content">
                <div class="teams-header-text">
                    <h1>World Cup 2030 Teams</h1>
                    <p>Discover all the national teams participating in the World Cup 2030. Explore team profiles, upcoming
                        matches, and more.</p>
                </div>
                <div class="teams-stats">
                    <div class="teams-stat-item">
                        <div class="teams-stat-number">{{ $totalTeams }}</div>
                        <div class="teams-stat-label">Teams</div>
                    </div>
                    <div class="teams-stat-item">
                        <div class="teams-stat-number">{{ $totalMatches }}</div>
                        <div class="teams-stat-label">Matches</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main class="container">
        <div class="teams-filter-bar">
            <form action="{{ route('teams') }}" method="GET" class="teams-search">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Search teams..." value="{{ $search ?? '' }}">
            </form>
            <div class="teams-sort">
                <span class="teams-sort-label">Sort by:</span>
                <form id="sort-form" action="{{ route('teams') }}" method="GET">
                    <input type="hidden" name="search" value="{{ $search ?? '' }}">
                    <select name="sort" class="teams-sort-select"
                        onchange="document.getElementById('sort-form').submit()">
                        <option value="name" {{ ($sort ?? 'name') == 'name' ? 'selected' : '' }}>Team Name</option>
                        <option value="code" {{ ($sort ?? '') == 'code' ? 'selected' : '' }}>Team Code</option>
                        <option value="created_at" {{ ($sort ?? '') == 'created_at' ? 'selected' : '' }}>Date Added</option>
                    </select>
                    <select name="direction" class="teams-sort-select"
                        onchange="document.getElementById('sort-form').submit()">
                        <option value="asc" {{ ($direction ?? 'asc') == 'asc' ? 'selected' : '' }}>Ascending</option>
                        <option value="desc" {{ ($direction ?? '') == 'desc' ? 'selected' : '' }}>Descending</option>
                    </select>
                </form>
            </div>
        </div>

        @if ($teams->isEmpty())
            <div class="teams-empty">
                <i class="fas fa-users teams-empty-icon"></i>
                <h3 class="teams-empty-title">No Teams Found</h3>
                <p class="teams-empty-text">
                    We couldn't find any teams matching your search criteria. Please try a different search term or browse
                    all teams.
                </p>
                <a href="{{ route('home') }}" class="btn btn-primary">Back Home</a>
            </div>
        @else
            <div class="teams-grid">
                @foreach ($teams as $team)
                    <div class="team-card">
                        <div class="team-card-header">
                            <img src="{{ asset($team->flag) }}" alt="{{ $team->name }} Flag" class="team-flag">
                            <div class="team-code">{{ $team->code }}</div>
                        </div>
                        <div class="team-card-body">
                            <h3 class="team-name">{{ $team->name }}</h3>
                            <div class="team-stats">
                                <div class="team-stat">
                                    <div class="team-stat-value">
                                        {{ $team->homeGames()->count() + $team->awayGames()->count() }}</div>
                                    <div class="team-stat-label">Matches</div>
                                </div>
                                <div class="team-stat">
                                    <div class="team-stat-value">{{ $team->homeGames()->count() }}</div>
                                    <div class="team-stat-label">Home</div>
                                </div>
                                <div class="team-stat">
                                    <div class="team-stat-value">{{ $team->awayGames()->count() }}</div>
                                    <div class="team-stat-label">Away</div>
                                </div>
                            </div>
                        </div>
                        <div class="team-card-footer">
                            <div class="team-matches">
                                <i class="fas fa-calendar-alt"></i>
                                @php
                                    $upcomingMatches = \App\Models\Game::where(function ($query) use ($team) {
                                        $query->where('home_team_id', $team->id)->orWhere('away_team_id', $team->id);
                                    })
                                        ->where('status', 'upcoming')
                                        ->count();
                                @endphp
                                {{ $upcomingMatches }} upcoming
                            </div>
                            <a href="{{ route('teams.show', $team->id) }}" class="team-view-btn">View Team</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.querySelector('.mobile-menu');
            const navLinks = document.querySelector('.nav-links');

            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function() {
                    navLinks.classList.toggle('active');
                });
            }
        });
    </script>
@endsection
