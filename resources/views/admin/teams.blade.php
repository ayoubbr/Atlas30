@extends('admin.layout')

@section('title', 'Team Management - World Cup 2030')

@section('css')
    <style>
        /* Team-specific styles */
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
    <!-- Header -->
    <header class="admin-header">
        <div class="header-left">
            <div class="menu-toggle" id="menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
            <h1 class="page-title">Team Management</h1>
        </div>

        <div class="header-right">
            <div class="header-search">
                <input type="text" class="search-input" placeholder="Search teams...">
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
                    <img src="https://via.placeholder.com/40x40" alt="Admin Avatar">
                </div>
                <div class="user-info">
                    <div class="user-name">John Doe</div>
                    <div class="user-role">Administrator</div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="admin-main">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="page-header-title">Team Management</h2>
                <p class="page-header-description">Manage all participating teams in the World Cup 2030</p>
            </div>
            <div class="page-header-actions">
                <button class="btn btn-outline" id="importTeamsBtn">
                    <i class="fas fa-file-import"></i> Import Teams
                </button>
                <button class="btn btn-primary" id="addTeamBtn">
                    <i class="fas fa-plus"></i> Add Team
                </button>
            </div>
        </div>

        <!-- Team Stats -->
        <div class="team-stats">
            <div class="team-stats-card">
                <div class="stats-icon stats-icon-teams">
                    <i class="fas fa-flag"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-value">32</div>
                    <div class="stats-label">Total Teams</div>
                </div>
            </div>

            <div class="team-stats-card">
                <div class="stats-icon stats-icon-players">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-value">736</div>
                    <div class="stats-label">Total Players</div>
                </div>
            </div>

            <div class="team-stats-card">
                <div class="stats-icon stats-icon-matches">
                    <i class="fas fa-futbol"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-value">64</div>
                    <div class="stats-label">Scheduled Matches</div>
                </div>
            </div>

            <div class="team-stats-card">
                <div class="stats-icon stats-icon-groups">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-value">8</div>
                    <div class="stats-label">Groups</div>
                </div>
            </div>
        </div>

        <!-- Team Filters -->
        <div class="match-filters">
            <div class="filter-group">
                <label for="confederation-filter">Confederation</label>
                <select id="confederation-filter" class="filter-select">
                    <option value="">All Confederations</option>
                    <option value="UEFA">UEFA (Europe)</option>
                    <option value="CONMEBOL">CONMEBOL (South America)</option>
                    <option value="CONCACAF">CONCACAF (North America)</option>
                    <option value="CAF">CAF (Africa)</option>
                    <option value="AFC">AFC (Asia)</option>
                    <option value="OFC">OFC (Oceania)</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="group-filter">Group</label>
                <select id="group-filter" class="filter-select">
                    <option value="">All Groups</option>
                    <option value="A">Group A</option>
                    <option value="B">Group B</option>
                    <option value="C">Group C</option>
                    <option value="D">Group D</option>
                    <option value="E">Group E</option>
                    <option value="F">Group F</option>
                    <option value="G">Group G</option>
                    <option value="H">Group H</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="status-filter">Status</label>
                <select id="status-filter" class="filter-select">
                    <option value="">All Statuses</option>
                    <option value="qualified">Qualified</option>
                    <option value="pending">Pending Qualification</option>
                    <option value="eliminated">Eliminated</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="sort-filter">Sort By</label>
                <select id="sort-filter" class="filter-select">
                    <option value="name">Team Name</option>
                    <option value="rank">FIFA Ranking</option>
                    <option value="group">Group</option>
                    <option value="confederation">Confederation</option>
                </select>
            </div>

            <div class="filter-group" style="display: flex; align-items: flex-end;">
                <button class="btn btn-primary">
                    <i class="fas fa-filter"></i> Apply Filters
                </button>
            </div>
        </div>

        <!-- Team Table -->
        <div class="team-table-container">
            <div class="view-toggle">
                <button class="view-btn active">
                    <i class="fas fa-table"></i> Table View
                </button>
                <button class="view-btn">
                    <i class="fas fa-th-large"></i> Card View
                </button>
            </div>

            <div class="table-responsive">
                <table class="team-table">
                    <thead>
                        <tr>
                            <th>Team</th>
                            <th>Group</th>
                            <th>FIFA Rank</th>
                            <th>Confederation</th>
                            <th>Coach</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="team-table-name">
                                    <div class="team-table-flag"
                                        style="background-image: url('https://via.placeholder.com/30x20/3498db/ffffff?text=BRA')">
                                    </div>
                                    Brazil
                                </div>
                            </td>
                            <td>Group A</td>
                            <td>1</td>
                            <td>CONMEBOL</td>
                            <td>Carlos Amaral</td>
                            <td><span class="status-badge status-scheduled">Qualified</span></td>
                            <td>
                                <div class="team-table-actions">
                                    <button class="btn btn-sm btn-outline view-team-btn" data-id="1">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline edit-team-btn" data-id="1">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline btn-danger delete-team-btn" data-id="1">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="team-table-name">
                                    <div class="team-table-flag"
                                        style="background-image: url('https://via.placeholder.com/30x20/e74c3c/ffffff?text=GER')">
                                    </div>
                                    Germany
                                </div>
                            </td>
                            <td>Group A</td>
                            <td>2</td>
                            <td>UEFA</td>
                            <td>Hans Mueller</td>
                            <td><span class="status-badge status-scheduled">Qualified</span></td>
                            <td>
                                <div class="team-table-actions">
                                    <button class="btn btn-sm btn-outline view-team-btn" data-id="2">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline edit-team-btn" data-id="2">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline btn-danger delete-team-btn" data-id="2">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="team-table-name">
                                    <div class="team-table-flag"
                                        style="background-image: url('https://via.placeholder.com/30x20/f39c12/ffffff?text=ESP')">
                                    </div>
                                    Spain
                                </div>
                            </td>
                            <td>Group B</td>
                            <td>3</td>
                            <td>UEFA</td>
                            <td>Miguel Rodriguez</td>
                            <td><span class="status-badge status-scheduled">Qualified</span></td>
                            <td>
                                <div class="team-table-actions">
                                    <button class="btn btn-sm btn-outline view-team-btn" data-id="3">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline edit-team-btn" data-id="3">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline btn-danger delete-team-btn" data-id="3">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="team-table-name">
                                    <div class="team-table-flag"
                                        style="background-image: url('https://via.placeholder.com/30x20/2ecc71/ffffff?text=POR')">
                                    </div>
                                    Portugal
                                </div>
                            </td>
                            <td>Group B</td>
                            <td>4</td>
                            <td>UEFA</td>
                            <td>José Silva</td>
                            <td><span class="status-badge status-scheduled">Qualified</span></td>
                            <td>
                                <div class="team-table-actions">
                                    <button class="btn btn-sm btn-outline view-team-btn" data-id="4">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline edit-team-btn" data-id="4">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline btn-danger delete-team-btn" data-id="4">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="team-table-name">
                                    <div class="team-table-flag"
                                        style="background-image: url('https://via.placeholder.com/30x20/9b59b6/ffffff?text=FRA')">
                                    </div>
                                    France
                                </div>
                            </td>
                            <td>Group C</td>
                            <td>5</td>
                            <td>UEFA</td>
                            <td>Pierre Dupont</td>
                            <td><span class="status-badge status-scheduled">Qualified</span></td>
                            <td>
                                <div class="team-table-actions">
                                    <button class="btn btn-sm btn-outline view-team-btn" data-id="5">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline edit-team-btn" data-id="5">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline btn-danger delete-team-btn" data-id="5">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="team-table-name">
                                    <div class="team-table-flag"
                                        style="background-image: url('https://via.placeholder.com/30x20/e67e22/ffffff?text=NED')">
                                    </div>
                                    Netherlands
                                </div>
                            </td>
                            <td>Group C</td>
                            <td>6</td>
                            <td>UEFA</td>
                            <td>Jan de Boer</td>
                            <td><span class="status-badge status-scheduled">Qualified</span></td>
                            <td>
                                <div class="team-table-actions">
                                    <button class="btn btn-sm btn-outline view-team-btn" data-id="6">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline edit-team-btn" data-id="6">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline btn-danger delete-team-btn" data-id="6">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="team-table-name">
                                    <div class="team-table-flag"
                                        style="background-image: url('https://via.placeholder.com/30x20/1abc9c/ffffff?text=ARG')">
                                    </div>
                                    Argentina
                                </div>
                            </td>
                            <td>Group D</td>
                            <td>7</td>
                            <td>CONMEBOL</td>
                            <td>Diego Fernandez</td>
                            <td><span class="status-badge status-scheduled">Qualified</span></td>
                            <td>
                                <div class="team-table-actions">
                                    <button class="btn btn-sm btn-outline view-team-btn" data-id="7">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline edit-team-btn" data-id="7">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline btn-danger delete-team-btn" data-id="7">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="team-table-name">
                                    <div class="team-table-flag"
                                        style="background-image: url('https://via.placeholder.com/30x20/34495e/ffffff?text=ENG')">
                                    </div>
                                    England
                                </div>
                            </td>
                            <td>Group D</td>
                            <td>8</td>
                            <td>UEFA</td>
                            <td>James Wilson</td>
                            <td><span class="status-badge status-scheduled">Qualified</span></td>
                            <td>
                                <div class="team-table-actions">
                                    <button class="btn btn-sm btn-outline view-team-btn" data-id="8">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline edit-team-btn" data-id="8">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline btn-danger delete-team-btn" data-id="8">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <button class="pagination-btn" disabled>
                    <i class="fas fa-chevron-left"></i> Previous
                </button>
                <div class="pagination-info">
                    Showing 1-8 of 32 teams
                </div>
                <button class="pagination-btn">
                    Next <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <!-- Group Overview -->
        <h3 class="section-title">Group Overview</h3>
        <div class="group-grid">
            <div class="group-card">
                <div class="group-card-header">Group A</div>
                <div class="group-teams">
                    <div class="group-team">
                        <div class="group-team-flag"
                            style="background-image: url('https://via.placeholder.com/30x20/3498db/ffffff?text=BRA')">
                        </div>
                        <div class="group-team-name">Brazil</div>
                        <div class="group-team-points">0 pts</div>
                    </div>
                    <div class="group-team">
                        <div class="group-team-flag"
                            style="background-image: url('https://via.placeholder.com/30x20/e74c3c/ffffff?text=GER')">
                        </div>
                        <div class="group-team-name">Germany</div>
                        <div class="group-team-points">0 pts</div>
                    </div>
                    <div class="group-team">
                        <div class="group-team-flag"
                            style="background-image: url('https://via.placeholder.com/30x20/27ae60/ffffff?text=MEX')">
                        </div>
                        <div class="group-team-name">Mexico</div>
                        <div class="group-team-points">0 pts</div>
                    </div>
                    <div class="group-team">
                        <div class="group-team-flag"
                            style="background-image: url('https://via.placeholder.com/30x20/8e44ad/ffffff?text=SUI')">
                        </div>
                        <div class="group-team-name">Switzerland</div>
                        <div class="group-team-points">0 pts</div>
                    </div>
                </div>
            </div>

            <div class="group-card">
                <div class="group-card-header">Group B</div>
                <div class="group-teams">
                    <div class="group-team">
                        <div class="group-team-flag"
                            style="background-image: url('https://via.placeholder.com/30x20/f39c12/ffffff?text=ESP')">
                        </div>
                        <div class="group-team-name">Spain</div>
                        <div class="group-team-points">0 pts</div>
                    </div>
                    <div class="group-team">
                        <div class="group-team-flag"
                            style="background-image: url('https://via.placeholder.com/30x20/2ecc71/ffffff?text=POR')">
                        </div>
                        <div class="group-team-name">Portugal</div>
                        <div class="group-team-points">0 pts</div>
                    </div>
                    <div class="group-team">
                        <div class="group-team-flag"
                            style="background-image: url('https://via.placeholder.com/30x20/e67e22/ffffff?text=USA')">
                        </div>
                        <div class="group-team-name">USA</div>
                        <div class="group-team-points">0 pts</div>
                    </div>
                    <div class="group-team">
                        <div class="group-team-flag"
                            style="background-image: url('https://via.placeholder.com/30x20/16a085/ffffff?text=GHA')">
                        </div>
                        <div class="group-team-name">Ghana</div>
                        <div class="group-team-points">0 pts</div>
                    </div>
                </div>
            </div>

            <div class="group-card">
                <div class="group-card-header">Group C</div>
                <div class="group-teams">
                    <div class="group-team">
                        <div class="group-team-flag"
                            style="background-image: url('https://via.placeholder.com/30x20/9b59b6/ffffff?text=FRA')">
                        </div>
                        <div class="group-team-name">France</div>
                        <div class="group-team-points">0 pts</div>
                    </div>
                    <div class="group-team">
                        <div class="group-team-flag"
                            style="background-image: url('https://via.placeholder.com/30x20/e67e22/ffffff?text=NED')">
                        </div>
                        <div class="group-team-name">Netherlands</div>
                        <div class="group-team-points">0 pts</div>
                    </div>
                    <div class="group-team">
                        <div class="group-team-flag"
                            style="background-image: url('https://via.placeholder.com/30x20/3498db/ffffff?text=SEN')">
                        </div>
                        <div class="group-team-name">Senegal</div>
                        <div class="group-team-points">0 pts</div>
                    </div>
                    <div class="group-team">
                        <div class="group-team-flag"
                            style="background-image: url('https://via.placeholder.com/30x20/e74c3c/ffffff?text=JPN')">
                        </div>
                        <div class="group-team-name">Japan</div>
                        <div class="group-team-points">0 pts</div>
                    </div>
                </div>
            </div>

            <div class="group-card">
                <div class="group-card-header">Group D</div>
                <div class="group-teams">
                    <div class="group-team">
                        <div class="group-team-flag"
                            style="background-image: url('https://via.placeholder.com/30x20/1abc9c/ffffff?text=ARG')">
                        </div>
                        <div class="group-team-name">Argentina</div>
                        <div class="group-team-points">0 pts</div>
                    </div>
                    <div class="group-team">
                        <div class="group-team-flag"
                            style="background-image: url('https://via.placeholder.com/30x20/34495e/ffffff?text=ENG')">
                        </div>
                        <div class="group-team-name">England</div>
                        <div class="group-team-points">0 pts</div>
                    </div>
                    <div class="group-team">
                        <div class="group-team-flag"
                            style="background-image: url('https://via.placeholder.com/30x20/f1c40f/ffffff?text=CRO')">
                        </div>
                        <div class="group-team-name">Croatia</div>
                        <div class="group-team-points">0 pts</div>
                    </div>
                    <div class="group-team">
                        <div class="group-team-flag"
                            style="background-image: url('https://via.placeholder.com/30x20/95a5a6/ffffff?text=AUS')">
                        </div>
                        <div class="group-team-name">Australia</div>
                        <div class="group-team-points">0 pts</div>
                    </div>
                </div>
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
                <button class="modal-close" id="closeTeamModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="teamForm">
                    <div class="team-form-row">
                        <div class="team-form-col">
                            <div class="team-form-group">
                                <label class="team-form-label" for="teamName">Team Name</label>
                                <input type="text" class="team-form-control" id="teamName"
                                    placeholder="Enter team name">
                            </div>
                        </div>
                        <div class="team-form-col">
                            <div class="team-form-group">
                                <label class="team-form-label" for="teamCode">Team Code</label>
                                <input type="text" class="team-form-control" id="teamCode"
                                    placeholder="3-letter code (e.g. BRA)">
                            </div>
                        </div>
                    </div>

                    <div class="team-form-row">
                        <div class="team-form-col">
                            <div class="team-form-group">
                                <label class="team-form-label" for="teamConfederation">Confederation</label>
                                <select class="team-form-control" id="teamConfederation">
                                    <option value="">Select Confederation</option>
                                    <option value="UEFA">UEFA (Europe)</option>
                                    <option value="CONMEBOL">CONMEBOL (South America)</option>
                                    <option value="CONCACAF">CONCACAF (North America)</option>
                                    <option value="CAF">CAF (Africa)</option>
                                    <option value="AFC">AFC (Asia)</option>
                                    <option value="OFC">OFC (Oceania)</option>
                                </select>
                            </div>
                        </div>
                        <div class="team-form-col">
                            <div class="team-form-group">
                                <label class="team-form-label" for="teamGroup">Group</label>
                                <select class="team-form-control" id="teamGroup">
                                    <option value="">Select Group</option>
                                    <option value="A">Group A</option>
                                    <option value="B">Group B</option>
                                    <option value="C">Group C</option>
                                    <option value="D">Group D</option>
                                    <option value="E">Group E</option>
                                    <option value="F">Group F</option>
                                    <option value="G">Group G</option>
                                    <option value="H">Group H</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="team-form-row">
                        <div class="team-form-col">
                            <div class="team-form-group">
                                <label class="team-form-label" for="teamRank">FIFA Ranking</label>
                                <input type="number" class="team-form-control" id="teamRank"
                                    placeholder="Enter FIFA ranking">
                            </div>
                        </div>
                        <div class="team-form-col">
                            <div class="team-form-group">
                                <label class="team-form-label" for="teamStatus">Status</label>
                                <select class="team-form-control" id="teamStatus">
                                    <option value="qualified">Qualified</option>
                                    <option value="pending">Pending Qualification</option>
                                    <option value="eliminated">Eliminated</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="team-form-group">
                        <label class="team-form-label" for="teamCoach">Head Coach</label>
                        <input type="text" class="team-form-control" id="teamCoach"
                            placeholder="Enter head coach name">
                    </div>

                    <div class="team-form-group">
                        <label class="team-form-label" for="teamFlag">Team Flag URL</label>
                        <input type="text" class="team-form-control" id="teamFlag"
                            placeholder="Enter flag image URL">
                    </div>

                    <div class="team-form-group">
                        <label class="team-form-label">Team Players</label>
                        <div class="player-form-list">
                            <div class="player-form-header">
                                Player List
                            </div>
                            <div class="player-form-body" id="playerFormList">
                                <div class="player-form-row">
                                    <div class="player-form-col">
                                        <div class="team-form-group">
                                            <label class="team-form-label">Name</label>
                                            <input type="text" class="team-form-control" placeholder="Player name">
                                        </div>
                                    </div>
                                    <div class="player-form-col">
                                        <div class="team-form-group">
                                            <label class="team-form-label">Position</label>
                                            <select class="team-form-control">
                                                <option value="GK">Goalkeeper (GK)</option>
                                                <option value="DF">Defender (DF)</option>
                                                <option value="MF">Midfielder (MF)</option>
                                                <option value="FW">Forward (FW)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="player-form-col-small">
                                        <div class="team-form-group">
                                            <label class="team-form-label">Number</label>
                                            <input type="number" class="team-form-control" placeholder="No.">
                                        </div>
                                    </div>
                                    <div class="player-form-actions">
                                        <button type="button"
                                            class="btn btn-sm btn-outline btn-danger remove-player-btn">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline add-player-btn" id="addPlayerBtn">
                            <i class="fas fa-plus"></i> Add Player
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" id="cancelTeamBtn">Cancel</button>
                <button class="btn btn-primary" id="saveTeamBtn">Save Team</button>
            </div>
        </div>
    </div>

    <!-- View Team Modal -->
    <div class="modal" id="viewTeamModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="viewTeamModalTitle">Team Details</h3>
                <button class="modal-close" id="closeViewTeamModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="team-card">
                    <div class="team-card-header">
                        <div class="team-flag" id="viewTeamFlag"
                            style="background-image: url('https://via.placeholder.com/60x40/3498db/ffffff?text=BRA')">
                        </div>
                        <div class="team-info">
                            <div class="team-name" id="viewTeamName">Brazil</div>
                            <div class="team-code" id="viewTeamCode">BRA</div>
                        </div>
                    </div>
                    <div class="team-card-body">
                        <div class="team-details">
                            <div class="team-detail">
                                <div class="detail-label">Group</div>
                                <div class="detail-value" id="viewTeamGroup">Group A</div>
                            </div>
                            <div class="team-detail">
                                <div class="detail-label">FIFA Rank</div>
                                <div class="detail-value" id="viewTeamRank">1</div>
                            </div>
                            <div class="team-detail">
                                <div class="detail-label">Confederation</div>
                                <div class="detail-value" id="viewTeamConfederation">CONMEBOL</div>
                            </div>
                            <div class="team-detail">
                                <div class="detail-label">Head Coach</div>
                                <div class="detail-value" id="viewTeamCoach">Carlos Amaral</div>
                            </div>
                        </div>

                        <h4 class="mt-4 mb-2">Squad</h4>
                        <div class="player-list" id="viewTeamPlayers">
                            <div class="player-item">
                                <div class="player-photo"
                                    style="background-image: url('https://via.placeholder.com/40x40')"></div>
                                <div class="player-info">
                                    <div class="player-name">Alisson Becker</div>
                                    <div class="player-position">Goalkeeper (GK)</div>
                                </div>
                                <div class="player-number">1</div>
                            </div>
                            <div class="player-item">
                                <div class="player-photo"
                                    style="background-image: url('https://via.placeholder.com/40x40')"></div>
                                <div class="player-info">
                                    <div class="player-name">Thiago Silva</div>
                                    <div class="player-position">Defender (DF)</div>
                                </div>
                                <div class="player-number">3</div>
                            </div>
                            <div class="player-item">
                                <div class="player-photo"
                                    style="background-image: url('https://via.placeholder.com/40x40')"></div>
                                <div class="player-info">
                                    <div class="player-name">Casemiro</div>
                                    <div class="player-position">Midfielder (MF)</div>
                                </div>
                                <div class="player-number">5</div>
                            </div>
                            <div class="player-item">
                                <div class="player-photo"
                                    style="background-image: url('https://via.placeholder.com/40x40')"></div>
                                <div class="player-info">
                                    <div class="player-name">Neymar Jr.</div>
                                    <div class="player-position">Forward (FW)</div>
                                </div>
                                <div class="player-number">10</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" id="closeViewTeamBtn">Close</button>
                <button class="btn btn-primary edit-from-view-btn">Edit Team</button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal" id="deleteTeamModal">
        <div class="modal-content modal-sm">
            <div class="modal-header">
                <h3 class="modal-title">Confirm Delete</h3>
                <button class="modal-close" id="closeDeleteModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this team? This action cannot be undone.</p>
                <p><strong>Team: </strong><span id="deleteTeamName">Brazil</span></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" id="cancelDeleteBtn">Cancel</button>
                <button class="btn btn-danger" id="confirmDeleteBtn">Delete Team</button>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const menuToggle = document.getElementById('menu-toggle');
            const sidebar = document.querySelector('.admin-sidebar');

            if (menuToggle && sidebar) {
                menuToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }

            // View toggle
            const viewBtns = document.querySelectorAll('.view-btn');

            if (viewBtns.length) {
                viewBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        viewBtns.forEach(b => b.classList.remove('active'));
                        this.classList.add('active');

                        // Here you would toggle between table and card view
                        // For now, we'll just keep the table view
                    });
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
                    document.getElementById('teamModalTitle').textContent = 'Add New Team';
                    document.getElementById('teamForm').reset();
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
                        const teamId = this.getAttribute('data-id');
                        document.getElementById('teamModalTitle').textContent = 'Edit Team';

                        // Here you would fetch team data and populate the form
                        // For now, we'll just show the modal
                        teamModal.classList.add('show');
                    });
                });
            }

            // View Team Modal
            const viewTeamModal = document.getElementById('viewTeamModal');
            const viewTeamBtns = document.querySelectorAll('.view-team-btn');
            const closeViewTeamModal = document.getElementById('closeViewTeamModal');
            const closeViewTeamBtn = document.getElementById('closeViewTeamBtn');

            if (viewTeamBtns.length && viewTeamModal) {
                viewTeamBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const teamId = this.getAttribute('data-id');

                        // Here you would fetch team data and populate the modal
                        // For now, we'll just show the modal
                        viewTeamModal.classList.add('show');
                    });
                });
            }

            if (closeViewTeamModal && viewTeamModal) {
                closeViewTeamModal.addEventListener('click', function() {
                    viewTeamModal.classList.remove('show');
                });
            }

            if (closeViewTeamBtn && viewTeamModal) {
                closeViewTeamBtn.addEventListener('click', function() {
                    viewTeamModal.classList.remove('show');
                });
            }

            // Delete Team Modal
            const deleteTeamModal = document.getElementById('deleteTeamModal');
            const deleteTeamBtns = document.querySelectorAll('.delete-team-btn');
            const closeDeleteModal = document.getElementById('closeDeleteModal');
            const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

            if (deleteTeamBtns.length && deleteTeamModal) {
                deleteTeamBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const teamId = this.getAttribute('data-id');

                        // Here you would fetch team name and set it in the modal
                        // For now, we'll just show the modal
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
                    // Here you would delete the team
                    // For now, we'll just close the modal
                    deleteTeamModal.classList.remove('show');
                });
            }

            // Add Player Button
            const addPlayerBtn = document.getElementById('addPlayerBtn');
            const playerFormList = document.getElementById('playerFormList');

            if (addPlayerBtn && playerFormList) {
                addPlayerBtn.addEventListener('click', function() {
                    const playerRow = document.createElement('div');
                    playerRow.className = 'player-form-row';
                    playerRow.innerHTML = `
                    <div class="player-form-col">
                        <div class="team-form-group">
                            <label class="team-form-label">Name</label>
                            <input type="text" class="team-form-control" placeholder="Player name">
                        </div>
                    </div>
                    <div class="player-form-col">
                        <div class="team-form-group">
                            <label class="team-form-label">Position</label>
                            <select class="team-form-control">
                                <option value="GK">Goalkeeper (GK)</option>
                                <option value="DF">Defender (DF)</option>
                                <option value="MF">Midfielder (MF)</option>
                                <option value="FW">Forward (FW)</option>
                            </select>
                        </div>
                    </div>
                    <div class="player-form-col-small">
                        <div class="team-form-group">
                            <label class="team-form-label">Number</label>
                            <input type="number" class="team-form-control" placeholder="No.">
                        </div>
                    </div>
                    <div class="player-form-actions">
                        <button type="button" class="btn btn-sm btn-outline btn-danger remove-player-btn">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;

                    playerFormList.appendChild(playerRow);

                    // Add event listener to remove button
                    const removeBtn = playerRow.querySelector('.remove-player-btn');
                    if (removeBtn) {
                        removeBtn.addEventListener('click', function() {
                            playerRow.remove();
                        });
                    }
                });
            }

            // Add event listeners to existing remove player buttons
            const removePlayerBtns = document.querySelectorAll('.remove-player-btn');
            if (removePlayerBtns.length) {
                removePlayerBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        this.closest('.player-form-row').remove();
                    });
                });
            }

            // Edit from view button
            const editFromViewBtn = document.querySelector('.edit-from-view-btn');
            if (editFromViewBtn && teamModal && viewTeamModal) {
                editFromViewBtn.addEventListener('click', function() {
                    viewTeamModal.classList.remove('show');

                    document.getElementById('teamModalTitle').textContent = 'Edit Team';

                    // Here you would populate the form with the team data
                    // For now, we'll just show the modal
                    teamModal.classList.add('show');
                });
            }
        });
    </script>
@endsection
