@extends('user.layout')

@section('title', 'World Cup 2030 Stadiums')

@section('css')
    <style>
        /* Stadium List Styles */
        .stadium-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
        }

        .stadium-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .stadium-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .stadium-image {
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .stadium-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .stadium-card:hover .stadium-image img {
            transform: scale(1.05);
        }

        .stadium-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 15px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
            color: white;
        }

        .stadium-name {
            font-size: 1.4rem;
            font-weight: 700;
            margin: 0;
            color: rgb(225, 214, 214) !important
        }

        .stadium-location {
            font-size: 0.9rem;
            opacity: 0.9;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .stadium-details {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .stadium-info {
            margin-bottom: 15px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 0.95rem;
        }

        .info-label {
            color: #6c757d;
            font-weight: 500;
        }

        .info-value {
            font-weight: 600;
            color: #1d3557;
        }

        .stadium-games {
            margin-top: auto;
        }

        .games-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .games-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1d3557;
        }

        .games-count {
            background-color: #e63946;
            color: white;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .game-list {
            max-height: 200px;
            overflow-y: auto;
            border-top: 1px solid #e9ecef;
        }

        .game-item {
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .game-item:last-child {
            border-bottom: none;
        }

        .game-date {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .game-teams {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .team {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .team-flag {
            width: 20px;
            height: 15px;
            object-fit: cover;
            border-radius: 2px;
        }

        .game-score {
            background-color: #f8f9fa;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: 700;
        }

        .stadium-footer {
            padding: 15px 20px;
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stadium-action {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #1d3557;
            transition: color 0.3s ease;
        }

        .stadium-action:hover {
            color: #e63946;
        }

        /* Stadium Detail Modal */
        .stadium-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            overflow-y: auto;
            padding: 20px;
        }

        .modal-content {
            background-color: white;
            border-radius: 10px;
            max-width: 900px;
            margin: 50px auto;
            overflow: hidden;
            position: relative;
        }

        .modal-close {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 40px;
            height: 40px;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: background-color 0.3s ease;
        }

        .modal-close:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }

        .modal-header {
            height: 300px;
            position: relative;
        }

        .modal-header img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .modal-header-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 30px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
            color: white;
        }

        .modal-title {
            font-size: 2rem;
            margin-bottom: 5px;
        }

        .modal-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .modal-body {
            padding: 30px;
        }

        .stadium-description {
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .stadium-features {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .feature-icon {
            width: 40px;
            height: 40px;
            background-color: #f1faee;
            color: #1d3557;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .feature-text {
            font-size: 0.95rem;
        }

        .feature-label {
            color: #6c757d;
            margin-bottom: 2px;
        }

        .feature-value {
            font-weight: 600;
            color: #1d3557;
        }

        .modal-section-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: #1d3557;
            padding-bottom: 10px;
            border-bottom: 2px solid #e63946;
            display: inline-block;
        }

        .modal-games {
            margin-bottom: 30px;
        }

        .modal-game-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
        }

        .modal-game-card {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            border: 1px solid #e9ecef;
        }

        .modal-game-date {
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 10px;
        }

        .modal-game-teams {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 10px;
        }

        .modal-team {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-team-flag {
            width: 30px;
            height: 20px;
            object-fit: cover;
            border-radius: 3px;
        }

        .modal-team-name {
            font-weight: 600;
            color: #1d3557;
        }

        .modal-game-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #dee2e6;
            font-size: 0.85rem;
        }

        .modal-game-type {
            background-color: #1d3557;
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .modal-game-status {
            font-weight: 600;
        }

        .status-upcoming {
            color: #2a9d8f;
        }

        .status-completed {
            color: #e63946;
        }

        .modal-map {
            height: 300px;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 30px;
        }

        .modal-map iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .modal-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
            margin-bottom: 30px;
        }

        .gallery-item {
            height: 100px;
            border-radius: 5px;
            overflow: hidden;
            cursor: pointer;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        .modal-footer {
            padding: 20px 30px;
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background-color: #1d3557;
            color: white;
            border-radius: 5px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .modal-action:hover {
            background-color: #152a45;
        }

        /* Filter Section */
        .filter-section {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .filter-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1d3557;
        }

        .filter-reset {
            font-size: 0.9rem;
            color: #e63946;
            cursor: pointer;
        }

        .filter-form {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .filter-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #6c757d;
        }

        .filter-control {
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 0.95rem;
        }

        .filter-control:focus {
            border-color: #1d3557;
            outline: none;
            box-shadow: 0 0 0 3px rgba(29, 53, 87, 0.1);
        }

        .filter-actions {
            grid-column: 1 / -1;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 10px;
        }

        .filter-button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-apply {
            background-color: #1d3557;
            color: white;
        }

        .filter-apply:hover {
            background-color: #152a45;
        }

        .filter-clear {
            background-color: #f8f9fa;
            color: #6c757d;
            border: 1px solid #ced4da;
        }

        .filter-clear:hover {
            background-color: #e9ecef;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .stadium-list {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }

            .filter-form {
                grid-template-columns: 1fr;
            }

            .modal-content {
                margin: 20px;
            }

            .modal-header {
                height: 200px;
            }

            .modal-title {
                font-size: 1.5rem;
            }

            .stadium-features {
                grid-template-columns: 1fr 1fr;
            }

            .modal-game-list {
                grid-template-columns: 1fr;
            }

            .modal-gallery {
                grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            }
        }

        @media (max-width: 576px) {
            .stadium-features {
                grid-template-columns: 1fr;
            }
        }

        /* Utility Classes */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-primary {
            background-color: #1d3557;
            color: white;
        }

        .badge-success {
            background-color: #2a9d8f;
            color: white;
        }

        .badge-danger {
            background-color: #e63946;
            color: white;
        }

        .badge-warning {
            background-color: #ee9b00;
            color: white;
        }

        .badge-info {
            background-color: #457b9d;
            color: white;
        }

        .text-muted {
            color: #6c757d;
        }

        .text-primary {
            color: #1d3557;
        }

        .text-success {
            color: #2a9d8f;
        }

        .text-danger {
            color: #e63946;
        }
    </style>
@endsection

@section('content')
    <section class="page-header">
        <div class="container">
            <h1>World Cup 2030 Stadiums</h1>
            <p>Explore the magnificent venues hosting the World Cup 2030 matches</p>
            <ul class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>Stadiums</li>
            </ul>
        </div>
    </section>

    <div class="container">
        <div class="stadium-list" id="stadiumList">
            @foreach ($stadiums as $stadium)
                <div class="stadium-card" data-city="{{ $stadium->city }}" data-capacity="{{ $stadium->capacity }}">
                    <div class="stadium-image">
                        <img src="{{ asset($stadium->image) }}" alt="{{ $stadium->name }}">
                        <div class="stadium-overlay">
                            <h3 class="stadium-name">{{ $stadium->name }}</h3>
                            <div class="stadium-location">
                                <i class="fas fa-map-marker-alt"></i> {{ $stadium->city }}, {{ $stadium->country }}
                            </div>
                        </div>
                    </div>
                    <div class="stadium-details">
                        <div class="stadium-info">
                            <div class="info-row">
                                <span class="info-label">Capacity</span>
                                <span class="info-value">{{ number_format($stadium->capacity) }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Year Built</span>
                                <span class="info-value">{{ $stadium->year_built }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Total Games</span>
                                <span class="info-value">{{ $stadium->games->count() }}</span>
                            </div>
                        </div>
                        <div class="stadium-games">
                            <div class="games-header">
                                <h4 class="games-title">Upcoming Games</h4>
                                <span
                                    class="games-count">{{ $stadium->games->where('start_date', '>=', date('Y-m-d'))->count() }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="stadium-footer">
                        <a href="#" class="stadium-action view-stadium-details"
                            data-stadium-id="{{ $stadium->id }}">
                            <i class="fas fa-info-circle"></i> Stadium Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @foreach ($stadiums as $stadium)
        <div class="stadium-modal" id="stadiumModal{{ $stadium->id }}">
            <div class="modal-content">
                <div class="modal-close" onclick="closeStadiumModal({{ $stadium->id }})">
                    <i class="fas fa-times"></i>
                </div>
                <div class="modal-header">
                    <img src="{{ asset($stadium->image) }}" alt="{{ $stadium->name }}">
                    <div class="modal-header-content">
                        <h2 class="modal-title">{{ $stadium->name }}</h2>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="stadium-features">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="feature-text">
                                <div class="feature-label">Capacity</div>
                                <div class="feature-value">{{ number_format($stadium->capacity) }}</div>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-futbol"></i>
                            </div>
                            <div class="feature-text">
                                <div class="feature-label">Total Games</div>
                                <div class="feature-value">{{ $stadium->games->count() }}</div>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="feature-text">
                                <div class="feature-label">Upcoming Games</div>
                                <div class="feature-value">
                                    {{ $stadium->games->where('start_date', '>=', date('Y-m-d'))->count() }}</div>
                            </div>
                        </div>
                    </div>

                    <h3 class="modal-section-title">Upcoming Games</h3>
                    <div class="modal-games">
                        <div class="modal-game-list">
                            @php
                                $upcomingGames = $stadium->games->where('start_date', '>=', date('Y-m-d'))->take(6);
                            @endphp

                            @if ($upcomingGames->count() > 0)
                                @foreach ($upcomingGames as $game)
                                    <div class="modal-game-card">
                                        <div class="modal-game-date">
                                            <i class="far fa-calendar-alt"></i>
                                            {{ \Carbon\Carbon::parse($game->start_date)->format('d M Y') }} •
                                            {{ $game->start_hour }}
                                        </div>
                                        <div class="modal-game-teams">
                                            <div class="modal-team">
                                                <img src="{{ asset($game->homeTeam->flag) }}"
                                                    alt="{{ $game->homeTeam->name }}" class="modal-team-flag">
                                                <span class="modal-team-name">{{ $game->homeTeam->name }}</span>
                                            </div>
                                            <div class="modal-team">
                                                <img src="{{ asset($game->awayTeam->flag) }}"
                                                    alt="{{ $game->awayTeam->name }}" class="modal-team-flag">
                                                <span class="modal-team-name">{{ $game->awayTeam->name }}</span>
                                            </div>
                                        </div>
                                        <div class="modal-game-info">
                                            <span class="modal-game-status status-upcoming">Upcoming</span>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-muted text-center" style="grid-column: 1 / -1; padding: 20px;">
                                    No upcoming games scheduled at this stadium
                                </div>
                            @endif
                        </div>
                    </div>

                    <h3 class="modal-section-title">Past Games</h3>
                    <div class="modal-games">
                        <div class="modal-game-list">
                            @php
                                $pastGames = $stadium->games->where('start_date', '<', date('Y-m-d'))->take(6);
                            @endphp

                            @if ($pastGames->count() > 0)
                                @foreach ($pastGames as $game)
                                    <div class="modal-game-card">
                                        <div class="modal-game-date">
                                            <i class="far fa-calendar-alt"></i>
                                            {{ \Carbon\Carbon::parse($game->start_date)->format('d M Y') }} •
                                            {{ $game->start_hour }}
                                        </div>
                                        <div class="modal-game-teams">
                                            <div class="modal-team">
                                                <img src="{{ asset($game->homeTeam->flag) }}"
                                                    alt="{{ $game->homeTeam->name }}" class="modal-team-flag">
                                                <span class="modal-team-name">{{ $game->homeTeam->name }}</span>
                                            </div>
                                            <div class="modal-team">
                                                <img src="{{ asset($game->awayTeam->flag) }}"
                                                    alt="{{ $game->awayTeam->name }}" class="modal-team-flag">
                                                <span class="modal-team-name">{{ $game->awayTeam->name }}</span>
                                            </div>
                                        </div>
                                        <div class="modal-game-info">
                                            <span class="modal-game-status status-completed">
                                                {{ $game->home_team_goals }} - {{ $game->away_team_goals }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-muted text-center" style="grid-column: 1 / -1; padding: 20px;">
                                    No past games played at this stadium
                                </div>
                            @endif
                        </div>
                    </div>


                </div>
            </div>
        </div>
    @endforeach

@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const viewButtons = document.querySelectorAll('.view-stadium-details');
            viewButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const stadiumId = this.getAttribute('data-stadium-id');
                    openStadiumModal(stadiumId);
                });
            });

        });

        function openStadiumModal(stadiumId) {
            const modal = document.getElementById('stadiumModal' + stadiumId);
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeStadiumModal(stadiumId) {
            const modal = document.getElementById('stadiumModal' + stadiumId);
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        window.addEventListener('click', function(event) {
            const modals = document.querySelectorAll('.stadium-modal');
            modals.forEach(modal => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            });
        });
    </script>
@endsection
