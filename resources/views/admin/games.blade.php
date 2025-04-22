@extends('admin.layout')

@section('title', 'Match Management - World Cup 2030')
@section('css')
    <style>
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 100;
        }

        .modal.show {
            display: flex;
        }

        /* Match Card Styles */
        .match-cards-view {
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .match-card {
            display: flex;
            flex-direction: column;
            padding: 0;
            overflow: hidden;
            border-left: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            background-color: white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .match-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .match-date {
            padding: 10px 15px;
            background-color: var(--gray-100);
            color: var(--gray-700);
            font-size: 0.9rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .match-teams {
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .match-team {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            width: 40%;
        }

        .team-flag {
            width: 60px;
            height: 40px;
            background-size: cover;
            background-position: center;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .team-name {
            font-weight: 600;
            color: var(--secondary);
            text-align: center;
        }

        .match-vs {
            font-weight: 600;
            color: var(--gray-500);
        }

        .match-score {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary);
        }

        .match-venue {
            padding: 10px 15px;
            color: var(--gray-700);
            font-size: 0.9rem;
            border-top: 1px solid var(--gray-200);
        }

        .match-info {
            padding: 10px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid var(--gray-200);
        }

        .match-stage {
            font-size: 0.9rem;
            color: var(--gray-700);
            font-weight: 600;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-scheduled {
            background-color: var(--info-light);
            color: var(--info);
        }

        .status-live {
            background-color: var(--success-light);
            color: var(--success);
        }

        .status-completed {
            background-color: var(--gray-200);
            color: var(--gray-700);
        }

        .status-postponed {
            background-color: var(--warning-light);
            color: var(--warning);
        }

        .status-cancelled {
            background-color: var(--danger-light);
            color: var(--danger);
        }

        .match-notes {
            padding: 10px 15px;
            font-size: 0.9rem;
            color: var(--gray-600);
            border-top: 1px solid var(--gray-200);
            font-style: italic;
        }

        .match-actions {
            padding: 10px 15px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            /* border-top: 1px solid var(--gray-200); */
        }

        /* Table View Styles */
        .match-table-view {
            padding: 20px;
        }

        .match-table {
            width: 100%;
            border-collapse: collapse;
        }

        .match-table th,
        .match-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
        }

        .match-table th {
            background-color: var(--gray-100);
            font-weight: 600;
        }

        .table-teams {
            display: flex;
            align-items: center;
        }

        .table-team {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .table-flag {
            width: 30px;
            height: 20px;
            background-size: cover;
            background-position: center;
            border-radius: 2px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        /* Filters */
        .match-filters {
            padding: 20px;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
            justify-content: end;
        }

        .filter-select {
            padding: 8px 12px;
            border: 1px solid var(--gray-300);
            border-radius: var(--border-radius);
            background-color: white;
            min-width: 150px;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            gap: 10px;
        }

        .pagination-btn {
            padding: 8px 16px;
            border: 1px solid var(--gray-300);
            background-color: white;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .pagination-btn:hover:not(:disabled) {
            background-color: var(--primary);
            color: white;
        }

        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pagination-info {
            font-size: 0.9rem;
            color: var(--gray-600);
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .match-filters {
                flex-direction: column;
            }

            .match-cards-view {
                grid-template-columns: 1fr;
            }

            .match-teams {
                flex-direction: column;
                gap: 15px;
            }

            .match-team {
                width: 100%;
            }

            .table-teams {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
        }
    </style>
@endsection

@section('content')
@section('header-title', 'Game Management')
<main class="admin-main">
    <div class="page-header">
        <div class="page-header-content">
            <h2 class="page-header-title">Match Management</h2>
            <p class="page-header-description">Create, edit, and manage all World Cup 2030 matches</p>
        </div>
        <div class="page-header-actions">
            <button class="btn btn-primary" id="add-match-btn">
                <i class="fas fa-plus"></i> Add New Match
            </button>
        </div>
    </div>

    <div class="match-filters">
        <div class="filter-group">
            <label for="filter-team">Team:</label>
            <select id="filter-team" class="filter-select">
                <option value="all">All Teams</option>
                @foreach ($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <label for="filter-stadium">Stadium:</label>
            <select id="filter-stadium" class="filter-select">
                <option value="all">All Stadiums</option>
                @foreach ($stadiums as $stadium)
                    <option value="{{ $stadium->id }}">{{ $stadium->name }}, {{ $stadium->city }}</option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <label for="filter-status">Status:</label>
            <select id="filter-status" class="filter-select">
                <option value="all">All Statuses</option>
                <option value="scheduled">Scheduled</option>
                <option value="live">Live</option>
                <option value="completed">Completed</option>
                <option value="postponed">Postponed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>

        <div class="filter-group">
            <button class="btn btn-outline" id="reset-filters">
                <i class="fas fa-undo"></i> Reset Filters
            </button>
        </div>
    </div>

    <!-- Match List -->
    <div class="match-list-container">
        <div class="view-toggle">
            <button class="view-btn active" data-view="card">
                <i class="fas fa-th-large"></i> Card View
            </button>
            <button class="view-btn" data-view="table">
                <i class="fas fa-list"></i> Table View
            </button>
        </div>

        <!-- Card View -->
        <div class="match-cards-view" id="match-cards-view">
            @if ($games->isEmpty())
                <div class="no-matches">No matches found. Try adjusting your filters.</div>
            @else
                @foreach ($games as $game)
                    <div class="match-card" data-team-home="{{ $game->home_team_id }}"
                        data-team-away="{{ $game->away_team_id }}" data-stadium="{{ $game->stadium_id }}"
                        data-status="{{ $game->status }}">
                        <div class="match-date">
                            <i class="far fa-calendar-alt"></i> {{ date('l, F j, Y', strtotime($game->start_date)) }} -
                            {{ date('g:i A', strtotime($game->start_hour)) }}
                        </div>
                        <div class="match-teams">
                            <div class="match-team">
                                <div class="team-flag"
                                    style="background-image: url('{{ asset($game->homeTeam->flag) }}')"></div>
                                <div class="team-name">{{ $game->homeTeam->name }}</div>
                            </div>
                            @if ($game->status === 'completed' || $game->status === 'live')
                                <div class="match-score">
                                    <span>{{ $game->home_team_goals }}</span>
                                    <span>-</span>
                                    <span>{{ $game->away_team_goals }}</span>
                                </div>
                            @else
                                <div class="match-vs">VS</div>
                            @endif
                            <div class="match-team">
                                <div class="team-flag"
                                    style="background-image: url('{{ asset($game->awayTeam->flag) }}')"></div>
                                <div class="team-name">{{ $game->awayTeam->name }}</div>
                            </div>
                        </div>
                        <div class="match-venue">
                            <i class="fas fa-map-marker-alt"></i> {{ $game->stadium->name }},
                            {{ $game->stadium->city }}
                        </div>
                        <div class="match-info">
                            <div class="match-stage">World Cup 2030</div>
                            <div class="status-badge status-{{ $game->status }}">{{ ucfirst($game->status) }}</div>
                        </div>
                        <div class="match-actions">
                            <button class="btn btn-sm btn-outline edit-match-btn" data-id="{{ $game->id }}"
                                data-start-date="{{ $game->start_date }}" data-start-hour="{{ $game->start_hour }}"
                                data-home-team="{{ $game->home_team_id }}" data-away-team="{{ $game->away_team_id }}"
                                data-stadium="{{ $game->stadium_id }}" data-status="{{ $game->status }}"
                                data-home-goals="{{ $game->home_team_goals }}"
                                data-away-goals="{{ $game->away_team_goals }}" data-image="{{ $game->image }}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger delete-match-btn" data-id="{{ $game->id }}">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Table View (hidden by default) -->
        <div class="match-table-view" id="match-table-view" style="display: none;">
            <table class="match-table">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Teams</th>
                        <th>Stadium</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="match-table-body">
                    @forelse ($games as $game)
                        <tr data-team-home="{{ $game->home_team_id }}" data-team-away="{{ $game->away_team_id }}"
                            data-stadium="{{ $game->stadium_id }}" data-status="{{ $game->status }}">
                            <td>
                                {{ date('M j, Y', strtotime($game->start_date)) }}<br>
                                <span
                                    style="color: var(--gray-600);">{{ date('g:i A', strtotime($game->start_hour)) }}</span>
                            </td>
                            <td>
                                <div class="table-teams">
                                    <div class="table-team">
                                        <div class="table-flag"
                                            style="background-image: url('{{ asset($game->homeTeam->flag) }}')"></div>
                                        <span>{{ $game->homeTeam->name }}</span>
                                    </div>
                                    @if ($game->status === 'completed' || $game->status === 'live')
                                        <div style="margin: 0 10px; font-weight: 600;">{{ $game->home_team_goals }} -
                                            {{ $game->away_team_goals }}</div>
                                    @else
                                        <div style="margin: 0 10px;">vs</div>
                                    @endif
                                    <div class="table-team">
                                        <div class="table-flag"
                                            style="background-image: url('{{ asset($game->awayTeam->flag) }}')"></div>
                                        <span>{{ $game->awayTeam->name }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $game->stadium->name }}, {{ $game->stadium->city }}</td>
                            <td><span
                                    class="status-badge status-{{ $game->status }}">{{ ucfirst($game->status) }}</span>
                            </td>
                            <td>
                                <div class="match-actions">
                                    <button class="btn btn-sm btn-outline edit-match-btn"
                                        data-id="{{ $game->id }}" data-start-date="{{ $game->start_date }}"
                                        data-start-hour="{{ $game->start_hour }}"
                                        data-home-team="{{ $game->home_team_id }}"
                                        data-away-team="{{ $game->away_team_id }}"
                                        data-stadium="{{ $game->stadium_id }}" data-status="{{ $game->status }}"
                                        data-home-goals="{{ $game->home_team_goals }}"
                                        data-away-goals="{{ $game->away_team_goals }}"
                                        data-image="{{ $game->image }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-match-btn"
                                        data-id="{{ $game->id }}">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 30px;">
                                No matches found. Try adjusting your filters.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection

@section('modal')
<!-- Add/Edit Match Modal -->
<div class="modal" id="match-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="modal-title">Add New Match</h3>
            <button class="modal-close" id="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="match-form" method="POST" action="{{ route('admin.games.store') }}"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">

                <div class="form-row">
                    <div class="form-group">
                        <label for="start_date">Date</label>
                        <input type="date" id="start_date" name="start_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="start_hour">Time</label>
                        <input type="time" id="start_hour" name="start_hour" class="form-control" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="home_team_id">Home Team</label>
                        <select id="home_team_id" name="home_team_id" class="form-control" required>
                            <option value="">Select Team</option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="away_team_id">Away Team</label>
                        <select id="away_team_id" name="away_team_id" class="form-control" required>
                            <option value="">Select Team</option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="stadium_id">Stadium</label>
                    <select id="stadium_id" name="stadium_id" class="form-control" required>
                        <option value="">Select Stadium</option>
                        @foreach ($stadiums as $stadium)
                            <option value="{{ $stadium->id }}">{{ $stadium->name }}, {{ $stadium->city }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control" required>
                            <option value="scheduled">Scheduled</option>
                            <option value="live">Live</option>
                            <option value="completed">Completed</option>
                            <option value="postponed">Postponed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>

                <div class="form-row score-inputs" style="display: none;">
                    <div class="form-group">
                        <label for="home_team_goals">Home Team Score</label>
                        <input type="number" id="home_team_goals" name="home_team_goals" class="form-control"
                            min="0" value="0">
                    </div>
                    <div class="form-group">
                        <label for="away_team_goals">Away Team Score</label>
                        <input type="number" id="away_team_goals" name="away_team_goals" class="form-control"
                            min="0" value="0">
                    </div>
                </div>

                <div class="form-group">
                    <label for="image">Match Image</label>
                    <input type="file" id="image" name="image" class="form-control" accept="image/*">
                    <div class="form-text" id="image-help-text">Upload an image for the match (optional)</div>
                    <img id="image-preview" src="#" alt="Image Preview"
                        style="display: none; max-width: 100%; margin-top: 10px;">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" id="cancel-btn">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Match</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal" id="delete-modal">
    <div class="modal-content modal-sm">
        <div class="modal-header">
            <h3 class="modal-title">Confirm Delete</h3>
            <button class="modal-close" id="delete-modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this match? This action cannot be undone.</p>
            <form id="delete-form" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" id="cancel-delete-btn">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Match</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addMatchBtn = document.getElementById('add-match-btn');
        const matchModal = document.getElementById('match-modal');
        const modalClose = document.getElementById('modal-close');
        const cancelBtn = document.getElementById('cancel-btn');
        const matchForm = document.getElementById('match-form');
        const deleteModal = document.getElementById('delete-modal');
        const deleteModalClose = document.getElementById('delete-modal-close');
        const cancelDeleteBtn = document.getElementById('cancel-delete-btn');
        const deleteForm = document.getElementById('delete-form');
        const matchCardsView = document.getElementById('match-cards-view');
        const matchTableView = document.getElementById('match-table-view');
        const matchTableBody = document.getElementById('match-table-body');
        const viewBtns = document.querySelectorAll('.view-btn');
        const statusSelect = document.getElementById('status');
        const scoreInputs = document.querySelector('.score-inputs');
        const filterTeam = document.getElementById('filter-team');
        const filterStadium = document.getElementById('filter-stadium');
        const filterStatus = document.getElementById('filter-status');
        const resetFiltersBtn = document.getElementById('reset-filters');
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');

        // Add event listeners for all edit buttons
        document.querySelectorAll('.edit-match-btn').forEach(button => {
            button.addEventListener('click', function() {
                const gameId = this.getAttribute('data-id');
                openEditMatchModal(this);
            });
        });

        // Add event listeners for all delete buttons
        document.querySelectorAll('.delete-match-btn').forEach(button => {
            button.addEventListener('click', function() {
                const gameId = this.getAttribute('data-id');
                openDeleteModal(gameId);
            });
        });

        addMatchBtn.addEventListener('click', function() {
            openAddMatchModal();
        });

        modalClose.addEventListener('click', function() {
            closeMatchModal();
        });

        cancelBtn.addEventListener('click', function() {
            closeMatchModal();
        });

        deleteModalClose.addEventListener('click', function() {
            closeDeleteModal();
        });

        cancelDeleteBtn.addEventListener('click', function() {
            closeDeleteModal();
        });

        viewBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const view = this.getAttribute('data-view');
                changeView(view);
            });
        });

        statusSelect.addEventListener('change', function() {
            toggleScoreInputs();
        });

        filterTeam.addEventListener('change', function() {
            filterMatches();
        });

        filterStadium.addEventListener('change', function() {
            filterMatches();
        });

        filterStatus.addEventListener('change', function() {
            filterMatches();
        });

        resetFiltersBtn.addEventListener('click', function() {
            resetFilters();
        });

        imageInput.addEventListener('change', function() {
            previewImage(this);
        });

        // Functions
        function changeView(view) {
            viewBtns.forEach(btn => {
                if (btn.getAttribute('data-view') === view) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });

            if (view === 'card') {
                matchCardsView.style.display = 'grid';
                matchTableView.style.display = 'none';
            } else {
                matchCardsView.style.display = 'none';
                matchTableView.style.display = 'block';
            }
        }

        function openAddMatchModal() {
            matchForm.reset();
            document.getElementById('form-method').value = 'POST';
            document.getElementById('modal-title').textContent = 'Add New Match';
            matchForm.action = "{{ route('admin.games.store') }}";

            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            document.getElementById('start_date').value = tomorrow.toISOString().split('T')[0];

            scoreInputs.style.display = 'none';
            imagePreview.style.display = 'none';

            matchModal.classList.add('show');
        }

        function openEditMatchModal(button) {
            const gameId = button.getAttribute('data-id');
            const startDate = button.getAttribute('data-start-date');
            const startHour = button.getAttribute('data-start-hour');
            const homeTeam = button.getAttribute('data-home-team');
            const awayTeam = button.getAttribute('data-away-team');
            const stadium = button.getAttribute('data-stadium');
            const status = button.getAttribute('data-status');
            const homeGoals = button.getAttribute('data-home-goals');
            const awayGoals = button.getAttribute('data-away-goals');
            const image = button.getAttribute('data-image');

            document.getElementById('form-method').value = 'PUT';
            document.getElementById('modal-title').textContent = 'Edit Match';
            matchForm.action = "{{ url('admin/games') }}/" + gameId;

            document.getElementById('start_date').value = startDate;
            document.getElementById('start_hour').value = startHour;
            document.getElementById('home_team_id').value = homeTeam;
            document.getElementById('away_team_id').value = awayTeam;
            document.getElementById('stadium_id').value = stadium;
            document.getElementById('status').value = status;
            document.getElementById('home_team_goals').value = homeGoals;
            document.getElementById('away_team_goals').value = awayGoals;

            // Show/hide score inputs based on status
            toggleScoreInputs();

            if (image && image !== 'null') {
                imagePreview.src = "{{ asset('') }}" + image;
                imagePreview.style.display = 'block';
            } else {
                imagePreview.style.display = 'none';
            }

            matchModal.classList.add('show');
        }

        function closeMatchModal() {
            matchModal.classList.remove('show');
        }

        function openDeleteModal(gameId) {
            deleteForm.action = "{{ url('admin/games') }}/" + gameId;
            deleteModal.classList.add('show');
        }

        function closeDeleteModal() {
            deleteModal.classList.remove('show');
        }

        function toggleScoreInputs() {
            const status = statusSelect.value;
            if (status === 'completed' || status === 'live') {
                scoreInputs.style.display = 'flex';
            } else {
                scoreInputs.style.display = 'none';
            }
        }

        function filterMatches() {
            const teamFilter = filterTeam.value;
            const stadiumFilter = filterStadium.value;
            const statusFilter = filterStatus.value;

            // Filter card view
            const cards = document.querySelectorAll('#match-cards-view .match-card');
            cards.forEach(card => {
                const homeTeamId = card.getAttribute('data-team-home');
                const awayTeamId = card.getAttribute('data-team-away');
                const stadiumId = card.getAttribute('data-stadium');
                const status = card.getAttribute('data-status');

                const teamMatch = teamFilter === 'all' || homeTeamId === teamFilter || awayTeamId ===
                    teamFilter;
                const stadiumMatch = stadiumFilter === 'all' || stadiumId === stadiumFilter;
                const statusMatch = statusFilter === 'all' || status === statusFilter;

                if (teamMatch && stadiumMatch && statusMatch) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });

            // Filter table view
            const rows = document.querySelectorAll('#match-table-body tr');
            rows.forEach(row => {
                const homeTeamId = row.getAttribute('data-team-home');
                const awayTeamId = row.getAttribute('data-team-away');
                const stadiumId = row.getAttribute('data-stadium');
                const status = row.getAttribute('data-status');

                const teamMatch = teamFilter === 'all' || homeTeamId === teamFilter || awayTeamId ===
                    teamFilter;
                const stadiumMatch = stadiumFilter === 'all' || stadiumId === stadiumFilter;
                const statusMatch = statusFilter === 'all' || status === statusFilter;

                if (teamMatch && stadiumMatch && statusMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            // Check if no matches are visible
            checkNoMatches();
        }

        function resetFilters() {
            filterTeam.value = 'all';
            filterStadium.value = 'all';
            filterStatus.value = 'all';

            // Show all matches
            const cards = document.querySelectorAll('#match-cards-view .match-card');
            cards.forEach(card => {
                card.style.display = '';
            });

            const rows = document.querySelectorAll('#match-table-body tr');
            rows.forEach(row => {
                row.style.display = '';
            });

            // Remove no matches message if it exists
            const noMatchesCard = document.querySelector('.no-matches');
            if (noMatchesCard) {
                noMatchesCard.remove();
            }

            const noMatchesTable = document.querySelector('#match-table-body .no-matches-row');
            if (noMatchesTable) {
                noMatchesTable.remove();
            }
        }

        function checkNoMatches() {
            // Check card view
            const visibleCards = Array.from(document.querySelectorAll('#match-cards-view .match-card')).filter(
                card => card.style.display !== 'none');
            if (visibleCards.length === 0 && !document.querySelector('#match-cards-view .no-matches')) {
                const noMatches = document.createElement('div');
                noMatches.className = 'no-matches';
                noMatches.textContent = 'No matches found. Try adjusting your filters.';
                matchCardsView.appendChild(noMatches);
            } else if (visibleCards.length > 0) {
                const noMatches = document.querySelector('#match-cards-view .no-matches');
                if (noMatches) {
                    noMatches.remove();
                }
            }

            // Check table view
            const visibleRows = Array.from(document.querySelectorAll('#match-table-body tr')).filter(row => row
                .style.display !== 'none');
            if (visibleRows.length === 0 && !document.querySelector('#match-table-body .no-matches-row')) {
                const noMatchesRow = document.createElement('tr');
                noMatchesRow.className = 'no-matches-row';
                noMatchesRow.innerHTML =
                    '<td colspan="5" style="text-align: center; padding: 30px;">No matches found. Try adjusting your filters.</td>';
                matchTableBody.appendChild(noMatchesRow);
            } else if (visibleRows.length > 0) {
                const noMatchesRow = document.querySelector('#match-table-body .no-matches-row');
                if (noMatchesRow) {
                    noMatchesRow.remove();
                }
            }
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    });
</script>
@endsection
