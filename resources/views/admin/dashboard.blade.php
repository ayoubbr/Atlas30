@extends('admin.layout')

@section('title', 'Admin Dashboard - World Cup 2030')

@section('css')
    <style>
        .admin-main {
            grid-area: main;
            padding: 30px;
            overflow-y: auto;
        }

        .stadium-dashboard {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            grid-template-rows: auto auto auto;
            gap: 20px;
            margin-bottom: 30px;
        }

        .stadium-visualization {
            grid-column: span 12;
            background: linear-gradient(135deg, var(--secondary-light), var(--secondary));
            border-radius: var(--border-radius-xl);
            padding: 30px;
            color: white;
            position: relative;
            overflow: hidden;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: var(--shadow-lg);
        }

        .stadium-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            z-index: 2;
        }

        .stadium-title {
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        .stadium-subtitle {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 20px;
        }

        .stadium-actions {
            display: flex;
            gap: 10px;
        }

        .stadium-btn {
            padding: 8px 15px;
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .stadium-btn:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }

        .stadium-btn-primary {
            background-color: var(--primary);
        }

        .stadium-btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .stadium-metrics {
            display: flex;
            gap: 30px;
            z-index: 2;
        }

        .stadium-metric {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: var(--border-radius);
            min-width: 150px;
        }

        .metric-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .metric-label {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .stadium-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.1;
            z-index: 1;
            background-image: url('https://t4.ftcdn.net/jpg/04/17/36/11/360_F_417361125_RnrhT3Np0zB0UpeD7QlwuOoyghEGGjBX.jpg');
            background-size: cover;
            background-position: center;
        }

        /* Quick Stats */
        .quick-stats {
            grid-column: span 12;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .stat-card {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-right: 20px;
            position: relative;
            z-index: 2;
        }

        .stat-icon::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: currentColor;
            opacity: 0.15;
            z-index: -1;
        }

        .stat-icon-matches {
            color: var(--primary);
        }

        .stat-icon-tickets {
            color: var(--success);
        }

        .stat-icon-stadiums {
            color: var(--info);
        }

        .stat-icon-posts {
            color: var(--warning);
        }

        .stat-content {
            flex: 1;
            position: relative;
            z-index: 2;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--gray-800);
        }

        .stat-label {
            font-size: 0.9rem;
            color: var(--gray-600);
        }

        .stat-change {
            display: flex;
            align-items: center;
            font-size: 0.8rem;
            margin-top: 5px;
        }

        .stat-change.positive {
            color: var(--success);
        }

        .stat-change.negative {
            color: var(--danger);
        }

        .stat-change i {
            margin-right: 5px;
        }

        .stat-bg {
            position: absolute;
            bottom: -20px;
            right: -20px;
            font-size: 5rem;
            opacity: 0.05;
            color: var(--gray-800);
        }

        /* Match Management */
        .match-management {
            grid-column: span 12;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .section-header {
            padding: 20px;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .section-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 15px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.9rem;
        }

        .btn:hover {
            background-color: var(--primary-dark);
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background-color: var(--primary);
            color: white;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 0.8rem;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .match-timeline {
            padding: 20px;
            overflow-x: auto;
        }

        .timeline {
            display: flex;
            min-width: 800px;
            flex-wrap: wrap;
            gap: 20px 0
        }

        .timeline-day {
            flex: 1;
            min-width: 300px;
            padding-right: 15px;
        }

        .day-header {
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--gray-200);
        }

        .day-date {
            font-weight: 600;
            color: var(--gray-800);
        }

        .day-name {
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        .match-cards {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center width: 100%;
            gap: 10px;
            min-height: 250px;
        }

        .match-card {
            background-color: var(--gray-100);
            border-radius: var(--border-radius);
            padding: 15px;
            transition: var(--transition);
            cursor: pointer;
            border-left: 3px solid var(--primary);
            min-width: 98%
        }

        .match-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow);
        }

        .match-time {
            font-size: 0.8rem;
            color: var(--gray-600);
            margin-bottom: 10px;
        }

        .match-teams {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .match-team {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .team-flag {
            width: 30px;
            height: 20px;
            margin-bottom: 5px;
            background-size: cover;
            background-position: center;
            border-radius: 2px;
            box-shadow: var(--shadow-sm);
        }

        .team-name {
            font-size: 0.9rem;
            font-weight: 600;
        }

        .match-vs {
            font-weight: 700;
            color: var(--gray-600);
            font-size: 0.8rem;
        }

        .match-venue {
            font-size: 0.8rem;
            color: var(--gray-600);
            margin-bottom: 10px;
        }

        .match-status {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .status-badge {
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .status-upcoming {
            background-color: var(--info-light);
            color: var(--info);
        }

        .status-live {
            background-color: var(--danger-light);
            color: var(--danger);
        }

        .status-completed {
            background-color: var(--success-light);
            color: var(--success);
        }

        .match-actions {
            display: flex;
            gap: 5px;
        }

        /* Ticket Sales */
        .ticket-sales {
            grid-column: span 6;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .ticket-chart-container {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .chart-title {
            font-weight: 600;
        }

        .chart-legend {
            display: flex;
            gap: 15px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 2px;
            margin-right: 5px;
        }

        .chart-container {
            flex: 1;
            position: relative;
        }

        .ticket-stats {
            display: flex;
            border-top: 1px solid var(--gray-200);
        }

        .ticket-stat {
            flex: 1;
            padding: 15px;
            text-align: center;
            border-right: 1px solid var(--gray-200);
        }

        .ticket-stat:last-child {
            border-right: none;
        }

        .ticket-stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .ticket-stat-label {
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        /* Forum Activity */
        .forum-activity {
            grid-column: span 6;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .activity-list {
            padding: 0;
            list-style: none;
        }

        .activity-item {
            padding: 15px 20px;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: flex-start;
            gap: 15px;
            transition: var(--transition);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-item:hover {
            background-color: var(--gray-100);
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .activity-icon-post {
            background-color: var(--warning-light);
            color: var(--warning);
        }

        .activity-icon-user {
            background-color: var(--info-light);
            color: var(--info);
        }

        .activity-icon-report {
            background-color: var(--danger-light);
            color: var(--danger);
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--gray-800);
        }

        .activity-text {
            font-size: 0.9rem;
            color: var(--gray-600);
            margin-bottom: 10px;
        }

        .activity-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8rem;
            color: var(--gray-500);
        }

        .activity-time {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .activity-actions {
            display: flex;
            gap: 10px;
        }

        /* Ticket Sales by Match */
        .ticket-sales-by-match {
            grid-column: span 6;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .match-sales-table {
            width: 100%;
            border-collapse: collapse;
        }

        .match-sales-table th,
        .match-sales-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
        }

        .match-sales-table th {
            background-color: var(--gray-100);
            font-weight: 600;
            color: var(--gray-700);
        }

        .match-sales-table tbody tr:hover {
            background-color: var(--gray-50);
        }

        .match-sales-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Responsive Styles */
        @media (max-width: 1200px) {
            .stadium-dashboard {
                grid-template-columns: repeat(6, 1fr);
            }

            .match-management,
            .ticket-sales,
            .forum-activity,
            .ticket-categories,
            .ticket-sales-by-match {
                grid-column: span 6;
            }
        }

        @media (max-width: 992px) {
            .admin-container {
                grid-template-columns: 1fr;
                grid-template-areas:
                    "header"
                    "main";
            }

            .admin-sidebar {
                position: fixed;
                left: -260px;
                height: 100%;
            }

            .admin-sidebar.show {
                left: 0;
            }

            .menu-toggle {
                display: block;
            }

            .stadium-dashboard {
                grid-template-columns: repeat(3, 1fr);
            }

            .stadium-visualization,
            .match-management,
            .ticket-sales,
            .forum-activity,
            .ticket-categories,
            .ticket-sales-by-match {
                grid-column: span 3;
            }
        }

        @media (max-width: 768px) {
            .stadium-dashboard {
                grid-template-columns: 1fr;
            }

            .stadium-visualization,
            .match-management,
            .ticket-sales,
            .forum-activity,
            .ticket-categories,
            .ticket-sales-by-match {
                grid-column: span 1;
            }

            .stadium-metrics {
                flex-direction: column;
                gap: 15px;
            }

            .quick-stats {
                grid-template-columns: 1fr;
            }

            .header-search {
                display: none;
            }
        }
    </style>
@endsection

@section('content')
    <main class="admin-main">
        <div class="stadium-dashboard">
            <div class="stadium-visualization">
                <div class="stadium-header">
                    <div>
                        <h2 class="stadium-title">World Cup 2030 Dashboard</h2>
                        @auth
                            <div class="stadium-subtitle">Welcome back, {{ Auth::user()->firstname }}! Here's what's happening
                                with the tournament.</div>
                        @endauth
                    </div>
                    <div class="stadium-actions">
                        <a href="{{ route('admin.games.index') }}" class="stadium-btn stadium-btn-primary">
                            Manage Matches
                        </a>
                    </div>
                </div>
                <div class="stadium-bg"></div>
            </div>

            <!-- Quick Stats -->
            <div class="quick-stats">
                <div class="stat-card">
                    <div class="stat-icon stat-icon-matches">
                        <i class="fas fa-futbol"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">{{ $upcomingMatches->count() }}</div>
                        <div class="stat-label">Upcoming Matches</div>
                    </div>
                    <i class="fas fa-futbol stat-bg"></i>
                </div>

                <div class="stat-card">
                    <div class="stat-icon stat-icon-tickets">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">{{ number_format($ticketsSoldThisWeek) }}</div>
                        <div class="stat-label">Tickets Sold This Week</div>
                    </div>
                    <i class="fas fa-ticket-alt stat-bg"></i>
                </div>

                <div class="stat-card">
                    <div class="stat-icon stat-icon-stadiums">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">{{ $stadiumCount }}</div>
                        <div class="stat-label">Stadiums</div>
                    </div>
                    <i class="fas fa-building stat-bg"></i>
                </div>

                <div class="stat-card">
                    <div class="stat-icon stat-icon-posts">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">{{ number_format($forumPostCount) }}</div>
                        <div class="stat-label">Forum Posts</div>
                    </div>
                    <i class="fas fa-comments stat-bg"></i>
                </div>
            </div>

            <!-- Match Management -->
            <div class="match-management">
                <div class="section-header">
                    <h3 class="section-title">Match Schedule</h3>
                    <div class="section-actions">
                        <a href="{{ route('admin.games.index') }}" class="btn">
                            <i class="fas fa-eye"></i> View All
                        </a>
                    </div>
                </div>

                <div class="match-timeline">
                    <div class="timeline">
                        @php
                            $groupedMatches = $upcomingMatches->groupBy(function ($match) {
                                return Carbon\Carbon::parse($match->start_date)->format('Y-m-d');
                            });
                        @endphp

                        @if ($groupedMatches->count() == 0)
                            <div class="timeline-day">
                                <div class="day-header">
                                    <div class="day-date">No upcoming matches!</div>
                                </div>
                            </div>
                        @endif

                        @foreach ($groupedMatches as $date => $matches)
                            <div class="timeline-day">
                                <div class="day-header">
                                    <div class="day-date">{{ Carbon\Carbon::parse($date)->format('M d, Y') }}</div>
                                    <div class="day-name">{{ Carbon\Carbon::parse($date)->format('l') }}</div>
                                </div>

                                <div class="match-cards">
                                    @foreach ($matches as $match)
                                        <div class="match-card">
                                            <div class="match-time">
                                                {{ Carbon\Carbon::parse($match->start_date)->format('H:i') }}
                                                GMT</div>
                                            <div class="match-teams">
                                                <div class="match-team">
                                                    <div class="team-flag"
                                                        style="background-image: url('{{ asset($match->homeTeam->flag) ?? 'https://via.placeholder.com/30x20/e74c3c/ffffff?text=' . substr($match->homeTeam->name, 0, 3) }}')">
                                                    </div>
                                                    <div class="team-name">{{ $match->homeTeam->name }}</div>
                                                </div>
                                                <div class="match-vs">VS</div>
                                                <div class="match-team">
                                                    <div class="team-flag"
                                                        style="background-image: url('{{ asset($match->awayTeam->flag) ?? 'https://via.placeholder.com/30x20/3498db/ffffff?text=' . substr($match->awayTeam->name, 0, 3) }}')">
                                                    </div>
                                                    <div class="team-name">{{ $match->awayTeam->name }}</div>
                                                </div>
                                            </div>
                                            <div class="match-venue">
                                                <i class="fas fa-map-marker-alt"></i> {{ $match->stadium->name }},
                                                {{ $match->stadium->city }}
                                            </div>
                                            <div class="match-status">
                                                <span class="status-badge status-upcoming">upcoming</span>
                                                <div class="match-actions">
                                                    <a href="{{ route('admin.games.index') }}?id={{ $match->id }}"
                                                        class="btn btn-sm btn-icon">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="ticket-sales-by-match">
                <div class="section-header">
                    <h3 class="section-title">Ticket Sales by Match</h3>

                </div>

                <div style="padding: 0 20px 20px;">
                    <div class="table-responsive">
                        <table class="match-sales-table">
                            <thead>
                                <tr>
                                    <th>Match</th>
                                    <th>Date</th>
                                    <th>Stadium</th>
                                    <th>Tickets Sold</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ticketSalesByMatch as $match)
                                    <tr>
                                        <td>{{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}</td>
                                        <td>{{ Carbon\Carbon::parse($match->start_date)->format('M d, Y') }}</td>
                                        <td>{{ $match->stadium->name }}</td>
                                        <td>{{ number_format($match->tickets_count) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Forum Activity -->
            <div class="forum-activity">
                <div class="section-header">
                    <h3 class="section-title">Recent Forum Activity</h3>
                    <div class="section-actions">
                        <a href="{{ route('admin.forum.index') }}" class="btn">
                            <i class="fas fa-eye"></i> View All
                        </a>
                    </div>
                </div>

                <ul class="activity-list">
                    @forelse($recentForumActivity as $post)
                        <li class="activity-item">
                            <div class="activity-icon activity-icon-post">
                                <i class="fas fa-comment-alt"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">{{ $post->user->firstname }} {{ $post->user->lastname }}
                                    posted in "{{ $post->group->name }}"</div>
                                <div class="activity-text">{{ Str::limit($post->content, 100) }}</div>
                                <div class="activity-meta">
                                    <div class="activity-time">
                                        <i class="far fa-clock"></i> {{ $post->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="activity-item">
                            <div class="activity-content">
                                <div class="activity-text">No recent forum activity</div>
                            </div>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </main>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const sidebar = document.querySelector('.admin-sidebar');

            if (menuToggle && sidebar) {
                menuToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }
        });
    </script>
@endsection
