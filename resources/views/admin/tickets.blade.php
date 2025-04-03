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

        .ticket-bulk-actions {
            padding: 15px 20px;
            background-color: var(--gray-100);
            border-bottom: 1px solid var(--gray-200);
            display: none;
        }

        .ticket-bulk-actions.show {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .bulk-selected {
            font-weight: 500;
            color: var(--gray-700);
        }

        .bulk-actions {
            display: flex;
            gap: 10px;
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

        .status-available {
            background-color: var(--success-light);
            color: var(--success);
        }

        .status-sold {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .status-reserved {
            background-color: var(--warning-light);
            color: var(--warning);
        }

        .status-canceled {
            background-color: var(--danger-light);
            color: var(--danger);
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

        .bulk-checkbox {
            width: 18px;
            height: 18px;
            cursor: pointer;
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

        /* Ticket Seat Map */
        .seat-map-container {
            max-width: 100%;
            overflow-x: auto;
            margin-top: 20px;
        }

        .seat-map {
            position: relative;
            width: 700px;
            height: 400px;
            margin: 0 auto;
            background-color: var(--gray-100);
            border-radius: var(--border-radius);
            padding: 20px;
        }

        .stadium-outline {
            position: absolute;
            width: 600px;
            height: 350px;
            border: 3px solid var(--gray-400);
            border-radius: 180px 180px 0 0;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .field {
            position: absolute;
            width: 400px;
            height: 250px;
            background-color: #7bb661;
            border: 3px solid white;
            border-radius: 120px 120px 0 0;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -45%);
        }

        .field-lines {
            position: absolute;
            width: 200px;
            height: 125px;
            border: 2px solid rgba(255, 255, 255, 0.7);
            border-radius: 60px 60px 0 0;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -45%);
        }

        .seat-section {
            position: absolute;
            color: white;
            font-weight: 600;
            font-size: 0.8rem;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .seat-section:hover {
            filter: brightness(1.1);
        }

        .section-a {
            width: 200px;
            height: 40px;
            background-color: var(--primary);
            border-radius: 5px;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
        }

        .section-b {
            width: 40px;
            height: 160px;
            background-color: var(--info);
            border-radius: 5px;
            top: 120px;
            left: 100px;
            transform: rotate(-10deg);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .section-c {
            width: 40px;
            height: 160px;
            background-color: var(--info);
            border-radius: 5px;
            top: 120px;
            right: 100px;
            transform: rotate(10deg);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .section-d {
            width: 240px;
            height: 40px;
            background-color: var(--success);
            border-radius: 5px;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
        }

        .seat-legend {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.9rem;
        }

        .legend-color {
            width: 16px;
            height: 16px;
            border-radius: 3px;
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

            .ticket-bulk-actions {
                flex-direction: column;
                gap: 10px;
            }

            .header-search {
                display: none;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Main Content -->
    <main class="admin-main">
        <!-- Tickets Dashboard -->
        <div class="tickets-dashboard">
            <!-- Ticket Stats -->
            <div class="ticket-stats">
                <div class="stat-card">
                    <div class="stat-icon stat-icon-available">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">265,420</div>
                        <div class="stat-label">Available Tickets</div>
                        <div class="stat-change negative">
                            <i class="fas fa-arrow-down"></i> 8.5% from last week
                        </div>
                    </div>
                    <i class="fas fa-ticket-alt stat-bg"></i>
                </div>

                <div class="stat-card">
                    <div class="stat-icon stat-icon-sold">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">834,580</div>
                        <div class="stat-label">Tickets Sold</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> 12.3% from last week
                        </div>
                    </div>
                    <i class="fas fa-shopping-cart stat-bg"></i>
                </div>

                <div class="stat-card">
                    <div class="stat-icon stat-icon-reserved">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">42,850</div>
                        <div class="stat-label">Reserved Tickets</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> 5.7% from last week
                        </div>
                    </div>
                    <i class="fas fa-clock stat-bg"></i>
                </div>

                <div class="stat-card">
                    <div class="stat-icon stat-icon-revenue">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">$100.2M</div>
                        <div class="stat-label">Total Revenue</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> 15.8% from last week
                        </div>
                    </div>
                    <i class="fas fa-dollar-sign stat-bg"></i>
                </div>
            </div>

            <!-- Ticket Filters -->
            <div class="ticket-filters">
                <form class="filters-form">
                    <div class="filter-group">
                        <label for="match-filter" class="filter-label">Match</label>
                        <select id="match-filter" class="filter-select">
                            <option value="">All Matches</option>
                            <option value="1">Brazil vs Germany</option>
                            <option value="2">Spain vs Portugal</option>
                            <option value="3">France vs Netherlands</option>
                            <option value="4">Argentina vs England</option>
                            <option value="5">Italy vs Belgium</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="date-filter" class="filter-label">Date</label>
                        <input type="date" id="date-filter" class="filter-input">
                    </div>

                    <div class="filter-group">
                        <label for="category-filter" class="filter-label">Category</label>
                        <select id="category-filter" class="filter-select">
                            <option value="">All Categories</option>
                            <option value="1">Category 1</option>
                            <option value="2">Category 2</option>
                            <option value="3">Category 3</option>
                            <option value="4">VIP</option>
                            <option value="5">Hospitality</option>
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
                        <button type="submit" class="btn">
                            <i class="fas fa-filter"></i> Apply Filters
                        </button>
                        <button type="reset" class="btn btn-outline">
                            <i class="fas fa-times"></i> Clear
                        </button>
                    </div>
                </form>
            </div>

            <!-- Ticket Management -->
            <div class="ticket-management">
                <div class="management-header">
                    <h3 class="management-title">All Tickets</h3>
                    <div class="management-actions">
                        <button class="btn btn-outline">
                            <i class="fas fa-download"></i> Export
                        </button>
                        <button class="btn btn-outline" id="showSeatMap">
                            <i class="fas fa-map"></i> Seat Map
                        </button>
                        <button class="btn">
                            <i class="fas fa-plus"></i> Add Tickets
                        </button>
                    </div>
                </div>

                <div class="ticket-bulk-actions" id="bulkActions">
                    <div class="bulk-selected">
                        <span id="selectedCount">0</span> tickets selected
                    </div>
                    <div class="bulk-actions">
                        <button class="btn btn-outline">
                            <i class="fas fa-tag"></i> Change Price
                        </button>
                        <button class="btn btn-outline">
                            <i class="fas fa-exchange-alt"></i> Change Status
                        </button>
                        <button class="btn btn-outline btn-danger">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>

                <div class="ticket-table-container">
                    <table class="ticket-table">
                        <thead>
                            <tr>
                                <th>
                                    <div class="ticket-checkbox">
                                        <input type="checkbox" class="bulk-checkbox" id="selectAll">
                                    </div>
                                </th>
                                <th>Ticket ID</th>
                                <th>Match</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Category</th>
                                <th>Section</th>
                                <th>Row/Seat</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="ticket-checkbox">
                                        <input type="checkbox" class="bulk-checkbox ticket-check">
                                    </div>
                                </td>
                                <td><span class="ticket-id">TKT-1001</span></td>
                                <td>
                                    <div class="ticket-match">
                                        <div class="ticket-flags">
                                            <div class="ticket-flag"
                                                style="background-image: url('https://via.placeholder.com/30x20/3498db/ffffff?text=BRA')">
                                            </div>
                                            <div class="ticket-flag"
                                                style="background-image: url('https://via.placeholder.com/30x20/e74c3c/ffffff?text=GER')">
                                            </div>
                                        </div>
                                        Brazil vs Germany
                                    </div>
                                </td>
                                <td>June 12, 2030</td>
                                <td>15:00 GMT</td>
                                <td>Category 1</td>
                                <td>A</td>
                                <td>10/15</td>
                                <td class="ticket-price">$350</td>
                                <td><span class="ticket-status status-sold">Sold</span></td>
                                <td>
                                    <div class="ticket-actions">
                                        <div class="action-icon action-icon-edit">
                                            <i class="fas fa-edit"></i>
                                        </div>
                                        <div class="action-icon action-icon-delete">
                                            <i class="fas fa-trash"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="ticket-checkbox">
                                        <input type="checkbox" class="bulk-checkbox ticket-check">
                                    </div>
                                </td>
                                <td><span class="ticket-id">TKT-1002</span></td>
                                <td>
                                    <div class="ticket-match">
                                        <div class="ticket-flags">
                                            <div class="ticket-flag"
                                                style="background-image: url('https://via.placeholder.com/30x20/f39c12/ffffff?text=ESP')">
                                            </div>
                                            <div class="ticket-flag"
                                                style="background-image: url('https://via.placeholder.com/30x20/2ecc71/ffffff?text=POR')">
                                            </div>
                                        </div>
                                        Spain vs Portugal
                                    </div>
                                </td>
                                <td>June 13, 2030</td>
                                <td>12:00 GMT</td>
                                <td>Category 2</td>
                                <td>B</td>
                                <td>5/22</td>
                                <td class="ticket-price">$250</td>
                                <td><span class="ticket-status status-available">Available</span></td>
                                <td>
                                    <div class="ticket-actions">
                                        <div class="action-icon action-icon-edit">
                                            <i class="fas fa-edit"></i>
                                        </div>
                                        <div class="action-icon action-icon-delete">
                                            <i class="fas fa-trash"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="ticket-checkbox">
                                        <input type="checkbox" class="bulk-checkbox ticket-check">
                                    </div>
                                </td>
                                <td><span class="ticket-id">TKT-1003</span></td>
                                <td>
                                    <div class="ticket-match">
                                        <div class="ticket-flags">
                                            <div class="ticket-flag"
                                                style="background-image: url('https://via.placeholder.com/30x20/9b59b6/ffffff?text=FRA')">
                                            </div>
                                            <div class="ticket-flag"
                                                style="background-image: url('https://via.placeholder.com/30x20/e67e22/ffffff?text=NED')">
                                            </div>
                                        </div>
                                        France vs Netherlands
                                    </div>
                                </td>
                                <td>June 13, 2030</td>
                                <td>18:00 GMT</td>
                                <td>VIP</td>
                                <td>VIP-A</td>
                                <td>2/8</td>
                                <td class="ticket-price">$750</td>
                                <td><span class="ticket-status status-reserved">Reserved</span></td>
                                <td>
                                    <div class="ticket-actions">
                                        <div class="action-icon action-icon-edit">
                                            <i class="fas fa-edit"></i>
                                        </div>
                                        <div class="action-icon action-icon-delete">
                                            <i class="fas fa-trash"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="ticket-checkbox">
                                        <input type="checkbox" class="bulk-checkbox ticket-check">
                                    </div>
                                </td>
                                <td><span class="ticket-id">TKT-1004</span></td>
                                <td>
                                    <div class="ticket-match">
                                        <div class="ticket-flags">
                                            <div class="ticket-flag"
                                                style="background-image: url('https://via.placeholder.com/30x20/1abc9c/ffffff?text=ARG')">
                                            </div>
                                            <div class="ticket-flag"
                                                style="background-image: url('https://via.placeholder.com/30x20/34495e/ffffff?text=ENG')">
                                            </div>
                                        </div>
                                        Argentina vs England
                                    </div>
                                </td>
                                <td>June 14, 2030</td>
                                <td>15:00 GMT</td>
                                <td>Category 1</td>
                                <td>C</td>
                                <td>8/12</td>
                                <td class="ticket-price">$350</td>
                                <td><span class="ticket-status status-available">Available</span></td>
                                <td>
                                    <div class="ticket-actions">
                                        <div class="action-icon action-icon-edit">
                                            <i class="fas fa-edit"></i>
                                        </div>
                                        <div class="action-icon action-icon-delete">
                                            <i class="fas fa-trash"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="ticket-checkbox">
                                        <input type="checkbox" class="bulk-checkbox ticket-check">
                                    </div>
                                </td>
                                <td><span class="ticket-id">TKT-1005</span></td>
                                <td>
                                    <div class="ticket-match">
                                        <div class="ticket-flags">
                                            <div class="ticket-flag"
                                                style="background-image: url('https://via.placeholder.com/30x20/3498db/ffffff?text=ITA')">
                                            </div>
                                            <div class="ticket-flag"
                                                style="background-image: url('https://via.placeholder.com/30x20/e74c3c/ffffff?text=BEL')">
                                            </div>
                                        </div>
                                        Italy vs Belgium
                                    </div>
                                </td>
                                <td>June 15, 2030</td>
                                <td>12:00 GMT</td>
                                <td>Category 3</td>
                                <td>D</td>
                                <td>15/20</td>
                                <td class="ticket-price">$150</td>
                                <td><span class="ticket-status status-sold">Sold</span></td>
                                <td>
                                    <div class="ticket-actions">
                                        <div class="action-icon action-icon-edit">
                                            <i class="fas fa-edit"></i>
                                        </div>
                                        <div class="action-icon action-icon-delete">
                                            <i class="fas fa-trash"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="ticket-checkbox">
                                        <input type="checkbox" class="bulk-checkbox ticket-check">
                                    </div>
                                </td>
                                <td><span class="ticket-id">TKT-1006</span></td>
                                <td>
                                    <div class="ticket-match">
                                        <div class="ticket-flags">
                                            <div class="ticket-flag"
                                                style="background-image: url('https://via.placeholder.com/30x20/f39c12/ffffff?text=URU')">
                                            </div>
                                            <div class="ticket-flag"
                                                style="background-image: url('https://via.placeholder.com/30x20/2ecc71/ffffff?text=CRO')">
                                            </div>
                                        </div>
                                        Uruguay vs Croatia
                                    </div>
                                </td>
                                <td>June 15, 2030</td>
                                <td>18:00 GMT</td>
                                <td>Hospitality</td>
                                <td>H-1</td>
                                <td>1/4</td>
                                <td class="ticket-price">$1,200</td>
                                <td><span class="ticket-status status-sold">Sold</span></td>
                                <td>
                                    <div class="ticket-actions">
                                        <div class="action-icon action-icon-edit">
                                            <i class="fas fa-edit"></i>
                                        </div>
                                        <div class="action-icon action-icon-delete">
                                            <i class="fas fa-trash"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="ticket-checkbox">
                                        <input type="checkbox" class="bulk-checkbox ticket-check">
                                    </div>
                                </td>
                                <td><span class="ticket-id">TKT-1007</span></td>
                                <td>
                                    <div class="ticket-match">
                                        <div class="ticket-flags">
                                            <div class="ticket-flag"
                                                style="background-image: url('https://via.placeholder.com/30x20/3498db/ffffff?text=BRA')">
                                            </div>
                                            <div class="ticket-flag"
                                                style="background-image: url('https://via.placeholder.com/30x20/e74c3c/ffffff?text=GER')">
                                            </div>
                                        </div>
                                        Brazil vs Germany
                                    </div>
                                </td>
                                <td>June 12, 2030</td>
                                <td>15:00 GMT</td>
                                <td>Category 2</td>
                                <td>B</td>
                                <td>12/18</td>
                                <td class="ticket-price">$250</td>
                                <td><span class="ticket-status status-canceled">Canceled</span></td>
                                <td>
                                    <div class="ticket-actions">
                                        <div class="action-icon action-icon-edit">
                                            <i class="fas fa-edit"></i>
                                        </div>
                                        <div class="action-icon action-icon-delete">
                                            <i class="fas fa-trash"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="tickets-pagination">
                <div class="pagination-arrow disabled">
                    <i class="fas fa-chevron-left"></i>
                </div>
                <div class="pagination-item active">1</div>
                <div class="pagination-item">2</div>
                <div class="pagination-item">3</div>
                <div class="pagination-item">4</div>
                <div class="pagination-item">5</div>
                <div class="pagination-arrow">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>

            <!-- Ticket Categories -->
            <div class="ticket-categories">
                <div class="management-header">
                    <h3 class="management-title">Ticket Categories</h3>
                    <div class="management-actions">
                        <button class="btn">
                            <i class="fas fa-plus"></i> Add Category
                        </button>
                    </div>
                </div>

                <div class="ticket-table-container">
                    <table class="categories-table">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Base Price</th>
                                <th>Availability</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <span class="category-color" style="background-color: var(--primary);"></span>
                                    <span class="category-name">Category 1</span>
                                </td>
                                <td class="category-price">$350</td>
                                <td>
                                    <div class="category-availability">
                                        <div class="availability-indicator indicator-available">
                                            <i class="fas fa-circle"></i> 45,200
                                        </div>
                                        <div class="availability-indicator indicator-sold">
                                            <i class="fas fa-circle"></i> 154,800
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="ticket-actions">
                                        <div class="action-icon action-icon-edit">
                                            <i class="fas fa-edit"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="category-color" style="background-color: var(--info);"></span>
                                    <span class="category-name">Category 2</span>
                                </td>
                                <td class="category-price">$250</td>
                                <td>
                                    <div class="category-availability">
                                        <div class="availability-indicator indicator-available">
                                            <i class="fas fa-circle"></i> 78,600
                                        </div>
                                        <div class="availability-indicator indicator-sold">
                                            <i class="fas fa-circle"></i> 221,400
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="ticket-actions">
                                        <div class="action-icon action-icon-edit">
                                            <i class="fas fa-edit"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="category-color" style="background-color: var(--success);"></span>
                                    <span class="category-name">Category 3</span>
                                </td>
                                <td class="category-price">$150</td>
                                <td>
                                    <div class="category-availability">
                                        <div class="availability-indicator indicator-available">
                                            <i class="fas fa-circle"></i> 125,800
                                        </div>
                                        <div class="availability-indicator indicator-sold">
                                            <i class="fas fa-circle"></i> 374,200
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="ticket-actions">
                                        <div class="action-icon action-icon-edit">
                                            <i class="fas fa-edit"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="category-color" style="background-color: var(--accent);"></span>
                                    <span class="category-name">VIP</span>
                                </td>
                                <td class="category-price">$750</td>
                                <td>
                                    <div class="category-availability">
                                        <div class="availability-indicator indicator-available">
                                            <i class="fas fa-circle"></i> 8,650
                                        </div>
                                        <div class="availability-indicator indicator-sold">
                                            <i class="fas fa-circle"></i> 41,350
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="ticket-actions">
                                        <div class="action-icon action-icon-edit">
                                            <i class="fas fa-edit"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="category-color" style="background-color: var(--secondary);"></span>
                                    <span class="category-name">Hospitality</span>
                                </td>
                                <td class="category-price">$1,200</td>
                                <td>
                                    <div class="category-availability">
                                        <div class="availability-indicator indicator-available">
                                            <i class="fas fa-circle"></i> 2,170
                                        </div>
                                        <div class="availability-indicator indicator-sold">
                                            <i class="fas fa-circle"></i> 17,830
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="ticket-actions">
                                        <div class="action-icon action-icon-edit">
                                            <i class="fas fa-edit"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Ticket Sales Chart -->
            <div class="ticket-sales-chart">
                <div class="management-header">
                    <h3 class="management-title">Ticket Sales Trend</h3>
                    <div class="management-actions">
                        <button class="btn btn-outline btn-sm">
                            <i class="fas fa-calendar"></i> Monthly
                        </button>
                    </div>
                </div>

                <div class="chart-container">
                    <canvas id="salesTrendChart"></canvas>
                </div>
            </div>

            <!-- Ticket Alerts -->
            <div class="ticket-alerts">
                <div class="management-header">
                    <h3 class="management-title">Ticket Alerts</h3>
                    <div class="management-actions">
                        <button class="btn btn-outline btn-sm">
                            <i class="fas fa-eye"></i> View All
                        </button>
                    </div>
                </div>

                <ul class="alerts-list">
                    <li class="alert-item">
                        <div class="alert-icon alert-icon-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="alert-content">
                            <div class="alert-title">Low inventory for Category 1 - Brazil vs Germany</div>
                            <div class="alert-text">Only 15% of tickets are still available. Consider adjusting
                                prices or releasing more tickets.</div>
                            <div class="alert-meta">
                                <div class="alert-time">
                                    <i class="far fa-clock"></i> 2 hours ago
                                </div>
                                <div class="alert-actions">
                                    <button class="btn btn-sm">Take Action</button>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="alert-item">
                        <div class="alert-icon alert-icon-info">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="alert-content">
                            <div class="alert-title">Price adjustment suggestion</div>
                            <div class="alert-text">Sales for Category 3 - Argentina vs England are slower than
                                expected. Consider a price adjustment.</div>
                            <div class="alert-meta">
                                <div class="alert-time">
                                    <i class="far fa-clock"></i> 5 hours ago
                                </div>
                                <div class="alert-actions">
                                    <button class="btn btn-sm">Adjust Price</button>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="alert-item">
                        <div class="alert-icon alert-icon-success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="alert-content">
                            <div class="alert-title">VIP section sold out - Spain vs Portugal</div>
                            <div class="alert-text">All VIP tickets have been sold. Great job!</div>
                            <div class="alert-meta">
                                <div class="alert-time">
                                    <i class="far fa-clock"></i> 1 day ago
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="alert-item">
                        <div class="alert-icon alert-icon-danger">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="alert-content">
                            <div class="alert-title">High refund rate detected</div>
                            <div class="alert-text">Unusually high refund rate for Category 2 - Italy vs Belgium.
                                Please investigate.</div>
                            <div class="alert-meta">
                                <div class="alert-time">
                                    <i class="far fa-clock"></i> 2 days ago
                                </div>
                                <div class="alert-actions">
                                    <button class="btn btn-sm">Investigate</button>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Recent Sales -->
            <div class="recent-sales">
                <div class="management-header">
                    <h3 class="management-title">Recent Sales</h3>
                    <div class="management-actions">
                        <button class="btn btn-outline btn-sm">
                            <i class="fas fa-eye"></i> View All
                        </button>
                    </div>
                </div>

                <ul class="sales-list">
                    <li class="sale-item">
                        <div class="sale-user">
                            <img src="https://via.placeholder.com/40x40" alt="User Avatar">
                        </div>
                        <div class="sale-details">
                            <div class="sale-customer">John Smith</div>
                            <div class="sale-match">Brazil vs Germany - Category 1</div>
                        </div>
                        <div class="sale-amount">$350</div>
                        <div class="sale-time">10 minutes ago</div>
                    </li>
                    <li class="sale-item">
                        <div class="sale-user">
                            <img src="https://via.placeholder.com/40x40" alt="User Avatar">
                        </div>
                        <div class="sale-details">
                            <div class="sale-customer">Maria Rodriguez</div>
                            <div class="sale-match">Spain vs Portugal - VIP</div>
                        </div>
                        <div class="sale-amount">$750</div>
                        <div class="sale-time">25 minutes ago</div>
                    </li>
                    <li class="sale-item">
                        <div class="sale-user">
                            <img src="https://via.placeholder.com/40x40" alt="User Avatar">
                        </div>
                        <div class="sale-details">
                            <div class="sale-customer">David Johnson</div>
                            <div class="sale-match">France vs Netherlands - Category 2</div>
                        </div>
                        <div class="sale-amount">$250</div>
                        <div class="sale-time">42 minutes ago</div>
                    </li>
                    <li class="sale-item">
                        <div class="sale-user">
                            <img src="https://via.placeholder.com/40x40" alt="User Avatar">
                        </div>
                        <div class="sale-details">
                            <div class="sale-customer">Sarah Williams</div>
                            <div class="sale-match">Argentina vs England - Category 3</div>
                        </div>
                        <div class="sale-amount">$150</div>
                        <div class="sale-time">1 hour ago</div>
                    </li>
                    <li class="sale-item">
                        <div class="sale-user">
                            <img src="https://via.placeholder.com/40x40" alt="User Avatar">
                        </div>
                        <div class="sale-details">
                            <div class="sale-customer">Miguel Fernandez</div>
                            <div class="sale-match">Italy vs Belgium - Hospitality</div>
                        </div>
                        <div class="sale-amount">$1,200</div>
                        <div class="sale-time">1 hour ago</div>
                    </li>
                </ul>
            </div>
        </div>
    </main>
@endsection

@section('modal')
    <!-- Seat Map Modal -->
    <div class="modal-backdrop" id="seatMapModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Stadium Seat Map</h3>
                <div class="modal-close" id="closeSeatMap">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="modal-body">
                <div class="seat-map-container">
                    <div class="seat-map">
                        <div class="stadium-outline"></div>
                        <div class="field">
                            <div class="field-lines"></div>
                        </div>
                        <div class="seat-section section-a">Section A (Category 1)</div>
                        <div class="seat-section section-b">Section B (Category 2)</div>
                        <div class="seat-section section-c">Section C (Category 2)</div>
                        <div class="seat-section section-d">Section D (Category 3)</div>
                    </div>
                    <div class="seat-legend">
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: var(--primary);"></div>
                            <span>Category 1</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: var(--info);"></div>
                            <span>Category 2</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: var(--success);"></div>
                            <span>Category 3</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: var(--accent);"></div>
                            <span>VIP</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" id="closeSeatMapBtn">Close</button>
                <button class="btn">Edit Seat Map</button>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const menuToggle = document.getElementById('menu-toggle');
            const sidebar = document.getElementById('sidebar');

            if (menuToggle) {
                menuToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }

            // Bulk actions
            const selectAll = document.getElementById('selectAll');
            const ticketChecks = document.querySelectorAll('.ticket-check');
            const bulkActions = document.getElementById('bulkActions');
            const selectedCount = document.getElementById('selectedCount');

            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    const isChecked = this.checked;

                    ticketChecks.forEach(check => {
                        check.checked = isChecked;
                    });

                    updateBulkActions();
                });
            }

            if (ticketChecks.length) {
                ticketChecks.forEach(check => {
                    check.addEventListener('change', function() {
                        updateBulkActions();

                        // Update selectAll state
                        const allChecked = Array.from(ticketChecks).every(c => c.checked);
                        const someChecked = Array.from(ticketChecks).some(c => c.checked);

                        if (selectAll) {
                            selectAll.checked = allChecked;
                            selectAll.indeterminate = someChecked && !allChecked;
                        }
                    });
                });
            }

            function updateBulkActions() {
                const checkedCount = document.querySelectorAll('.ticket-check:checked').length;

                if (checkedCount > 0) {
                    bulkActions.classList.add('show');
                    selectedCount.textContent = checkedCount;
                } else {
                    bulkActions.classList.remove('show');
                    selectedCount.textContent = '0';
                }
            }

            // Seat Map Modal
            const showSeatMap = document.getElementById('showSeatMap');
            const seatMapModal = document.getElementById('seatMapModal');
            const closeSeatMap = document.getElementById('closeSeatMap');
            const closeSeatMapBtn = document.getElementById('closeSeatMapBtn');

            if (showSeatMap && seatMapModal) {
                showSeatMap.addEventListener('click', function() {
                    seatMapModal.classList.add('show');
                });

                if (closeSeatMap) {
                    closeSeatMap.addEventListener('click', function() {
                        seatMapModal.classList.remove('show');
                    });
                }

                if (closeSeatMapBtn) {
                    closeSeatMapBtn.addEventListener('click', function() {
                        seatMapModal.classList.remove('show');
                    });
                }

                // Close on click outside
                seatMapModal.addEventListener('click', function(e) {
                    if (e.target === seatMapModal) {
                        seatMapModal.classList.remove('show');
                    }
                });
            }

            // Sales Trend Chart
            const salesTrendCtx = document.getElementById('salesTrendChart');

            if (salesTrendCtx) {
                const salesTrendChart = new Chart(salesTrendCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                            'Nov', 'Dec'
                        ],
                        datasets: [{
                                label: 'Tickets Sold',
                                data: [12000, 19000, 25000, 30000, 45000, 60000, 82000, 110000, 145000,
                                    180000, 210000, 240000
                                ],
                                borderColor: '#e63946',
                                backgroundColor: 'rgba(230, 57, 70, 0.1)',
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Revenue ($000s)',
                                data: [2400, 3800, 5000, 6500, 9500, 13500, 19000, 26000, 35000, 44000,
                                    52000, 60000
                                ],
                                borderColor: '#3498db',
                                backgroundColor: 'rgba(52, 152, 219, 0.1)',
                                tension: 0.4,
                                fill: true,
                                yAxisID: 'y1'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top'
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Tickets Sold'
                                }
                            },
                            y1: {
                                position: 'right',
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Revenue ($000s)'
                                },
                                grid: {
                                    drawOnChartArea: false
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection