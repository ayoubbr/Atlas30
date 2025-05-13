@extends('admin.layout')

@section('title', 'Team Management - World Cup 2030')

@section('css')
    <style>
        .team-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .team-card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: var(--transition);
        }

        .team-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .team-card-header {
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid var(--gray-200);
        }

        .team-flag {
            width: 60px;
            height: 40px;
            border-radius: 4px;
            background-size: cover;
            background-position: center;
            box-shadow: var(--shadow-sm);
            flex-shrink: 0;
        }

        .team-info {
            flex: 1;
        }

        .team-name {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .team-code {
            font-size: 0.8rem;
            color: var(--gray-600);
            font-weight: 600;
        }

        .team-card-body {
            padding: 20px;
        }

        .team-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .team-detail {
            display: flex;
            flex-direction: column;
        }

        .detail-label {
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        .detail-value {
            font-weight: 600;
            font-size: 0.95rem;
        }

        .team-card-footer {
            padding: 15px 20px;
            border-top: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--gray-50);
        }

        .team-status {
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-qualified {
            color: var(--success);
        }

        .status-pending {
            color: var(--warning);
        }

        .status-eliminated {
            color: var(--danger);
        }

        .team-actions {
            display: flex;
            gap: 10px;
        }

        .team-table-container {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .team-table {
            width: 100%;
            border-collapse: collapse;
        }

        .team-table th,
        .team-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
        }

        .team-table th {
            background-color: var(--gray-100);
            font-weight: 600;
            color: var(--gray-700);
        }

        .team-table th:last-child {
            width: 0px;
        }

        .team-table tbody tr:hover {
            background-color: var(--gray-50);
        }

        .team-table tbody tr:last-child td {
            border-bottom: none;
        }

        .team-table-flag {
            width: 30px;
            height: 20px;
            border-radius: 2px;
            background-size: cover;
            background-position: center;
            margin-right: 10px;
            display: inline-block;
            vertical-align: middle;
        }

        .team-table-name {
            display: flex;
            align-items: center;
            font-weight: 600;
        }

        .team-table-actions {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }

        .player-list {
            max-height: 300px;
            overflow-y: auto;
        }

        .player-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid var(--gray-200);
        }

        .player-item:last-child {
            border-bottom: none;
        }

        .player-photo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--gray-200);
            margin-right: 15px;
            background-size: cover;
            background-position: center;
        }

        .player-info {
            flex: 1;
        }

        .player-name {
            font-weight: 600;
            margin-bottom: 3px;
        }

        .player-position {
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        .player-number {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--primary);
            margin-left: 10px;
        }

        .team-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .team-stats-card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 20px;
            display: flex;
            align-items: center;
            transition: var(--transition);
        }

        .team-stats-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .stats-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-right: 15px;
            position: relative;
        }

        .stats-icon::before {
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

        .stats-icon-teams {
            color: var(--primary);
        }

        .stats-icon-players {
            color: var(--info);
        }

        .stats-icon-matches {
            color: var(--success);
        }

        .stats-icon-groups {
            color: var(--warning);
        }

        .stats-content {
            flex: 1;
        }

        .stats-value {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--gray-800);
        }

        .stats-label {
            font-size: 0.9rem;
            color: var(--gray-600);
        }

        .team-group-section {
            margin-bottom: 30px;
        }

        .group-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .group-title {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .group-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .group-card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .group-card-header {
            padding: 15px;
            background-color: var(--secondary);
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .group-teams {
            padding: 15px;
        }

        .group-team {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid var(--gray-200);
        }

        .group-team:last-child {
            border-bottom: none;
        }

        .group-team-flag {
            width: 30px;
            height: 20px;
            border-radius: 2px;
            background-size: cover;
            background-position: center;
            margin-right: 10px;
        }

        .group-team-name {
            flex: 1;
            font-weight: 500;
        }

        .group-team-points {
            font-weight: 700;
            color: var(--primary);
        }

        .team-search {
            position: relative;
            margin-bottom: 20px;
        }

        .search-input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 1px solid var(--gray-300);
            border-radius: var(--border-radius);
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-500);
            font-size: 1.1rem;
        }

        .team-form-group {
            margin-bottom: 20px;
        }

        .team-form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .team-form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--gray-300);
            border-radius: var(--border-radius);
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
        }

        .team-form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.1);
        }

        .team-form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .team-form-col {
            flex: 1;
        }

        .player-form-list {
            border: 1px solid var(--gray-300);
            border-radius: var(--border-radius);
            margin-bottom: 20px;
        }

        .player-form-header {
            padding: 15px;
            background-color: var(--gray-100);
            border-bottom: 1px solid var(--gray-300);
            font-weight: 600;
        }

        .player-form-body {
            padding: 15px;
        }

        .player-form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            align-items: flex-end;
        }

        .player-form-col {
            flex: 1;
        }

        .player-form-col-small {
            width: 80px;
        }

        .player-form-actions {
            width: 40px;
            display: flex;
            justify-content: center;
        }

        .add-player-btn {
            margin-top: 10px;
        }

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
            z-index: 1000;
        }
    </style>
@endsection

@section('content')
@section('header-title', 'Team Management')
<main class="admin-main">
    <div class="page-header">
        <div>
            <h2 class="page-header-title">Team Management</h2>
            <p class="page-header-description">Manage all participating teams in the World Cup 2030</p>
        </div>
        <div class="page-header-actions">
            <button type="button" class="btn btn-primary" id="addTeamBtn">
                <i class="fas fa-plus"></i> Add Team
            </button>
        </div>
    </div>

    <div class="team-stats">
        <div class="team-stats-card">
            <div class="stats-icon stats-icon-teams">
                <i class="fas fa-flag"></i>
            </div>
            <div class="stats-content">
                <div class="stats-value">{{ $countTeams }}</div>
                <div class="stats-label">Total Teams</div>
            </div>
        </div>

        <div class="team-stats-card">
            <div class="stats-icon stats-icon-matches">
                <i class="fas fa-futbol"></i>
            </div>
            <div class="stats-content">
                <div class="stats-value">{{ $countMatches }}</div>
                <div class="stats-label">Scheduled Matches</div>
            </div>
        </div>

    </div>

    <!-- Team Table -->
    <div class="team-table-container">
        <div class="view-toggle">
            <button class="view-btn active" type="button">
                <i class="fas fa-table"></i> Table View
            </button>
        </div>

        <div class="table-responsive">
            <table class="team-table">
                <thead>
                    <tr>
                        <th>Team</th>
                        <th>flag</th>
                        <th>code</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($teams as $team)
                        <tr>
                            <td>
                                <div class="team-table-name">
                                    {{ $team->name }}
                                </div>
                            </td>
                            <td>
                                <img src="{{ asset($team->flag) }}" alt="{{ $team->name }} flag" width="40"
                                    class="img-thumbnail">
                            </td>
                            <td>
                                <span class="status-badge status-scheduled">{{ $team->code }}</span>
                            </td>
                            <td>
                                <div class="team-table-actions">
                                    <button type="button" class="btn btn-sm btn-outline edit-team-btn"
                                        data-id="{{ $team->id }}" data-name="{{ $team->name }}"
                                        data-code="{{ $team->code }}" data-flag="{{ asset($team->flag) }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline btn-danger delete-team-btn"
                                        data-id="{{ $team->id }}" data-name="{{ $team->name }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="pagination">
            @if ($teams->hasPages())
                <div class="pagination-container">
                    <ul class="pagination">
                        @if ($teams->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">&laquo;</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a href="{{ $teams->previousPageUrl() }}" class="page-link">&laquo;</a>
                            </li>
                        @endif

                        @foreach ($teams->getUrlRange(1, $teams->lastPage()) as $page => $url)
                            @if ($page == $teams->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        @if ($teams->hasMorePages())
                            <li class="page-item">
                                <a href="{{ $teams->nextPageUrl() }}" class="page-link">&raquo;</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">&raquo;</span>
                            </li>
                        @endif
                    </ul>
                </div>
            @endif
        </div>
    </div>
</main>
@endsection

@section('modal')
<!-- Add/Edit Team Modal -->
<div class="modal" id="teamModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="teamModalTitle">Add New Team</h3>
            <button type="button" class="modal-close" id="closeTeamModal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="teamForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="team-form-row">
                    <div class="team-form-col">
                        <div class="team-form-group">
                            <label class="team-form-label" for="teamName">Team Name</label>
                            <input type="text" class="team-form-control" id="teamName" placeholder="Enter team name"
                                name="name" required>
                        </div>
                    </div>
                    <div class="team-form-col">
                        <div class="team-form-group">
                            <label class="team-form-label" for="teamCode">Team Code</label>
                            <input type="text" class="team-form-control" id="teamCode"
                                placeholder="3-letter code (e.g. BRA)" name="code" required>
                        </div>
                    </div>
                </div>
                <div class="team-form-group">
                    <label class="team-form-label" for="teamFlag">Team Flag URL</label>
                    <input type="file" class="team-form-control" id="teamFlag" name="flag" accept="image/*">
                    <img id="flagPreview" src="#" alt="Flag Preview"
                        style="display: none; width: 80px; margin-top: 10px;">

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" id="saveTeamBtn">Save Team</button>
                    <button class="btn btn-outline" type="button" id="cancelTeamBtn">Cancel</button>
                </div>
            </form>
        </div>

    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal" id="deleteTeamModal">
    <div class="modal-content modal-sm">
        <div class="modal-header">
            <h3 class="modal-title">Confirm Delete</h3>
            <button class="modal-close" type="button" id="closeDeleteModal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this team? This action cannot be undone.</p>
            <p><strong>Team: </strong><span id="deleteTeamName">Brazil</span></p>
        </div>
        <form id="deleteTeamForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" id="cancelDeleteBtn">Cancel</button>
                <button type="submit" class="btn btn-danger" id="confirmDeleteBtn">Delete Team</button>
            </div>
        </form>
    </div>
</div>
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

        // Team Modal
        const teamModal = document.getElementById('teamModal');
        const addTeamBtn = document.getElementById('addTeamBtn');
        const closeTeamModal = document.getElementById('closeTeamModal');
        const cancelTeamBtn = document.getElementById('cancelTeamBtn');
        const editTeamBtns = document.querySelectorAll('.edit-team-btn');

        if (addTeamBtn && teamModal) {
            addTeamBtn.addEventListener('click', function() {
                const form = document.getElementById('teamForm');
                document.getElementById('teamModalTitle').textContent = 'Add New Team';
                form.reset();

                form.action = "{{ route('admin.teams.store') }}";
                const methodInput = form.querySelector('input[name="_method"]');

                if (methodInput) methodInput.remove();
                const flagPreview = document.getElementById('flagPreview');

                if (flagPreview) {
                    flagPreview.style.display = 'none';
                    flagPreview.src = '#';
                }

                teamModal.classList.add('show');
            });
        }

        if (closeTeamModal && teamModal) {
            closeTeamModal.addEventListener('click', function() {
                teamModal.classList.remove('show');
            });
        }

        if (cancelTeamBtn && teamModal) {
            cancelTeamBtn.addEventListener('click', function() {
                teamModal.classList.remove('show');
            });
        }

        if (editTeamBtns.length && teamModal) {
            editTeamBtns.forEach(btn => {
                btn.addEventListener('click', function() {

                    const teamId = this.dataset.id;
                    const teamName = this.dataset.name;
                    const teamCode = this.dataset.code;
                    const teamFlag = this.dataset.flag;
                    document.getElementById('teamModalTitle').textContent = 'Edit Team';

                    document.getElementById('teamName').value = teamName;
                    document.getElementById('teamCode').value = teamCode;
                    const flagPreview = document.getElementById('flagPreview');
                    if (flagPreview) {
                        flagPreview.src = teamFlag;
                        flagPreview.style.display = 'block';
                    }

                    teamForm.action = `/admin/teams/${teamId}`;

                    let methodInput = teamForm.querySelector('input[name="_method"]');
                    if (!methodInput) {
                        methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        teamForm.appendChild(methodInput);
                    }
                    methodInput.value = 'PUT';

                    teamModal.classList.add('show');
                });
            });
        }

        // Delete Team Modal
        const deleteTeamModal = document.getElementById('deleteTeamModal');
        const deleteTeamBtns = document.querySelectorAll('.delete-team-btn');
        const closeDeleteModal = document.getElementById('closeDeleteModal');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const deleteTeamForm = document.getElementById('deleteTeamForm');

        if (deleteTeamBtns.length && deleteTeamModal) {
            deleteTeamBtns.forEach(btn => {
                btn.addEventListener('click', function() {

                    const teamId = this.getAttribute('data-id');
                    const teamName = this.getAttribute('data-name');

                    deleteTeamName.textContent = teamName;
                    deleteTeamForm.action = `/admin/teams/${teamId}`;

                    deleteTeamModal.classList.add('show');
                });
            });
        }

        if (closeDeleteModal && deleteTeamModal) {
            closeDeleteModal.addEventListener('click', function() {
                deleteTeamModal.classList.remove('show');
            });
        }

        if (cancelDeleteBtn && deleteTeamModal) {
            cancelDeleteBtn.addEventListener('click', function() {
                deleteTeamModal.classList.remove('show');
            });
        }

        if (confirmDeleteBtn && deleteTeamModal) {
            confirmDeleteBtn.addEventListener('click', function() {
                deleteTeamModal.classList.remove('show');
            });
        }
    });
</script>
@endsection
