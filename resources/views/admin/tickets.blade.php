@extends('admin.layout')

@section('title', 'Ticket Management - World Cup 2030')
@section('css')
    <style>
        /* Main Content */
        .admin-main {
            grid-area: main;
            padding: 30px;
            overflow-y: auto;
        }

        /* Tickets Dashboard */
        .tickets-dashboard {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        /* Ticket Stats */
        .ticket-stats {
            grid-column: span 12;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
        }

        .stat-card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 20px;
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

        .stat-icon-available {
            color: var(--success);
        }

        .stat-icon-sold {
            color: var(--primary);
        }

        .stat-icon-reserved {
            color: var(--warning);
        }

        .stat-icon-revenue {
            color: var(--info);
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

        /* Ticket Filters */
        .ticket-filters {
            grid-column: span 12;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 20px;
        }

        .filters-form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .filter-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 0.9rem;
            color: var(--gray-700);
        }

        .filter-select,
        .filter-input {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--gray-300);
            border-radius: var(--border-radius);
            background-color: white;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            color: var(--gray-700);
            transition: var(--transition);
        }

        .filter-select:focus,
        .filter-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.1);
        }

        .filters-actions {
            display: flex;
            gap: 10px;
            align-items: end;
            min-width: 200px;
        }

        .btn {
            padding: 10px 15px;
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
            transform: translateY(-2px);
            box-shadow: var(--shadow);
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

        .btn-secondary {
            background-color: var(--secondary);
        }

        .btn-secondary:hover {
            background-color: var(--secondary-dark);
        }

        .btn-success {
            background-color: var(--success);
        }

        .btn-success:hover {
            background-color: darken(var(--success), 10%);
        }

        .btn-block {
            width: 100%;
            justify-content: center;
        }

        /* Ticket Management */
        .ticket-management {
            grid-column: span 12;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .management-header {
            padding: 20px;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .management-title {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .management-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .ticket-table-container {
            overflow-x: auto;
        }

        .ticket-table {
            width: 100%;
            border-collapse: collapse;
        }

        .ticket-table th,
        .ticket-table td {
            padding: 15px;
            text-align: left;
        }

        .ticket-table th {
            background-color: var(--gray-100);
            font-weight: 600;
            color: var(--gray-700);
            border-bottom: 1px solid var(--gray-200);
            position: sticky;
            top: 0;
            white-space: nowrap;
        }

        .ticket-table tbody tr {
            border-bottom: 1px solid var(--gray-200);
            transition: var(--transition);
        }

        .ticket-table tbody tr:hover {
            background-color: var(--gray-100);
        }

        .ticket-table tbody tr:last-child {
            border-bottom: none;
        }

        .ticket-id {
            font-weight: 600;
            color: var(--primary);
        }

        .ticket-match {
            font-weight: 500;
        }

        .ticket-flags {
            display: flex;
            gap: 5px;
        }

        .ticket-flag {
            width: 20px;
            height: 15px;
            border-radius: 2px;
            overflow: hidden;
            background-size: cover;
            background-position: center;
            box-shadow: var(--shadow-sm);
        }

        .ticket-price {
            font-weight: 600;
        }

        .ticket-status {
            display: inline-flex;
            align-items: center;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-paid {
            background-color: var(--success-light);
            color: var(--success);
        }

        .status-sold {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .status-used {
            background-color: var(--warning-light);
            color: var(--warning);
        }

        .status-canceled {
            background-color: var(--gray-200);
            color: var(--gray-600);
        }

        .ticket-actions {
            display: flex;
            gap: 5px;
            justify-content: flex-end;
        }

        .action-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: var(--gray-100);
            color: var(--gray-700);
            cursor: pointer;
            transition: var(--transition);
        }

        .action-icon:hover {
            background-color: var(--gray-200);
            color: var(--gray-900);
        }

        .action-icon-edit:hover {
            background-color: var(--info-light);
            color: var(--info);
        }

        .action-icon-delete:hover {
            background-color: var(--danger-light);
            color: var(--danger);
        }

        .ticket-checkbox {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Ticket Categories */
        .ticket-categories {
            grid-column: span 6;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .categories-table {
            width: 100%;
            border-collapse: collapse;
        }

        .categories-table th,
        .categories-table td {
            padding: 15px;
            text-align: left;
        }

        .categories-table th {
            background-color: var(--gray-100);
            font-weight: 600;
            color: var(--gray-700);
            border-bottom: 1px solid var(--gray-200);
        }

        .categories-table tbody tr {
            border-bottom: 1px solid var(--gray-200);
            transition: var(--transition);
        }

        .categories-table tbody tr:hover {
            background-color: var(--gray-100);
        }

        .categories-table tbody tr:last-child {
            border-bottom: none;
        }

        .category-name {
            font-weight: 600;
        }

        .category-color {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            display: inline-block;
            margin-right: 5px;
            vertical-align: text-bottom;
        }

        .category-price {
            font-weight: 600;
        }

        .category-availability {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .availability-indicator {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.8rem;
        }

        .indicator-available {
            color: var(--success);
        }

        .indicator-sold {
            color: var(--primary);
        }

        .indicator-reserved {
            color: var(--warning);
        }

        /* Ticket Sales Chart */
        .ticket-sales-chart {
            grid-column: span 6;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .chart-container {
            padding: 20px;
            height: 300px;
            position: relative;
        }

        /* Ticket Alerts */
        .ticket-alerts {
            grid-column: span 6;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .alerts-list {
            list-style: none;
        }

        .alert-item {
            padding: 15px 20px;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: flex-start;
            gap: 15px;
            transition: var(--transition);
        }

        .alert-item:hover {
            background-color: var(--gray-100);
        }

        .alert-item:last-child {
            border-bottom: none;
        }

        .alert-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .alert-icon-warning {
            background-color: var(--warning-light);
            color: var(--warning);
        }

        .alert-icon-info {
            background-color: var(--info-light);
            color: var(--info);
        }

        .alert-icon-success {
            background-color: var(--success-light);
            color: var(--success);
        }

        .alert-icon-danger {
            background-color: var(--danger-light);
            color: var(--danger);
        }

        .alert-content {
            flex: 1;
        }

        .alert-title {
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--gray-800);
        }

        .alert-text {
            font-size: 0.9rem;
            color: var(--gray-600);
            margin-bottom: 10px;
        }

        .alert-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8rem;
            color: var(--gray-500);
        }

        .alert-time {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .alert-actions {
            display: flex;
            gap: 10px;
        }

        /* Recent Sales */
        .recent-sales {
            grid-column: span 6;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .sales-list {
            list-style: none;
        }

        .sale-item {
            padding: 15px 20px;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            gap: 15px;
            transition: var(--transition);
        }

        .sale-item:hover {
            background-color: var(--gray-100);
        }

        .sale-item:last-child {
            border-bottom: none;
        }

        .sale-user {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--gray-300);
            overflow: hidden;
            flex-shrink: 0;
        }

        .sale-user img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sale-details {
            flex: 1;
        }

        .sale-customer {
            font-weight: 600;
            color: var(--gray-800);
        }

        .sale-match {
            font-size: 0.9rem;
            color: var(--gray-600);
        }

        .sale-amount {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--gray-800);
        }

        .sale-time {
            font-size: 0.8rem;
            color: var(--gray-500);
        }

        /* Pagination */
        .tickets-pagination {
            grid-column: span 12;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
            margin-top: 20px;
        }

        .pagination-item {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--border-radius);
            background-color: white;
            color: var(--gray-700);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .pagination-item:hover {
            background-color: var(--gray-100);
        }

        .pagination-item.active {
            background-color: var(--primary);
            color: white;
        }

        .pagination-arrow {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--border-radius);
            background-color: white;
            color: var(--gray-700);
            cursor: pointer;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .pagination-arrow:hover {
            background-color: var(--gray-100);
        }

        .pagination-arrow.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Modal */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            display: none;
            justify-content: center;
            align-items: center;
        }

        .modal-backdrop.show {
            display: flex;
        }

        .modal {
            width: 100%;
            max-width: 600px;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            animation: modal-fade-in 0.3s ease;
        }

        @keyframes modal-fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            padding: 20px;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .modal-close {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: var(--gray-100);
            color: var(--gray-700);
            cursor: pointer;
            transition: var(--transition);
        }

        .modal-close:hover {
            background-color: var(--gray-200);
            color: var(--gray-900);
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            padding: 20px;
            border-top: 1px solid var(--gray-200);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* Form */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 0.9rem;
            color: var(--gray-700);
        }

        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--gray-300);
            border-radius: var(--border-radius);
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            color: var(--gray-700);
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.1);
        }

        /* Responsive Styles */
        @media (max-width: 1200px) {
            .tickets-dashboard {
                grid-template-columns: repeat(6, 1fr);
            }

            .ticket-stats,
            .ticket-filters,
            .ticket-management,
            .tickets-pagination {
                grid-column: span 6;
            }

            .ticket-categories,
            .ticket-sales-chart,
            .ticket-alerts,
            .recent-sales {
                grid-column: span 3;
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

            .tickets-dashboard {
                grid-template-columns: repeat(3, 1fr);
            }

            .ticket-stats,
            .ticket-filters,
            .ticket-management,
            .tickets-pagination {
                grid-column: span 3;
            }

            .ticket-categories,
            .ticket-sales-chart,
            .ticket-alerts,
            .recent-sales {
                grid-column: span 3;
            }
        }

        @media (max-width: 768px) {
            .tickets-dashboard {
                grid-template-columns: 1fr;
            }

            .ticket-stats,
            .ticket-filters,
            .ticket-management,
            .ticket-categories,
            .ticket-sales-chart,
            .ticket-alerts,
            .recent-sales,
            .tickets-pagination {
                grid-column: span 1;
            }

            .management-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .management-actions {
                width: 100%;
                justify-content: space-between;
            }

            .header-search {
                display: none;
            }
        }
    </style>
@endsection

@section('content')
@section('header-title', 'Ticket Management')

<main class="admin-main">
    <div class="tickets-dashboard">
        <div class="ticket-stats">
            <div class="stat-card">
                <div class="stat-icon stat-icon-available">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ number_format($availableTickets) }}</div>
                    <div class="stat-label">Available Tickets</div>
                </div>
                <i class="fas fa-ticket-alt stat-bg"></i>
            </div>

            <div class="stat-card">
                <div class="stat-icon stat-icon-sold">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ number_format($soldTickets) }}</div>
                    <div class="stat-label">Tickets Sold</div>
                </div>
                <i class="fas fa-shopping-cart stat-bg"></i>
            </div>

            <div class="stat-card">
                <div class="stat-icon stat-icon-reserved">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ number_format($reservedTickets) }}</div>
                    <div class="stat-label">Reserved Tickets</div>
                </div>
                <i class="fas fa-clock stat-bg"></i>
            </div>

            <div class="stat-card">
                <div class="stat-icon stat-icon-revenue">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">${{ number_format($totalRevenue) }}</div>
                    <div class="stat-label">Total Revenue</div>
                </div>
                <i class="fas fa-dollar-sign stat-bg"></i>
            </div>
        </div>

        <div class="ticket-filters">
            <form class="filters-form" id="filter-form">
                <div class="filter-group">
                    <label for="match-filter" class="filter-label">Match</label>
                    <select id="match-filter" class="filter-select">
                        <option value="">All Matches</option>
                        @foreach ($games as $game)
                            <option value="{{ $game->id }}">{{ $game->homeTeam->name }} vs
                                {{ $game->awayTeam->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label for="status-filter" class="filter-label">Status</label>
                    <select id="status-filter" class="filter-select">
                        <option value="">All Statuses</option>
                        <option value="available">Available</option>
                        <option value="sold">Sold</option>
                        <option value="reserved">Reserved</option>
                        <option value="canceled">Canceled</option>
                    </select>
                </div>

                <div class="filters-actions">
                    <button type="button" id="apply-filters" class="btn">
                        <i class="fas fa-filter"></i> Apply Filters
                    </button>
                    <button type="reset" id="reset-filters" class="btn btn-outline">
                        <i class="fas fa-times"></i> Clear
                    </button>
                </div>
            </form>
        </div>

        <div class="ticket-management">
            <div class="management-header">
                <h3 class="management-title">All Tickets</h3>
                <div class="management-actions">
                    <button class="btn" id="add-ticket-btn">
                        <i class="fas fa-plus"></i> Add Tickets
                    </button>
                </div>
            </div>

            <div class="ticket-table-container">
                <table class="ticket-table">
                    <thead>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Match</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Section</th>
                            <th>Seat</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tickets as $ticket)
                            <tr data-ticket-id="{{ $ticket->id }}" data-game="{{ $ticket->game_id }}"
                                data-category="{{ $ticket->section }}" data-status="{{ $ticket->status }}">

                                <td><span class="ticket-id">TKT-{{ $ticket->id }}</span></td>
                                <td>
                                    <div class="ticket-match">
                                        <div class="ticket-flags">
                                            <div class="ticket-flag"
                                                style="background-image: url('{{ asset($ticket->game->homeTeam->flag) }}')">
                                            </div>
                                            <div class="ticket-flag"
                                                style="background-image: url('{{ asset($ticket->game->awayTeam->flag) }}')">
                                            </div>
                                        </div>
                                        {{ $ticket->game->homeTeam->name }} vs {{ $ticket->game->awayTeam->name }}
                                    </div>
                                </td>
                                <td>{{ date('M j, Y', strtotime($ticket->game->start_date)) }}</td>
                                <td>{{ date('g:i A', strtotime($ticket->game->start_hour)) }}</td>
                                <td>{{ $ticket->section }}</td>
                                <td>{{ $ticket->place_number }}</td>
                                <td class="ticket-price">${{ number_format($ticket->price) }}</td>
                                <td><span
                                        class="ticket-status status-{{ $ticket->status }}">{{ ucfirst($ticket->status) }}</span>
                                </td>
                                <td>
                                    <div class="ticket-actions">
                                        <div class="action-icon action-icon-edit edit-ticket-btn"
                                            data-id="{{ $ticket->id }}" data-game="{{ $ticket->game_id }}"
                                            data-user="{{ $ticket->user_id }}" data-price="{{ $ticket->price }}"
                                            data-place="{{ $ticket->place_number }}"
                                            data-status="{{ $ticket->status }}"
                                            data-category="{{ $ticket->section }}">
                                            <i class="fas fa-edit"></i>
                                        </div>
                                        <div class="action-icon action-icon-delete delete-ticket-btn"
                                            data-id="{{ $ticket->id }}">
                                            <i class="fas fa-trash"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" style="text-align: center; padding: 30px;">
                                    No tickets found. Try adjusting your filters or add new tickets.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tickets-pagination">
            <div class="pagination">
                @if ($tickets->hasPages())
                    <div class="pagination-container">
                        <ul class="pagination">
                            @if ($tickets->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">&laquo;</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a href="{{ $tickets->previousPageUrl() }}" class="page-link">&laquo;</a>
                                </li>
                            @endif

                            @foreach ($tickets->getUrlRange(1, $tickets->lastPage()) as $page => $url)
                                @if ($page == $tickets->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            @if ($tickets->hasMorePages())
                                <li class="page-item">
                                    <a href="{{ $tickets->nextPageUrl() }}" class="page-link">&raquo;</a>
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
    </div>
</main>
@endsection

@section('modal')
<!-- Add/Edit Ticket Modal -->
<div class="modal-backdrop" id="ticketModal">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title" id="modal-title">Add New Ticket</h3>
            <div class="modal-close" id="closeTicketModal">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="modal-body">
            <form id="ticket-form" method="POST" action="{{ route('admin.tickets.store') }}">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">

                <div class="form-group">
                    <label for="game_id" class="form-label">Match</label>
                    <select id="game_id" name="game_id" class="form-control" required>
                        <option value="">Select Match</option>
                        @foreach ($games as $game)
                            <option value="{{ $game->id }}">{{ $game->homeTeam->name }} vs
                                {{ $game->awayTeam->name }} - {{ date('M j, Y', strtotime($game->start_date)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="user_id" class="form-label">User</label>
                    <select id="user_id" name="user_id" class="form-control">
                        <option value="">Select User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->firstname }} {{ $user->lastname }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="category_id" class="form-label">Category</label>
                    <select id="category_id" name="section" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}">{{ ucfirst($category) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-row" style="display: flex; gap: 15px;">
                    <div class="form-group" style="flex: 1;">
                        <label for="place_number" class="form-label">Seat Number</label>
                        <input type="number" id="place_number" name="place_number" class="form-control"
                            min="1" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label for="price" class="form-label">Price ($)</label>
                        <input type="number" id="price" name="price" class="form-control" min="0"
                            required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="available">Available</option>
                        <option value="sold">Sold</option>
                        <option value="reserved">Reserved</option>
                        <option value="canceled">Canceled</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" id="cancel-ticket-btn">Cancel</button>
                    <button type="submit" class="btn">Save Ticket</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal-backdrop" id="deleteModal">
    <div class="modal" style="max-width: 400px;">
        <div class="modal-header">
            <h3 class="modal-title">Confirm Delete</h3>
            <div class="modal-close" id="closeDeleteModal">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this ticket? This action cannot be undone.</p>
            <form id="delete-form" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" id="cancel-delete-btn">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Ticket</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addTicketBtn = document.getElementById('add-ticket-btn');
        const ticketModal = document.getElementById('ticketModal');
        const closeTicketModal = document.getElementById('closeTicketModal');
        const cancelTicketBtn = document.getElementById('cancel-ticket-btn');
        const ticketForm = document.getElementById('ticket-form');
        const deleteModal = document.getElementById('deleteModal');
        const closeDeleteModal = document.getElementById('closeDeleteModal');
        const cancelDeleteBtn = document.getElementById('cancel-delete-btn');
        const deleteForm = document.getElementById('delete-form');
        const seatMapModal = document.getElementById('seatMapModal');
        const closeSeatMap = document.getElementById('closeSeatMap');
        const closeSeatMapBtn = document.getElementById('closeSeatMapBtn');
        const showSeatMap = document.getElementById('showSeatMap');
        const selectAll = document.getElementById('selectAll');
        const ticketChecks = document.querySelectorAll('.ticket-check');
        const selectedCount = document.getElementById('selectedCount');
        const applyFiltersBtn = document.getElementById('apply-filters');
        const resetFiltersBtn = document.getElementById('reset-filters');

        // Add event listeners for all edit buttons
        document.querySelectorAll('.edit-ticket-btn').forEach(button => {
            button.addEventListener('click', function() {
                openEditTicketModal(this);
            });
        });

        // Add event listeners for all delete buttons
        document.querySelectorAll('.delete-ticket-btn').forEach(button => {
            button.addEventListener('click', function() {
                const ticketId = this.getAttribute('data-id');
                openDeleteModal(ticketId);
            });
        });

        // Event Listeners
        addTicketBtn.addEventListener('click', function() {
            openAddTicketModal();
        });

        closeTicketModal.addEventListener('click', function() {
            closeModal(ticketModal);
        });

        cancelTicketBtn.addEventListener('click', function() {
            closeModal(ticketModal);
        });

        closeDeleteModal.addEventListener('click', function() {
            closeModal(deleteModal);
        });

        cancelDeleteBtn.addEventListener('click', function() {
            closeModal(deleteModal);
        });

        if (showSeatMap && seatMapModal) {
            showSeatMap.addEventListener('click', function() {
                openModal(seatMapModal);
            });

            if (closeSeatMap) {
                closeSeatMap.addEventListener('click', function() {
                    closeModal(seatMapModal);
                });
            }

            if (closeSeatMapBtn) {
                closeSeatMapBtn.addEventListener('click', function() {
                    closeModal(seatMapModal);
                });
            }

            // Close on click outside
            seatMapModal.addEventListener('click', function(e) {
                if (e.target === seatMapModal) {
                    closeModal(seatMapModal);
                }
            });
        }


        // Filters
        if (applyFiltersBtn) {
            applyFiltersBtn.addEventListener('click', function() {
                filterTickets();
            });
        }

        if (resetFiltersBtn) {
            resetFiltersBtn.addEventListener('click', function() {
                resetFilters();
            });
        }

        // Functions
        function openAddTicketModal() {
            ticketForm.reset();
            document.getElementById('form-method').value = 'POST';
            document.getElementById('modal-title').textContent = 'Add New Ticket';
            ticketForm.action = "{{ route('admin.tickets.store') }}";

            openModal(ticketModal);
        }

        function openEditTicketModal(button) {
            const ticketId = button.getAttribute('data-id');
            const gameId = button.getAttribute('data-game');
            const userId = button.getAttribute('data-user');
            const price = button.getAttribute('data-price');
            const placeNumber = button.getAttribute('data-place');
            const status = button.getAttribute('data-status');
            const categoryId = button.getAttribute('data-category');

            document.getElementById('form-method').value = 'PUT';
            document.getElementById('modal-title').textContent = 'Edit Ticket';
            ticketForm.action = "{{ url('admin/tickets') }}/" + ticketId;

            document.getElementById('game_id').value = gameId;
            document.getElementById('user_id').value = userId;
            document.getElementById('price').value = price;
            document.getElementById('place_number').value = placeNumber;
            document.getElementById('status').value = status;
            document.getElementById('category_id').value = categoryId;

            openModal(ticketModal);
        }

        function openDeleteModal(ticketId) {
            // Set the form action for delete
            deleteForm.action = "{{ url('admin/tickets') }}/" + ticketId;

            // Show modal
            openModal(deleteModal);
        }


        function getSelectedTickets() {
            return Array.from(document.querySelectorAll('.ticket-check:checked')).map(check => check.value);
        }

        function filterTickets() {
            const gameFilter = document.getElementById('match-filter').value;
            const statusFilter = document.getElementById('status-filter').value;

            const rows = document.querySelectorAll('.ticket-table tbody tr');

            rows.forEach(row => {
                const gameId = row.getAttribute('data-game');
                const status = row.getAttribute('data-status');

                const gameMatch = !gameFilter || gameId === gameFilter;
                const statusMatch = !statusFilter || status === statusFilter;

                // Date filtering would require additional logic to match with the game date

                if (gameMatch && statusMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            // Check if no tickets are visible
            checkNoTickets();
        }

        function resetFilters() {
            document.getElementById('match-filter').value = '';
            document.getElementById('status-filter').value = '';

            // Show all tickets
            const rows = document.querySelectorAll('.ticket-table tbody tr');
            rows.forEach(row => {
                row.style.display = '';
            });

            // Remove no tickets message if it exists
            const noTicketsRow = document.querySelector('.no-tickets-row');
            if (noTicketsRow) {
                noTicketsRow.remove();
            }
        }

        function checkNoTickets() {
            const visibleRows = Array.from(document.querySelectorAll('.ticket-table tbody tr')).filter(row =>
                row.style.display !== 'none');

            if (visibleRows.length === 0 && !document.querySelector('.no-tickets-row')) {
                const tbody = document.querySelector('.ticket-table tbody');
                const noTicketsRow = document.createElement('tr');
                noTicketsRow.className = 'no-tickets-row';
                noTicketsRow.innerHTML =
                    '<td colspan="10" style="text-align: center; padding: 30px;">No tickets found. Try adjusting your filters.</td>';
                tbody.appendChild(noTicketsRow);
            } else if (visibleRows.length > 0) {
                const noTicketsRow = document.querySelector('.no-tickets-row');
                if (noTicketsRow) {
                    noTicketsRow.remove();
                }
            }
        }

        function openModal(modal) {
            modal.classList.add('show');
        }

        function closeModal(modal) {
            modal.classList.remove('show');
        }
    });
</script>
@endsection
