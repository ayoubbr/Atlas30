@extends('user.layout')

@section('title', $team->name . ' - World Cup 2030')

@section('css')
    <style>
        .team-banner {
            background-color: var(--secondary);
            padding: 60px 0;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .team-banner-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.1;
            background-size: cover;
            background-position: center;
            filter: blur(8px);
        }

        .team-banner-content {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 40px;
        }

        .team-banner-flag {
            width: 200px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .team-banner-info h1 {
            font-size: 3rem;
            margin-bottom: 10px;
            color: white
        }

        .team-banner-code {
            display: inline-block;
            background-color: var(--primary);
            padding: 5px 15px;
            border-radius: 5px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .team-banner-stats {
            display: flex;
            gap: 30px;
        }

        .team-banner-stat {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .team-banner-stat-value {
            font-size: 2rem;
            font-weight: 700;
        }

        .team-banner-stat-label {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .team-content {
            padding: 60px 0;
        }

        .team-content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 40px;
        }

        .team-matches-section {
            margin-bottom: 40px;
        }

        .team-section-title {
            font-size: 1.5rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--gray-200);
            display: flex;
            align-items: center;
        }

        .team-section-title i {
            margin-right: 10px;
            color: var(--primary);
        }

        .team-matches-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .team-match-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .team-match-card:hover {
            transform: translateY(-5px);
        }

        .team-match-header {
            background-color: var(--gray-100);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .team-match-date {
            display: flex;
            align-items: center;
            color: var(--gray-700);
            font-size: 0.9rem;
        }

        .team-match-date i {
            margin-right: 8px;
            color: var(--primary);
        }

        .team-match-status {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .team-match-status.scheduled {
            background-color: var(--info-light);
            color: var(--info);
        }

        .team-match-status.live {
            background-color: var(--danger-light);
            color: var(--danger);
        }

        .team-match-status.completed {
            background-color: var(--success-light);
            color: var(--success);
        }

        .team-match-status.postponed {
            background-color: var(--success-light);
            color: var(--warning);
        }

        .team-match-status.canceled {
            background-color: var(--success-light);
            color: var(--dark);
        }

        .team-match-body {
            padding: 20px;
        }

        .team-match-teams {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .team-match-team {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 40%;
        }

        .team-match-team-flag {
            width: 60px;
            height: 45px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .team-match-team-name {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .team-match-team-score {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-800);
        }

        .team-match-vs {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--gray-500);
        }

        .team-match-details {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .team-match-detail {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            color: var(--gray-700);
        }

        .team-match-detail i {
            margin-right: 8px;
            color: var(--primary);
            width: 16px;
        }

        .team-match-footer {
            padding: 15px 20px;
            border-top: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .team-match-tickets {
            font-size: 0.9rem;
            color: var(--gray-700);
        }

        .team-match-tickets i {
            margin-right: 5px;
            color: var(--success);
        }

        .team-match-btn {
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

        .team-match-btn:hover {
            background-color: #152a45;
            color: white;
        }

        .team-stats-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .team-stats-header {
            background-color: var(--secondary);
            color: white;
            padding: 20px;
        }

        .team-stats-title {
            font-size: 1.2rem;
            margin-bottom: 5px;
            color: white
        }

        .team-stats-subtitle {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .team-stats-body {
            padding: 20px;
        }

        .team-stat-item {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid var(--gray-200);
        }

        .team-stat-item:last-child {
            border-bottom: none;
        }

        .team-stat-label {
            color: var(--gray-700);
        }

        .team-stat-value {
            font-weight: 600;
            color: var(--gray-900);
        }

        .related-teams-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .related-teams-header {
            background-color: var(--secondary);
            color: white;
            padding: 20px;
        }

        .related-teams-title {
            font-size: 1.2rem;
            margin-bottom: 5px;
            color: white
        }

        .related-teams-subtitle {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .related-teams-body {
            padding: 20px;
        }

        .related-team-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid var(--gray-200);
        }

        .related-team-item:last-child {
            border-bottom: none;
        }

        .related-team-flag {
            width: 40px;
            height: 30px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 15px;
        }

        .related-team-info {
            flex: 1;
        }

        .related-team-name {
            font-weight: 600;
            margin-bottom: 3px;
        }

        .related-team-matches {
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        .related-team-link {
            color: var(--primary);
            font-size: 0.9rem;
        }

        .team-matches-empty {
            text-align: center;
            padding: 40px 20px;
            background-color: var(--gray-100);
            border-radius: 10px;
        }

        .team-matches-empty-icon {
            font-size: 3rem;
            color: var(--gray-400);
            margin-bottom: 15px;
        }

        .team-matches-empty-title {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: var(--gray-700);
        }

        .team-matches-empty-text {
            font-size: 0.9rem;
            color: var(--gray-600);
            max-width: 400px;
            margin: 0 auto;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .team-content-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .team-banner-content {
                flex-direction: column;
                text-align: center;
            }

            .team-banner-stats {
                justify-content: center;
            }

            .team-match-teams {
                flex-direction: column;
                gap: 20px;
            }

            .team-match-team {
                width: 100%;
            }

            .team-match-vs {
                margin: 10px 0;
            }
        }

        @media (max-width: 576px) {
            .team-banner-flag {
                width: 150px;
                height: 100px;
            }

            .team-banner-info h1 {
                font-size: 2rem;
            }

            .team-banner-stats {
                flex-wrap: wrap;
                gap: 20px;
            }

            .team-match-header {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }

            .team-match-footer {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }
    </style>
@endsection

@section('content')
    <section class="team-banner">
        <div class="team-banner-bg" style="background-image: url('{{ asset($team->flag) }}');"></div>
        <div class="container">
            <div class="team-banner-content">
                <img src="{{ asset($team->flag) }}" alt="{{ $team->name }} Flag" class="team-banner-flag">
                <div class="team-banner-info">
                    <h1>{{ $team->name }}</h1>
                    <div class="team-banner-code">{{ $team->code }}</div>
                    <div class="team-banner-stats">
                        <div class="team-banner-stat">
                            <div class="team-banner-stat-value">{{ $totalMatches }}</div>
                            <div class="team-banner-stat-label">Total Matches</div>
                        </div>
                        <div class="team-banner-stat">
                            <div class="team-banner-stat-value">{{ $homeMatches }}</div>
                            <div class="team-banner-stat-label">Home Matches</div>
                        </div>
                        <div class="team-banner-stat">
                            <div class="team-banner-stat-value">{{ $awayMatches }}</div>
                            <div class="team-banner-stat-label">Away Matches</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="team-content">
        <div class="container">
            <div class="team-content-grid">
                <div class="team-matches">

                    <div class="team-matches-section">
                        <h2 class="team-section-title">
                            <i class="fas fa-calendar-alt"></i> Upcoming Matches
                        </h2>

                        @if ($upcomingMatches->isEmpty())
                            <div class="team-matches-empty">
                                <i class="far fa-calendar-times team-matches-empty-icon"></i>
                                <h3 class="team-matches-empty-title">No Upcoming Matches</h3>
                                <p class="team-matches-empty-text">
                                    There are no upcoming matches scheduled for {{ $team->name }} at this time.
                                </p>
                            </div>
                        @else
                            <div class="team-matches-list">
                                @foreach ($upcomingMatches as $match)
                                    <div class="team-match-card">
                                        <div class="team-match-header">
                                            <div class="team-match-date">
                                                <i class="far fa-calendar-alt"></i>
                                                {{ $match->start_date }} at {{ $match->start_hour }}
                                            </div>
                                            <div
                                                class="team-match-status 
                                            @if ($match->status === 'scheduled') scheduled
                                            @elseif ($match->status === 'live') live
                                            @elseif ($match->status === 'completed') completed
                                            @elseif ($match->status === 'canceled') canceled
                                            @elseif ($match->status === 'postponed') postponed
                                            @else unknown @endif">
                                                @switch($match->status)
                                                    @case('scheduled')
                                                        <i class="fas fa-clock"></i> {{ ucfirst($match->status) }}
                                                    @break

                                                    @case('live')
                                                        <i class="fas fa-broadcast-tower"></i> {{ ucfirst($match->status) }}
                                                    @break

                                                    @case('completed')
                                                        <i class="fas fa-check-circle"></i> {{ ucfirst($match->status) }}
                                                    @break

                                                    @case('canceled')
                                                        <i class="fa-solid fa-ban"></i> {{ ucfirst($match->status) }}
                                                    @break

                                                    @case('postponed')
                                                        <i class="fa-solid fa-clock-rotate-left"></i>{{ ucfirst($match->status) }}
                                                    @break

                                                    @default
                                                        <i class="fas fa-question-circle"></i> Unknown
                                                @endswitch
                                            </div>
                                        </div>
                                        <div class="team-match-body">
                                            <div class="team-match-teams">
                                                <div class="team-match-team">
                                                    <img src="{{ asset($match->homeTeam->flag) }}"
                                                        alt="{{ $match->homeTeam->name }}" class="team-match-team-flag">
                                                    <div class="team-match-team-name">{{ $match->homeTeam->name }}</div>
                                                </div>
                                                <div class="team-match-vs">VS</div>
                                                <div class="team-match-team">
                                                    <img src="{{ asset($match->awayTeam->flag) }}"
                                                        alt="{{ $match->awayTeam->name }}" class="team-match-team-flag">
                                                    <div class="team-match-team-name">{{ $match->awayTeam->name }}</div>
                                                </div>
                                            </div>
                                            <div class="team-match-details">
                                                <div class="team-match-detail">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <span>{{ $match->stadium->name }}, {{ $match->stadium->city }}</span>
                                                </div>
                                                <div class="team-match-detail">
                                                    <i class="fas fa-users"></i>
                                                    <span>Capacity: {{ number_format($match->stadium->capacity) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="team-match-footer">
                                            <div class="team-match-tickets">
                                                <i class="fas fa-ticket-alt"></i>
                                                Tickets available
                                            </div>
                                            <a href="{{ route('games.show', $match->id) }}" class="team-match-btn">View
                                                Match</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="team-matches-section">
                        <h2 class="team-section-title">
                            <i class="fas fa-history"></i> Recent Matches
                        </h2>

                        @if ($recentMatches->isEmpty())
                            <div class="team-matches-empty">
                                <i class="far fa-calendar-times team-matches-empty-icon"></i>
                                <h3 class="team-matches-empty-title">No Recent Matches</h3>
                                <p class="team-matches-empty-text">
                                    There are no recent matches for {{ $team->name }} to display.
                                </p>
                            </div>
                        @else
                            <div class="team-matches-list">
                                @foreach ($recentMatches as $match)
                                    <div class="team-match-card">
                                        <div class="team-match-header">
                                            <div class="team-match-date">
                                                <i class="far fa-calendar-alt"></i>
                                                {{ $match->start_date }} at {{ $match->start_hour }}
                                            </div>
                                            <div
                                                class="team-match-status 
                                            @if ($match->status === 'scheduled') scheduled
                                            @elseif ($match->status === 'live') live
                                            @elseif ($match->status === 'completed') completed
                                            @elseif ($match->status === 'canceled') canceled
                                            @elseif ($match->status === 'postponed') postponed
                                            @else unknown @endif">

                                                @switch($match->status)
                                                    @case('scheduled')
                                                        <i class="fas fa-clock"></i> {{ ucfirst($match->status) }}
                                                    @break

                                                    @case('live')
                                                        <i class="fas fa-broadcast-tower"></i> {{ ucfirst($match->status) }}
                                                    @break

                                                    @case('completed')
                                                        <i class="fas fa-check-circle"></i> {{ ucfirst($match->status) }}
                                                    @break

                                                    @case('canceled')
                                                        <i class="fa-solid fa-ban"></i> {{ ucfirst($match->status) }}
                                                    @break

                                                    @case('postponed')
                                                        <i class="fa-solid fa-clock-rotate-left"></i> {{ ucfirst($match->status) }}
                                                    @break

                                                    @default
                                                        <i class="fas fa-question-circle"></i> Unknown
                                                @endswitch
                                            </div>
                                        </div>
                                        <div class="team-match-body">
                                            <div class="team-match-teams">
                                                <div class="team-match-team">
                                                    <img src="{{ asset($match->homeTeam->flag) }}"
                                                        alt="{{ $match->homeTeam->name }}" class="team-match-team-flag">
                                                    <div class="team-match-team-name">{{ $match->homeTeam->name }}</div>
                                                    <div class="team-match-team-score">{{ $match->home_team_goals ?? '0' }}
                                                    </div>
                                                </div>
                                                <div class="team-match-vs">-</div>
                                                <div class="team-match-team">
                                                    <img src="{{ asset($match->awayTeam->flag) }}"
                                                        alt="{{ $match->awayTeam->name }}" class="team-match-team-flag">
                                                    <div class="team-match-team-name">{{ $match->awayTeam->name }}</div>
                                                    <div class="team-match-team-score">{{ $match->home_team_goals ?? '0' }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="team-match-details">
                                                <div class="team-match-detail">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <span>{{ $match->stadium->name }}, {{ $match->stadium->city }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="team-match-footer">
                                            <div
                                                class="team-match-tickets 
                                            @if ($match->status === 'scheduled') scheduled
                                            @elseif ($match->status === 'live') live
                                            @elseif ($match->status === 'completed') completed
                                            @else unknown @endif">

                                                @switch($match->status)
                                                    @case('scheduled')
                                                        <i class="fas fa-ticket-alt"></i> Tickets available
                                                    @break

                                                    @case('live')
                                                        <i class="fas fa-play-circle"></i> Match in progress
                                                    @break

                                                    @case('completed')
                                                        <i class="fas fa-times-circle"></i> Ticket sales closed
                                                    @break

                                                    @default
                                                        <i class="fas fa-question-circle"></i> Unknown status
                                                @endswitch
                                            </div>

                                            <a href="{{ route('games.show', $match->id) }}" class="team-match-btn">Match
                                                Details</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>

                <div class="team-sidebar">
                    <!-- Team Stats -->
                    <div class="team-stats-card">
                        <div class="team-stats-header">
                            <h3 class="team-stats-title">Team Statistics</h3>
                            <div class="team-stats-subtitle">Performance overview</div>
                        </div>
                        <div class="team-stats-body">
                            <div class="team-stat-item">
                                <div class="team-stat-label">Total Matches</div>
                                <div class="team-stat-value">{{ $totalMatches }}</div>
                            </div>
                            <div class="team-stat-item">
                                <div class="team-stat-label">Home Matches</div>
                                <div class="team-stat-value">{{ $homeMatches }}</div>
                            </div>
                            <div class="team-stat-item">
                                <div class="team-stat-label">Away Matches</div>
                                <div class="team-stat-value">{{ $awayMatches }}</div>
                            </div>
                            @php
                                $upcomingCount = \App\Models\Game::where(function ($query) use ($team) {
                                    $query->where('home_team_id', $team->id)->orWhere('away_team_id', $team->id);
                                })
                                    ->where('start_date', '>=', now()->format('Y-m-d'))
                                    ->count();
                            @endphp
                            <div class="team-stat-item">
                                <div class="team-stat-label">Upcoming Matches</div>
                                <div class="team-stat-value">{{ $upcomingCount }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Related Teams -->
                    <div class="related-teams-card">
                        <div class="related-teams-header">
                            <h3 class="related-teams-title">Other Teams</h3>
                            <div class="related-teams-subtitle">Explore more teams</div>
                        </div>
                        <div class="related-teams-body">
                            @php
                                $relatedTeams = \App\Models\Team::where('id', '!=', $team->id)
                                    ->inRandomOrder()
                                    ->take(5)
                                    ->get();
                            @endphp

                            @foreach ($relatedTeams as $relatedTeam)
                                <div class="related-team-item">
                                    <img src="{{ asset($relatedTeam->flag) }}" alt="{{ $relatedTeam->name }}"
                                        class="related-team-flag">
                                    <div class="related-team-info">
                                        <div class="related-team-name">{{ $relatedTeam->name }}</div>
                                        <div class="related-team-matches">
                                            {{ $relatedTeam->homeGames()->count() + $relatedTeam->awayGames()->count() }}
                                            matches
                                        </div>
                                    </div>
                                    <a href="{{ route('teams.show', $relatedTeam->id) }}" class="related-team-link">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
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
