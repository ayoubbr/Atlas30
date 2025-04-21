@extends('admin.layout')

@section('title', 'Admin Dashboard - World Cup 2030')

@section('css')
    <style>
        /* Main Content */
        .admin-main {
            grid-area: main;
            padding: 30px;
            overflow-y: auto;
        }

        /* Stadium Dashboard Layout */
        .stadium-dashboard {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            grid-template-rows: auto auto auto;
            gap: 20px;
            margin-bottom: 30px;
        }

        /* Stadium Visualization */
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

        .stat-icon-users {
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
            grid-column: span 8;
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
        }

        .timeline-day {
            flex: 1;
            min-width: 150px;
            border-right: 1px dashed var(--gray-300);
            padding-right: 15px;
        }

        .timeline-day:last-child {
            border-right: none;
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
            flex-direction: column;
            gap: 15px;
        }

        .match-card {
            background-color: var(--gray-100);
            border-radius: var(--border-radius);
            padding: 15px;
            transition: var(--transition);
            cursor: pointer;
            border-left: 3px solid var(--primary);
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

        .status-scheduled {
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
            grid-column: span 4;
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

        /* User Map */
        .user-map {
            grid-column: span 6;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .map-container {
            flex: 1;
            padding: 20px;
            position: relative;
            min-height: 300px;
        }

        .world-map {
            width: 100%;
            height: 100%;
            background-image: url('https://via.placeholder.com/800x400?text=World+Map');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }

        .map-marker {
            position: absolute;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: var(--primary);
            transform: translate(-50%, -50%);
            cursor: pointer;
            transition: var(--transition);
        }

        .map-marker::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: var(--primary);
            opacity: 0.5;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.5;
            }

            70% {
                transform: scale(2);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 0;
            }
        }

        .map-tooltip {
            position: absolute;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            padding: 10px;
            font-size: 0.8rem;
            z-index: 10;
            min-width: 150px;
            display: none;
        }

        .map-tooltip.show {
            display: block;
        }

        .tooltip-title {
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--gray-800);
        }

        .tooltip-content {
            color: var(--gray-600);
        }

        .map-legend {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: var(--border-radius);
            padding: 10px;
            font-size: 0.8rem;
            box-shadow: var(--shadow);
        }

        .map-legend-title {
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--gray-800);
        }

        .map-legend-items {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .map-legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .legend-marker {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .legend-text {
            color: var(--gray-600);
        }

        /* Recent Users */
        .recent-users {
            grid-column: span 6;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .user-list {
            padding: 0;
            list-style: none;
        }

        .user-item {
            padding: 15px 20px;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            gap: 15px;
            transition: var(--transition);
        }

        .user-item:last-child {
            border-bottom: none;
        }

        .user-item:hover {
            background-color: var(--gray-100);
        }

        .user-avatar-sm {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--gray-300);
            overflow: hidden;
            flex-shrink: 0;
        }

        .user-avatar-sm img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-details {
            flex: 1;
        }

        .user-name-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 5px;
        }

        .user-fullname {
            font-weight: 600;
            color: var(--gray-800);
        }

        .user-username {
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        .user-badge {
            padding: 2px 6px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .badge-admin {
            background-color: var(--danger-light);
            color: var(--danger);
        }

        .badge-moderator {
            background-color: var(--warning-light);
            color: var(--warning);
        }

        .badge-vip {
            background-color: var(--accent-light);
            color: var(--accent-dark);
        }

        .user-info {
            display: flex;
            gap: 15px;
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        .user-info-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .user-actions {
            display: flex;
            gap: 10px;
        }

        /* Ticket Categories */
        .ticket-categories {
            grid-column: span 6;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .categories-chart-container {
            padding: 20px;
            height: 300px;
            position: relative;
        }

        /* Responsive Styles */
        @media (max-width: 1200px) {
            .stadium-dashboard {
                grid-template-columns: repeat(6, 1fr);
            }

            .match-management,
            .ticket-sales,
            .forum-activity,
            .user-map,
            .recent-users,
            .ticket-categories {
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
            .user-map,
            .recent-users,
            .ticket-categories {
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
            .user-map,
            .recent-users,
            .ticket-categories {
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
    <!-- Main Content -->
    <main class="admin-main">
        <!-- Stadium Dashboard -->
        <div class="stadium-dashboard">
            <!-- Stadium Visualization -->
            <div class="stadium-visualization">
                <div class="stadium-header">
                    <div>
                        <h2 class="stadium-title">World Cup 2030 Dashboard</h2>
                        <div class="stadium-subtitle">Welcome back, John! Here's what's happening with the
                            tournament.</div>
                    </div>
                    <div class="stadium-actions">
                        <button class="stadium-btn">
                            <i class="fas fa-download"></i> Export
                        </button>
                        <button class="stadium-btn stadium-btn-primary">
                            <i class="fas fa-plus"></i> New Match
                        </button>
                    </div>
                </div>

                <div class="stadium-metrics">
                    <div class="stadium-metric">
                        <div class="metric-value">64</div>
                        <div class="metric-label">Total Matches</div>
                    </div>
                    <div class="stadium-metric">
                        <div class="metric-value">32</div>
                        <div class="metric-label">Teams</div>
                    </div>
                    <div class="stadium-metric">
                        <div class="metric-value">12</div>
                        <div class="metric-label">Venues</div>
                    </div>
                    <div class="stadium-metric">
                        <div class="metric-value">1.2M</div>
                        <div class="metric-label">Tickets Sold</div>
                    </div>
                    <div class="stadium-metric">
                        <div class="metric-value">1.2M</div>
                        <div class="metric-label">Tickets Sold</div>
                    </div>
                    <div class="stadium-metric">
                        <div class="metric-value">1.2M</div>
                        <div class="metric-label">Tickets Sold</div>
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
                        <div class="stat-value">24</div>
                        <div class="stat-label">Upcoming Matches</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> 12% from last month
                        </div>
                    </div>
                    <i class="fas fa-futbol stat-bg"></i>
                </div>

                <div class="stat-card">
                    <div class="stat-icon stat-icon-tickets">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">85,432</div>
                        <div class="stat-label">Tickets Sold This Week</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> 8% from last week
                        </div>
                    </div>
                    <i class="fas fa-ticket-alt stat-bg"></i>
                </div>

                <div class="stat-card">
                    <div class="stat-icon stat-icon-users">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">12,845</div>
                        <div class="stat-label">New Users</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> 24% from last month
                        </div>
                    </div>
                    <i class="fas fa-user stat-bg"></i>
                </div>

                <div class="stat-card">
                    <div class="stat-icon stat-icon-posts">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">3,721</div>
                        <div class="stat-label">Forum Posts</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> 18% from last month
                        </div>
                    </div>
                    <i class="fas fa-comments stat-bg"></i>
                </div>
            </div>

            <!-- Match Management -->
            <div class="match-management">
                <div class="section-header">
                    <h3 class="section-title">Match Schedule</h3>
                    <div class="section-actions">
                        <button class="btn btn-outline">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <button class="btn">
                            <i class="fas fa-plus"></i> Add Match
                        </button>
                    </div>
                </div>

                <div class="match-timeline">
                    <div class="timeline">
                        <div class="timeline-day">
                            <div class="day-header">
                                <div class="day-date">June 12, 2030</div>
                                <div class="day-name">Wednesday</div>
                            </div>

                            <div class="match-cards">
                                <div class="match-card">
                                    <div class="match-time">15:00 GMT</div>
                                    <div class="match-teams">
                                        <div class="match-team">
                                            <div class="team-flag"
                                                style="background-image: url('https://seekflag.com/wp-content/uploads/2021/11/Flag-of-Brazil-01-1.svg')">
                                            </div>
                                            <div class="team-name">Brazil</div>
                                        </div>
                                        <div class="match-vs">VS</div>
                                        <div class="match-team">
                                            <div class="team-flag"
                                                style="background-image: url('https://seekflag.com/wp-content/uploads/2021/11/Flag-of-Germany-01-1.svg')">
                                            </div>
                                            <div class="team-name">Germany</div>
                                        </div>
                                    </div>
                                    <div class="match-venue">
                                        <i class="fas fa-map-marker-alt"></i> Rio Stadium, Brazil
                                    </div>
                                    <div class="match-status">
                                        <span class="status-badge status-scheduled">Scheduled</span>
                                        <div class="match-actions">
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="timeline-day">
                            <div class="day-header">
                                <div class="day-date">June 13, 2030</div>
                                <div class="day-name">Thursday</div>
                            </div>

                            <div class="match-cards">
                                <div class="match-card">
                                    <div class="match-time">12:00 GMT</div>
                                    <div class="match-teams">
                                        <div class="match-team">
                                            <div class="team-flag"
                                                style="background-image: url('https://seekflag.com/wp-content/uploads/2021/12/Flag-of-Spain-01-2.svg')">
                                            </div>
                                            <div class="team-name">Spain</div>
                                        </div>
                                        <div class="match-vs">VS</div>
                                        <div class="match-team">
                                            <div class="team-flag"
                                                style="background-image: url('https://seekflag.com/wp-content/uploads/2021/12/portugal-01-1.svg')">
                                            </div>
                                            <div class="team-name">Portugal</div>
                                        </div>
                                    </div>
                                    <div class="match-venue">
                                        <i class="fas fa-map-marker-alt"></i> Madrid Stadium, Spain
                                    </div>
                                    <div class="match-status">
                                        <span class="status-badge status-scheduled">Scheduled</span>
                                        <div class="match-actions">
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="match-card">
                                    <div class="match-time">18:00 GMT</div>
                                    <div class="match-teams">
                                        <div class="match-team">
                                            <div class="team-flag"
                                                style="background-image: url('https://seekflag.com/wp-content/uploads/2021/11/Flag-of-France-01-1.svg')">
                                            </div>
                                            <div class="team-name">France</div>
                                        </div>
                                        <div class="match-vs">VS</div>
                                        <div class="match-team">
                                            <div class="team-flag"
                                                style="background-image: url('https://via.placeholder.com/30x20/e67e22/ffffff?text=NED')">
                                            </div>
                                            <div class="team-name">Netherlands</div>
                                        </div>
                                    </div>
                                    <div class="match-venue">
                                        <i class="fas fa-map-marker-alt"></i> Paris Stadium, France
                                    </div>
                                    <div class="match-status">
                                        <span class="status-badge status-scheduled">Scheduled</span>
                                        <div class="match-actions">
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="timeline-day">
                            <div class="day-header">
                                <div class="day-date">June 14, 2030</div>
                                <div class="day-name">Friday</div>
                            </div>

                            <div class="match-cards">
                                <div class="match-card">
                                    <div class="match-time">15:00 GMT</div>
                                    <div class="match-teams">
                                        <div class="match-team">
                                            <div class="team-flag"
                                                style="background-image: url('https://via.placeholder.com/30x20/1abc9c/ffffff?text=ARG')">
                                            </div>
                                            <div class="team-name">Argentina</div>
                                        </div>
                                        <div class="match-vs">VS</div>
                                        <div class="match-team">
                                            <div class="team-flag"
                                                style="background-image: url('https://via.placeholder.com/30x20/34495e/ffffff?text=ENG')">
                                            </div>
                                            <div class="team-name">England</div>
                                        </div>
                                    </div>
                                    <div class="match-venue">
                                        <i class="fas fa-map-marker-alt"></i> Buenos Aires Stadium, Argentina
                                    </div>
                                    <div class="match-status">
                                        <span class="status-badge status-scheduled">Scheduled</span>
                                        <div class="match-actions">
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="timeline-day">
                            <div class="day-header">
                                <div class="day-date">June 15, 2030</div>
                                <div class="day-name">Saturday</div>
                            </div>

                            <div class="match-cards">
                                <div class="match-card">
                                    <div class="match-time">12:00 GMT</div>
                                    <div class="match-teams">
                                        <div class="match-team">
                                            <div class="team-flag"
                                                style="background-image: url('https://via.placeholder.com/30x20/3498db/ffffff?text=ITA')">
                                            </div>
                                            <div class="team-name">Italy</div>
                                        </div>
                                        <div class="match-vs">VS</div>
                                        <div class="match-team">
                                            <div class="team-flag"
                                                style="background-image: url('https://via.placeholder.com/30x20/e74c3c/ffffff?text=BEL')">
                                            </div>
                                            <div class="team-name">Belgium</div>
                                        </div>
                                    </div>
                                    <div class="match-venue">
                                        <i class="fas fa-map-marker-alt"></i> Rome Stadium, Italy
                                    </div>
                                    <div class="match-status">
                                        <span class="status-badge status-scheduled">Scheduled</span>
                                        <div class="match-actions">
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="match-card">
                                    <div class="match-time">18:00 GMT</div>
                                    <div class="match-teams">
                                        <div class="match-team">
                                            <div class="team-flag"
                                                style="background-image: url('https://via.placeholder.com/30x20/f39c12/ffffff?text=URU')">
                                            </div>
                                            <div class="team-name">Uruguay</div>
                                        </div>
                                        <div class="match-vs">VS</div>
                                        <div class="match-team">
                                            <div class="team-flag"
                                                style="background-image: url('https://via.placeholder.com/30x20/2ecc71/ffffff?text=CRO')">
                                            </div>
                                            <div class="team-name">Croatia</div>
                                        </div>
                                    </div>
                                    <div class="match-venue">
                                        <i class="fas fa-map-marker-alt"></i> Montevideo Stadium, Uruguay
                                    </div>
                                    <div class="match-status">
                                        <span class="status-badge status-scheduled">Scheduled</span>
                                        <div class="match-actions">
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ticket Sales -->
            <div class="ticket-sales">
                <div class="section-header">
                    <h3 class="section-title">Ticket Sales</h3>
                    <div class="section-actions">
                        <button class="btn btn-outline btn-sm">
                            <i class="fas fa-calendar"></i> Monthly
                        </button>
                    </div>
                </div>

                <div class="ticket-chart-container">
                    <div class="chart-header">
                        <div class="chart-title">Sales Trend</div>
                        <div class="chart-legend">
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
                        </div>
                    </div>

                    <div class="chart-container">
                        <canvas id="ticketSalesChart"></canvas>
                    </div>
                </div>

                <div class="ticket-stats">
                    <div class="ticket-stat">
                        <div class="ticket-stat-value">85%</div>
                        <div class="ticket-stat-label">Category 1</div>
                    </div>
                    <div class="ticket-stat">
                        <div class="ticket-stat-value">72%</div>
                        <div class="ticket-stat-label">Category 2</div>
                    </div>
                    <div class="ticket-stat">
                        <div class="ticket-stat-value">64%</div>
                        <div class="ticket-stat-label">Category 3</div>
                    </div>
                </div>
            </div>

            <!-- Forum Activity -->
            <div class="forum-activity">
                <div class="section-header">
                    <h3 class="section-title">Recent Forum Activity</h3>
                    <div class="section-actions">
                        <button class="btn">
                            <i class="fas fa-eye"></i> View All
                        </button>
                    </div>
                </div>

                <ul class="activity-list">
                    <li class="activity-item">
                        <div class="activity-icon activity-icon-post">
                            <i class="fas fa-comment-alt"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">New Thread: "Brazil vs France - Match Predictions"</div>
                            <div class="activity-text">SoccerExpert started a new discussion about the upcoming
                                match between Brazil and France.</div>
                            <div class="activity-meta">
                                <div class="activity-time">
                                    <i class="far fa-clock"></i> 2 hours ago
                                </div>
                                <div class="activity-actions">
                                    <button class="btn btn-sm">View</button>
                                    <button class="btn btn-sm btn-outline">Moderate</button>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="activity-item">
                        <div class="activity-icon activity-icon-report">
                            <i class="fas fa-flag"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Reported Comment</div>
                            <div class="activity-text">A comment by FootballFan92 was reported for inappropriate
                                content in the "Ticket Exchange" thread.</div>
                            <div class="activity-meta">
                                <div class="activity-time">
                                    <i class="far fa-clock"></i> 5 hours ago
                                </div>
                                <div class="activity-actions">
                                    <button class="btn btn-sm">Review</button>
                                    <button class="btn btn-sm btn-outline">Dismiss</button>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="activity-item">
                        <div class="activity-icon activity-icon-user">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">New Moderator Appointed</div>
                            <div class="activity-text">SoccerFan123 has been promoted to forum moderator for the
                                "Match Discussions" section.</div>
                            <div class="activity-meta">
                                <div class="activity-time">
                                    <i class="far fa-clock"></i> 1 day ago
                                </div>
                                <div class="activity-actions">
                                    <button class="btn btn-sm">View Profile</button>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="activity-item">
                        <div class="activity-icon activity-icon-post">
                            <i class="fas fa-comment-alt"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Popular Thread: "Fan meetups during the tournament"</div>
                            <div class="activity-text">This thread has gained significant traction with over 200
                                replies in the last 48 hours.</div>
                            <div class="activity-meta">
                                <div class="activity-time">
                                    <i class="far fa-clock"></i> 2 days ago
                                </div>
                                <div class="activity-actions">
                                    <button class="btn btn-sm">View</button>
                                    <button class="btn btn-sm btn-outline">Pin</button>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- User Map -->
            <div class="user-map">
                <div class="section-header">
                    <h3 class="section-title">Global User Distribution</h3>
                    <div class="section-actions">
                        <button class="btn btn-outline btn-sm">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </div>

                <div class="map-container">
                    <div class="world-map">
                        <!-- Map markers would be dynamically generated -->
                        <div class="map-marker" style="top: 30%; left: 20%;" data-country="Brazil" data-users="24,532">
                        </div>
                        <div class="map-marker" style="top: 25%; left: 45%;" data-country="Spain" data-users="18,745">
                        </div>
                        <div class="map-marker" style="top: 20%; left: 48%;" data-country="France" data-users="15,890">
                        </div>
                        <div class="map-marker" style="top: 22%; left: 52%;" data-country="Germany" data-users="14,256">
                        </div>
                        <div class="map-marker" style="top: 25%; left: 80%;" data-country="Japan" data-users="12,678">
                        </div>
                        <div class="map-marker" style="top: 40%; left: 75%;" data-country="Australia"
                            data-users="9,345"></div>
                        <div class="map-marker" style="top: 18%; left: 15%;" data-country="USA" data-users="22,456">
                        </div>

                        <div class="map-tooltip" id="map-tooltip">
                            <div class="tooltip-title">Country Name</div>
                            <div class="tooltip-content">
                                <div>Registered Users: <strong>0</strong></div>
                                <div>Active Today: <strong>0</strong></div>
                            </div>
                        </div>

                        <div class="map-legend">
                            <div class="map-legend-title">User Density</div>
                            <div class="map-legend-items">
                                <div class="map-legend-item">
                                    <div class="legend-marker" style="background-color: var(--primary);"></div>
                                    <div class="legend-text">High (10,000+)</div>
                                </div>
                                <div class="map-legend-item">
                                    <div class="legend-marker" style="background-color: var(--warning);"></div>
                                    <div class="legend-text">Medium (5,000-10,000)</div>
                                </div>
                                <div class="map-legend-item">
                                    <div class="legend-marker" style="background-color: var(--info);"></div>
                                    <div class="legend-text">Low (< 5,000)</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Users -->
                <div class="recent-users">
                    <div class="section-header">
                        <h3 class="section-title">Recent Users</h3>
                        <div class="section-actions">
                            <button class="btn">
                                <i class="fas fa-eye"></i> View All
                            </button>
                        </div>
                    </div>

                    <ul class="user-list">
                        <li class="user-item">
                            <div class="user-avatar-sm">
                                <img src="http://127.0.0.1:8000/admin/dashboard" alt="User Avatar">
                            </div>
                            <div class="user-details">
                                <div class="user-name-row">
                                    <div class="user-fullname">John Smith</div>
                                    <div class="user-username">@johnsmith</div>
                                    <div class="user-badge badge-vip">VIP</div>
                                </div>
                                <div class="user-info">
                                    <div class="user-info-item">
                                        <i class="fas fa-envelope"></i> john.smith@example.com
                                    </div>
                                    <div class="user-info-item">
                                        <i class="fas fa-calendar"></i> Joined 2 days ago
                                    </div>
                                </div>
                            </div>
                            <div class="user-actions">
                                <button class="btn btn-sm btn-icon">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-icon">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </li>

                        <li class="user-item">
                            <div class="user-avatar-sm">
                                <img src="https://cdn-icons-png.flaticon.com/128/3177/3177465.png" alt="User Avatar">
                            </div>
                            <div class="user-details">
                                <div class="user-name-row">
                                    <div class="user-fullname">Maria Rodriguez</div>
                                    <div class="user-username">@mariarodriguez</div>
                                    <div class="user-badge badge-moderator">Moderator</div>
                                </div>
                                <div class="user-info">
                                    <div class="user-info-item">
                                        <i class="fas fa-envelope"></i> maria.rodriguez@example.com
                                    </div>
                                    <div class="user-info-item">
                                        <i class="fas fa-calendar"></i> Joined 1 week ago
                                    </div>
                                </div>
                            </div>
                            <div class="user-actions">
                                <button class="btn btn-sm btn-icon">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-icon">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </li>

                        <li class="user-item">
                            <div class="user-avatar-sm">
                                <img src="https://cdn-icons-png.flaticon.com/128/3177/3177465.png" alt="User Avatar">
                            </div>
                            <div class="user-details">
                                <div class="user-name-row">
                                    <div class="user-fullname">David Johnson</div>
                                    <div class="user-username">@davidj</div>
                                </div>
                                <div class="user-info">
                                    <div class="user-info-item">
                                        <i class="fas fa-envelope"></i> david.johnson@example.com
                                    </div>
                                    <div class="user-info-item">
                                        <i class="fas fa-calendar"></i> Joined 2 weeks ago
                                    </div>
                                </div>
                            </div>
                            <div class="user-actions">
                                <button class="btn btn-sm btn-icon">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-icon">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </li>

                        <li class="user-item">
                            <div class="user-avatar-sm">
                                <img src="https://cdn-icons-png.flaticon.com/128/3177/3177465.png" alt="User Avatar">
                            </div>
                            <div class="user-details">
                                <div class="user-name-row">
                                    <div class="user-fullname">Sarah Williams</div>
                                    <div class="user-username">@sarahw</div>
                                    <div class="user-badge badge-admin">Admin</div>
                                </div>
                                <div class="user-info">
                                    <div class="user-info-item">
                                        <i class="fas fa-envelope"></i> sarah.williams@example.com
                                    </div>
                                    <div class="user-info-item">
                                        <i class="fas fa-calendar"></i> Joined 1 month ago
                                    </div>
                                </div>
                            </div>
                            <div class="user-actions">
                                <button class="btn btn-sm btn-icon">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-icon">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Ticket Categories -->
                <div class="ticket-categories">
                    <div class="section-header">
                        <h3 class="section-title">Ticket Categories</h3>
                        <div class="section-actions">
                            <button class="btn btn-outline btn-sm">
                                <i class="fas fa-download"></i> Export
                            </button>
                        </div>
                    </div>

                    <div class="categories-chart-container">
                        <canvas id="categoriesChart"></canvas>
                    </div>
                </div>
            </div>
    </main>
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

            // Map tooltip functionality
            const mapMarkers = document.querySelectorAll('.map-marker');
            const mapTooltip = document.getElementById('map-tooltip');

            mapMarkers.forEach(marker => {
                marker.addEventListener('mouseenter', function() {
                    const country = this.getAttribute('data-country');
                    const users = this.getAttribute('data-users');

                    const tooltipTitle = mapTooltip.querySelector('.tooltip-title');
                    const tooltipContent = mapTooltip.querySelector('.tooltip-content');

                    tooltipTitle.textContent = country;
                    tooltipContent.innerHTML = `
                        <div>Registered Users: <strong>${users}</strong></div>
                        <div>Active Today: <strong>${Math.floor(parseInt(users.replace(/,/g, '')) * 0.15).toLocaleString()}</strong></div>
                    `;

                    const markerRect = this.getBoundingClientRect();
                    const mapContainer = document.querySelector('.map-container')
                        .getBoundingClientRect();

                    mapTooltip.style.top = (markerRect.top - mapContainer.top - 70) + 'px';
                    mapTooltip.style.left = (markerRect.left - mapContainer.left) + 'px';
                    mapTooltip.classList.add('show');
                });

                marker.addEventListener('mouseleave', function() {
                    mapTooltip.classList.remove('show');
                });
            });

            // Ticket Sales Chart
            const ticketSalesCtx = document.getElementById('ticketSalesChart');

            if (ticketSalesCtx) {
                const ticketSalesChart = new Chart(ticketSalesCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        datasets: [{
                                label: 'Category 1',
                                data: [65, 78, 90, 85, 92, 98],
                                borderColor: '#e63946',
                                backgroundColor: 'rgba(230, 57, 70, 0.1)',
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Category 2',
                                data: [45, 58, 70, 75, 82, 88],
                                borderColor: '#3498db',
                                backgroundColor: 'rgba(52, 152, 219, 0.1)',
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Category 3',
                                data: [30, 42, 55, 60, 68, 75],
                                borderColor: '#2ecc71',
                                backgroundColor: 'rgba(46, 204, 113, 0.1)',
                                tension: 0.4,
                                fill: true
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100,
                                ticks: {
                                    callback: function(value) {
                                        return value + '%';
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Categories Chart
            const categoriesCtx = document.getElementById('categoriesChart');

            if (categoriesCtx) {
                const categoriesChart = new Chart(categoriesCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Category 1', 'Category 2', 'Category 3', 'VIP', 'Hospitality'],
                        datasets: [{
                            data: [35, 25, 20, 15, 5],
                            backgroundColor: [
                                '#e63946',
                                '#3498db',
                                '#2ecc71',
                                '#f1c40f',
                                '#9b59b6'
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right'
                            }
                        },
                        cutout: '70%'
                    }
                });
            }
        });
    </script>
@endsection
