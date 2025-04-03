@extends('admin.layout')

@section('title', 'Analytics - World Cup 2030')
@section('css')
    <style>
        /* Main Content */
        .admin-main {
            grid-area: main;
            padding: 30px;
            overflow-y: auto;
        }

        /* Analytics Dashboard */
        .analytics-dashboard {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        /* Analytics controls */
        .analytics-controls {
            grid-column: span 12;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .control-group {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .control-select {
            padding: 10px 15px;
            border: 1px solid var(--gray-300);
            border-radius: var(--border-radius);
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            min-width: 150px;
            color: var(--gray-700);
            background-color: white;
            transition: var(--transition);
        }

        .control-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.1);
        }

        .control-label {
            font-weight: 500;
            color: var(--gray-700);
            font-size: 0.9rem;
        }

        .date-range {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .date-input {
            padding: 10px 15px;
            border: 1px solid var(--gray-300);
            border-radius: var(--border-radius);
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            color: var(--gray-700);
            transition: var(--transition);
        }

        .date-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.1);
        }

        .analytics-actions {
            display: flex;
            gap: 10px;
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

        /* KPI Cards */
        .kpi-cards {
            grid-column: span 12;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .kpi-card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 20px;
            display: flex;
            flex-direction: column;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .kpi-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .kpi-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
            position: relative;
            z-index: 1;
        }

        .kpi-title {
            font-size: 0.9rem;
            color: var(--gray-600);
            font-weight: 500;
        }

        .kpi-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: var(--primary);
            flex-shrink: 0;
        }

        .kpi-content {
            position: relative;
            z-index: 1;
        }

        .kpi-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--gray-800);
        }

        .kpi-trend {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .trend-up {
            color: var(--success);
        }

        .trend-down {
            color: var(--danger);
        }

        .trend-neutral {
            color: var(--gray-600);
        }

        .trend-icon {
            margin-right: 5px;
        }

        .kpi-bg {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 4rem;
            opacity: 0.05;
            color: var(--gray-800);
        }

        /* Chart Cards */
        .chart-card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .card-header {
            padding: 20px;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .card-actions {
            display: flex;
            gap: 10px;
        }

        .card-action {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-600);
            cursor: pointer;
            transition: var(--transition);
        }

        .card-action:hover {
            background-color: var(--gray-200);
            color: var(--gray-800);
        }

        .chart-container {
            padding: 20px;
            height: 300px;
            position: relative;
        }

        .chart-legend {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.9rem;
            color: var(--gray-600);
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 2px;
        }

        .chart-tabs {
            display: flex;
            border-bottom: 1px solid var(--gray-200);
        }

        .chart-tab {
            padding: 10px 20px;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--gray-600);
            cursor: pointer;
            transition: var(--transition);
            border-bottom: 2px solid transparent;
        }

        .chart-tab:hover {
            color: var(--gray-800);
        }

        .chart-tab.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
        }

        /* Table Card */
        .table-card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .table-container {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th,
        .data-table td {
            padding: 12px 15px;
            text-align: left;
        }

        .data-table thead th {
            background-color: var(--gray-100);
            font-weight: 600;
            color: var(--gray-700);
            border-bottom: 1px solid var(--gray-200);
            position: sticky;
            top: 0;
        }

        .data-table tbody tr {
            border-bottom: 1px solid var(--gray-200);
            transition: var(--transition);
        }

        .data-table tbody tr:last-child {
            border-bottom: none;
        }

        .data-table tbody tr:hover {
            background-color: var(--gray-100);
        }

        .data-table td {
            color: var(--gray-700);
            font-size: 0.9rem;
        }

        .sortable {
            cursor: pointer;
            user-select: none;
            position: relative;
        }

        .sortable::after {
            content: '↕';
            position: absolute;
            right: 5px;
            color: var(--gray-500);
            font-size: 0.8rem;
        }

        .sorted-asc::after {
            content: '↑';
            color: var(--primary);
        }

        .sorted-desc::after {
            content: '↓';
            color: var(--primary);
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-high {
            background-color: var(--success-light);
            color: var(--success);
        }

        .status-medium {
            background-color: var(--warning-light);
            color: var(--warning);
        }

        .status-low {
            background-color: var(--danger-light);
            color: var(--danger);
        }

        .ticket-trend {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .sparkline {
            width: 80px;
            height: 30px;
        }

        .trend-value {
            font-weight: 600;
        }

        .trend-value.positive {
            color: var(--success);
        }

        .trend-value.negative {
            color: var(--danger);
        }

        /* Heatmap */
        .heatmap-container {
            height: 300px;
            overflow: hidden;
        }

        .heatmap-legend {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-top: 10px;
            padding: 0 20px 20px;
        }

        .heatmap-gradient {
            width: 200px;
            height: 12px;
            background: linear-gradient(to right, #ebedf0, #c6e48b, #7bc96f, #239a3b, #196127);
            border-radius: 2px;
            margin: 0 10px;
        }

        .heatmap-labels {
            display: flex;
            justify-content: space-between;
            width: 200px;
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        /* World Map */
        .map-container {
            height: 450px;
            position: relative;
        }

        .world-map {
            width: 100%;
            height: 100%;
            background-color: var(--gray-100);
            background-image: url('https://via.placeholder.com/1000x500?text=World+Map');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
        }

        .map-marker {
            position: absolute;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background-color: var(--primary);
            transform: translate(-50%, -50%);
            cursor: pointer;
            box-shadow: 0 0 0 2px white;
        }

        .map-legend {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: var(--border-radius);
            padding: 10px;
            box-shadow: var(--shadow);
        }

        .map-legend-title {
            font-weight: 600;
            margin-bottom: 5px;
            font-size: 0.9rem;
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
            font-size: 0.8rem;
        }

        .map-legend-color {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        /* Funnel Chart */
        .funnel-container {
            padding: 20px;
        }

        /* Ticket Distribution */
        .ticket-distribution {
            display: flex;
            flex-direction: column;
            gap: 15px;
            padding: 0 20px 20px;
        }

        .distribution-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .distribution-label {
            width: 120px;
            font-size: 0.9rem;
            color: var(--gray-700);
        }

        .distribution-bar {
            flex: 1;
            height: 20px;
            background-color: var(--gray-200);
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .distribution-fill {
            height: 100%;
            background-color: var(--primary);
            border-radius: 10px;
        }

        .distribution-value {
            position: absolute;
            top: 0;
            right: 10px;
            height: 100%;
            display: flex;
            align-items: center;
            font-size: 0.8rem;
            font-weight: 600;
            color: white;
        }

        /* Device Chart */
        .devices-container {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            height: 300px;
        }

        .device-item {
            text-align: center;
            padding: 15px;
        }

        .device-icon {
            font-size: 2rem;
            margin-bottom: 10px;
            color: var(--gray-700);
        }

        .device-value {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .device-label {
            font-size: 0.9rem;
            color: var(--gray-600);
        }

        /* Forum Activity Heatmap */
        .activity-heatmap {
            padding: 20px;
        }

        /* Ticket Sales by City */
        .sales-by-city {
            padding: 20px;
        }

        .city-sales-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .city-sales-item {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .city-flag {
            width: 30px;
            height: 20px;
            border-radius: 3px;
            background-size: cover;
            background-position: center;
            box-shadow: var(--shadow-sm);
        }

        .city-info {
            flex: 1;
        }

        .city-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--gray-800);
        }

        .city-venue {
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        .city-sales {
            font-weight: 700;
            font-size: 1rem;
        }

        /* Revenue Breakdown */
        .revenue-breakdown {
            padding: 20px;
        }

        /* Revenue Timeline */
        .revenue-timeline {
            padding: 20px;
            height: 300px;
        }

        /* Responsive Styles */
        @media (max-width: 1400px) {
            .analytics-dashboard {
                grid-template-columns: repeat(6, 1fr);
            }

            .analytics-controls,
            .kpi-cards {
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

            .analytics-dashboard {
                grid-template-columns: repeat(3, 1fr);
            }

            .analytics-controls,
            .kpi-cards {
                grid-column: span 3;
            }
        }

        @media (max-width: 768px) {
            .analytics-dashboard {
                grid-template-columns: 1fr;
            }

            .analytics-controls,
            .kpi-cards {
                grid-column: span 1;
            }

            .analytics-controls {
                flex-direction: column;
                align-items: flex-start;
            }

            .kpi-cards {
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
        <!-- Analytics Dashboard -->
        <div class="analytics-dashboard">
            <!-- Analytics Controls -->
            <div class="analytics-controls">
                <div class="control-group">
                    <label class="control-label">Time Period:</label>
                    <select class="control-select">
                        <option value="7days">Last 7 days</option>
                        <option value="30days" selected>Last 30 days</option>
                        <option value="90days">Last 90 days</option>
                        <option value="6months">Last 6 months</option>
                        <option value="1year">Last year</option>
                        <option value="custom">Custom range</option>
                    </select>

                    <div class="date-range">
                        <input type="date" class="date-input" value="2030-01-01">
                        <span>to</span>
                        <input type="date" class="date-input" value="2030-01-31">
                    </div>
                </div>

                <div class="analytics-actions">
                    <button class="btn btn-outline">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <button class="btn">
                        <i class="fas fa-sync-alt"></i> Update
                    </button>
                    <button class="btn btn-secondary">
                        <i class="fas fa-download"></i> Export Data
                    </button>
                </div>
            </div>

            <!-- KPI Cards -->
            <div class="kpi-cards">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-title">Total Revenue</div>
                        <div class="kpi-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                    <div class="kpi-content">
                        <div class="kpi-value">$24.5M</div>
                        <div class="kpi-trend trend-up">
                            <i class="fas fa-arrow-up trend-icon"></i> 12.3% vs last month
                        </div>
                    </div>
                    <i class="fas fa-dollar-sign kpi-bg"></i>
                </div>

                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-title">Tickets Sold</div>
                        <div class="kpi-icon">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                    </div>
                    <div class="kpi-content">
                        <div class="kpi-value">1.3M</div>
                        <div class="kpi-trend trend-up">
                            <i class="fas fa-arrow-up trend-icon"></i> 8.7% vs last month
                        </div>
                    </div>
                    <i class="fas fa-ticket-alt kpi-bg"></i>
                </div>

                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-title">New Users</div>
                        <div class="kpi-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                    </div>
                    <div class="kpi-content">
                        <div class="kpi-value">32.4K</div>
                        <div class="kpi-trend trend-up">
                            <i class="fas fa-arrow-up trend-icon"></i> 18.2% vs last month
                        </div>
                    </div>
                    <i class="fas fa-user-plus kpi-bg"></i>
                </div>

                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-title">Forum Posts</div>
                        <div class="kpi-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                    </div>
                    <div class="kpi-content">
                        <div class="kpi-value">15.2K</div>
                        <div class="kpi-trend trend-down">
                            <i class="fas fa-arrow-down trend-icon"></i> 3.5% vs last month
                        </div>
                    </div>
                    <i class="fas fa-comments kpi-bg"></i>
                </div>

                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-title">Avg. Ticket Price</div>
                        <div class="kpi-icon">
                            <i class="fas fa-tags"></i>
                        </div>
                    </div>
                    <div class="kpi-content">
                        <div class="kpi-value">$120</div>
                        <div class="kpi-trend trend-up">
                            <i class="fas fa-arrow-up trend-icon"></i> 5.2% vs last month
                        </div>
                    </div>
                    <i class="fas fa-tags kpi-bg"></i>
                </div>
            </div>

            <!-- Ticket Sales Chart (Large) -->
            <div class="chart-card" style="grid-column: span 8;">
                <div class="card-header">
                    <h3 class="card-title">Ticket Sales Trends</h3>
                    <div class="card-actions">
                        <div class="card-action">
                            <i class="fas fa-ellipsis-v"></i>
                        </div>
                    </div>
                </div>

                <div class="chart-tabs">
                    <div class="chart-tab active">Daily</div>
                    <div class="chart-tab">Weekly</div>
                    <div class="chart-tab">Monthly</div>
                </div>

                <div class="chart-container">
                    <canvas id="ticketSalesChart"></canvas>
                </div>

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
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: var(--accent);"></div>
                        <span>VIP</span>
                    </div>
                </div>
            </div>

            <!-- User Engagement -->
            <div class="chart-card" style="grid-column: span 4;">
                <div class="card-header">
                    <h3 class="card-title">User Engagement</h3>
                    <div class="card-actions">
                        <div class="card-action">
                            <i class="fas fa-ellipsis-v"></i>
                        </div>
                    </div>
                </div>

                <div class="chart-container">
                    <canvas id="engagementChart"></canvas>
                </div>
            </div>

            <!-- Top Selling Matches -->
            <div class="table-card" style="grid-column: span 6;">
                <div class="card-header">
                    <h3 class="card-title">Top Selling Matches</h3>
                    <div class="card-actions">
                        <div class="card-action">
                            <i class="fas fa-ellipsis-v"></i>
                        </div>
                    </div>
                </div>

                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="sortable sorted-desc">Match</th>
                                <th class="sortable">Date</th>
                                <th class="sortable">Venue</th>
                                <th class="sortable">Tickets Sold</th>
                                <th class="sortable">Sales Rate</th>
                                <th>Trend</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Brazil vs Germany</td>
                                <td>June 12, 2030</td>
                                <td>Rio Stadium</td>
                                <td>78,450</td>
                                <td><span class="status-badge status-high">98%</span></td>
                                <td class="ticket-trend">
                                    <div class="sparkline">
                                        <canvas class="sparkline-canvas" data-values="65,68,72,75,82,90,98"></canvas>
                                    </div>
                                    <div class="trend-value positive">+5%</div>
                                </td>
                            </tr>
                            <tr>
                                <td>Spain vs Portugal</td>
                                <td>June 13, 2030</td>
                                <td>Madrid Stadium</td>
                                <td>65,280</td>
                                <td><span class="status-badge status-high">92%</span></td>
                                <td class="ticket-trend">
                                    <div class="sparkline">
                                        <canvas class="sparkline-canvas" data-values="50,57,63,70,78,85,92"></canvas>
                                    </div>
                                    <div class="trend-value positive">+7%</div>
                                </td>
                            </tr>
                            <tr>
                                <td>France vs Netherlands</td>
                                <td>June 13, 2030</td>
                                <td>Paris Stadium</td>
                                <td>62,130</td>
                                <td><span class="status-badge status-high">88%</span></td>
                                <td class="ticket-trend">
                                    <div class="sparkline">
                                        <canvas class="sparkline-canvas" data-values="45,52,60,68,75,82,88"></canvas>
                                    </div>
                                    <div class="trend-value positive">+6%</div>
                                </td>
                            </tr>
                            <tr>
                                <td>Argentina vs England</td>
                                <td>June 14, 2030</td>
                                <td>Buenos Aires Stadium</td>
                                <td>58,790</td>
                                <td><span class="status-badge status-medium">82%</span></td>
                                <td class="ticket-trend">
                                    <div class="sparkline">
                                        <canvas class="sparkline-canvas" data-values="35,42,50,58,65,75,82"></canvas>
                                    </div>
                                    <div class="trend-value positive">+7%</div>
                                </td>
                            </tr>
                            <tr>
                                <td>Italy vs Belgium</td>
                                <td>June 15, 2030</td>
                                <td>Rome Stadium</td>
                                <td>52,400</td>
                                <td><span class="status-badge status-medium">75%</span></td>
                                <td class="ticket-trend">
                                    <div class="sparkline">
                                        <canvas class="sparkline-canvas" data-values="30,40,52,60,65,72,75"></canvas>
                                    </div>
                                    <div class="trend-value positive">+5%</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- User Activity Heatmap -->
            <div class="chart-card" style="grid-column: span 6;">
                <div class="card-header">
                    <h3 class="card-title">User Activity Heatmap</h3>
                    <div class="card-actions">
                        <div class="card-action">
                            <i class="fas fa-ellipsis-v"></i>
                        </div>
                    </div>
                </div>

                <div class="heatmap-container">
                    <div id="activityHeatmap"></div>
                </div>

                <div class="heatmap-legend">
                    <span>Less</span>
                    <div class="heatmap-gradient"></div>
                    <span>More</span>
                </div>
            </div>

            <!-- Forum Activity by Category -->
            <div class="chart-card" style="grid-column: span 6;">
                <div class="card-header">
                    <h3 class="card-title">Forum Activity by Category</h3>
                    <div class="card-actions">
                        <div class="card-action">
                            <i class="fas fa-ellipsis-v"></i>
                        </div>
                    </div>
                </div>

                <div class="chart-container">
                    <canvas id="forumActivityChart"></canvas>
                </div>
            </div>

            <!-- Device Distribution -->
            <div class="chart-card" style="grid-column: span 6;">
                <div class="card-header">
                    <h3 class="card-title">User Device Distribution</h3>
                    <div class="card-actions">
                        <div class="card-action">
                            <i class="fas fa-ellipsis-v"></i>
                        </div>
                    </div>
                </div>

                <div class="devices-container">
                    <div class="device-item">
                        <div class="device-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="device-value">68%</div>
                        <div class="device-label">Mobile</div>
                    </div>

                    <div class="device-item">
                        <div class="device-icon">
                            <i class="fas fa-tablet-alt"></i>
                        </div>
                        <div class="device-value">12%</div>
                        <div class="device-label">Tablet</div>
                    </div>

                    <div class="device-item">
                        <div class="device-icon">
                            <i class="fas fa-laptop"></i>
                        </div>
                        <div class="device-value">20%</div>
                        <div class="device-label">Desktop</div>
                    </div>
                </div>
            </div>

            <!-- Global User Distribution -->
            <div class="chart-card" style="grid-column: span 12;">
                <div class="card-header">
                    <h3 class="card-title">Global User Distribution</h3>
                    <div class="card-actions">
                        <div class="card-action">
                            <i class="fas fa-ellipsis-v"></i>
                        </div>
                    </div>
                </div>

                <div class="map-container">
                    <div class="world-map">
                        <!-- These would be dynamically generated -->
                        <div class="map-marker" style="top: 30%; left: 20%;" data-country="Brazil"></div>
                        <div class="map-marker" style="top: 25%; left: 45%;" data-country="Spain"></div>
                        <div class="map-marker" style="top: 20%; left: 48%;" data-country="France"></div>
                        <div class="map-marker" style="top: 22%; left: 52%;" data-country="Germany"></div>
                        <div class="map-marker" style="top: 25%; left: 80%;" data-country="Japan"></div>
                        <div class="map-marker" style="top: 40%; left: 75%;" data-country="Australia"></div>
                        <div class="map-marker" style="top: 18%; left: 15%;" data-country="USA"></div>

                        <div class="map-legend">
                            <div class="map-legend-title">User Distribution</div>
                            <div class="map-legend-items">
                                <div class="map-legend-item">
                                    <div class="map-legend-color" style="background-color: var(--primary);"></div>
                                    <span>50,000+ users</span>
                                </div>
                                <div class="map-legend-item">
                                    <div class="map-legend-color" style="background-color: var(--info);"></div>
                                    <span>10,000-50,000 users</span>
                                </div>
                                <div class="map-legend-item">
                                    <div class="map-legend-color" style="background-color: var(--gray-500);"></div>
                                    <span>
                                        < 10,000 users</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ticket Sales by City -->
            <div class="chart-card" style="grid-column: span 6;">
                <div class="card-header">
                    <h3 class="card-title">Ticket Sales by Host City</h3>
                    <div class="card-actions">
                        <div class="card-action">
                            <i class="fas fa-ellipsis-v"></i>
                        </div>
                    </div>
                </div>

                <div class="sales-by-city">
                    <div class="city-sales-list">
                        <div class="city-sales-item">
                            <div class="city-flag"
                                style="background-image: url('https://via.placeholder.com/30x20/3498db/ffffff?text=BRA')">
                            </div>
                            <div class="city-info">
                                <div class="city-name">Rio de Janeiro</div>
                                <div class="city-venue">Rio Stadium</div>
                            </div>
                            <div class="city-sales">182,450</div>
                        </div>

                        <div class="city-sales-item">
                            <div class="city-flag"
                                style="background-image: url('https://via.placeholder.com/30x20/f39c12/ffffff?text=ESP')">
                            </div>
                            <div class="city-info">
                                <div class="city-name">Madrid</div>
                                <div class="city-venue">Madrid Stadium</div>
                            </div>
                            <div class="city-sales">156,280</div>
                        </div>

                        <div class="city-sales-item">
                            <div class="city-flag"
                                style="background-image: url('https://via.placeholder.com/30x20/9b59b6/ffffff?text=FRA')">
                            </div>
                            <div class="city-info">
                                <div class="city-name">Paris</div>
                                <div class="city-venue">Paris Stadium</div>
                            </div>
                            <div class="city-sales">142,130</div>
                        </div>

                        <div class="city-sales-item">
                            <div class="city-flag"
                                style="background-image: url('https://via.placeholder.com/30x20/1abc9c/ffffff?text=ARG')">
                            </div>
                            <div class="city-info">
                                <div class="city-name">Buenos Aires</div>
                                <div class="city-venue">Buenos Aires Stadium</div>
                            </div>
                            <div class="city-sales">138,790</div>
                        </div>

                        <div class="city-sales-item">
                            <div class="city-flag"
                                style="background-image: url('https://via.placeholder.com/30x20/3498db/ffffff?text=ITA')">
                            </div>
                            <div class="city-info">
                                <div class="city-name">Rome</div>
                                <div class="city-venue">Rome Stadium</div>
                            </div>
                            <div class="city-sales">132,400</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Breakdown -->
            <div class="chart-card" style="grid-column: span 6;">
                <div class="card-header">
                    <h3 class="card-title">Revenue Breakdown</h3>
                    <div class="card-actions">
                        <div class="card-action">
                            <i class="fas fa-ellipsis-v"></i>
                        </div>
                    </div>
                </div>

                <div class="revenue-breakdown">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Conversion Funnel -->
            <div class="chart-card" style="grid-column: span 4;">
                <div class="card-header">
                    <h3 class="card-title">Ticket Purchase Funnel</h3>
                    <div class="card-actions">
                        <div class="card-action">
                            <i class="fas fa-ellipsis-v"></i>
                        </div>
                    </div>
                </div>

                <div class="funnel-container">
                    <div id="conversionFunnel"></div>
                </div>
            </div>

            <!-- Ticket Distribution -->
            <div class="chart-card" style="grid-column: span 4;">
                <div class="card-header">
                    <h3 class="card-title">Ticket Category Distribution</h3>
                    <div class="card-actions">
                        <div class="card-action">
                            <i class="fas fa-ellipsis-v"></i>
                        </div>
                    </div>
                </div>

                <div class="ticket-distribution">
                    <div class="distribution-item">
                        <div class="distribution-label">Category 1</div>
                        <div class="distribution-bar">
                            <div class="distribution-fill" style="width: 85%;"></div>
                            <div class="distribution-value">85%</div>
                        </div>
                    </div>

                    <div class="distribution-item">
                        <div class="distribution-label">Category 2</div>
                        <div class="distribution-bar">
                            <div class="distribution-fill" style="width: 72%; background-color: var(--info);"></div>
                            <div class="distribution-value">72%</div>
                        </div>
                    </div>

                    <div class="distribution-item">
                        <div class="distribution-label">Category 3</div>
                        <div class="distribution-bar">
                            <div class="distribution-fill" style="width: 64%; background-color: var(--success);"></div>
                            <div class="distribution-value">64%</div>
                        </div>
                    </div>

                    <div class="distribution-item">
                        <div class="distribution-label">VIP</div>
                        <div class="distribution-bar">
                            <div class="distribution-fill" style="width: 95%; background-color: var(--accent-dark);">
                            </div>
                            <div class="distribution-value">95%</div>
                        </div>
                    </div>

                    <div class="distribution-item">
                        <div class="distribution-label">Hospitality</div>
                        <div class="distribution-bar">
                            <div class="distribution-fill" style="width: 88%; background-color: var(--secondary);">
                            </div>
                            <div class="distribution-value">88%</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Timeline -->
            <div class="chart-card" style="grid-column: span 4;">
                <div class="card-header">
                    <h3 class="card-title">Revenue Timeline</h3>
                    <div class="card-actions">
                        <div class="card-action">
                            <i class="fas fa-ellipsis-v"></i>
                        </div>
                    </div>
                </div>

                <div class="revenue-timeline">
                    <canvas id="revenueTimelineChart"></canvas>
                </div>
            </div>

            <!-- Forum Activity Heatmap -->
            <div class="chart-card" style="grid-column: span 6;">
                <div class="card-header">
                    <h3 class="card-title">Forum Activity by Time of Day</h3>
                    <div class="card-actions">
                        <div class="card-action">
                            <i class="fas fa-ellipsis-v"></i>
                        </div>
                    </div>
                </div>

                <div class="activity-heatmap">
                    <div id="forumActivityHeatmap"></div>
                </div>
            </div>

            <!-- User Retention -->
            <div class="chart-card" style="grid-column: span 6;">
                <div class="card-header">
                    <h3 class="card-title">User Retention</h3>
                    <div class="card-actions">
                        <div class="card-action">
                            <i class="fas fa-ellipsis-v"></i>
                        </div>
                    </div>
                </div>

                <div class="chart-container">
                    <canvas id="retentionChart"></canvas>
                </div>
            </div>
        </div>
    </main>
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

            // Ticket Sales Trend Chart
            const ticketSalesCtx = document.getElementById('ticketSalesChart');
            if (ticketSalesCtx) {
                const ticketSalesChart = new Chart(ticketSalesCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan 1', 'Jan 5', 'Jan 10', 'Jan 15', 'Jan 20', 'Jan 25', 'Jan 30'],
                        datasets: [{
                                label: 'Category 1',
                                data: [1200, 1900, 3000, 5000, 8000, 12000, 15000],
                                borderColor: '#e63946',
                                backgroundColor: 'rgba(230, 57, 70, 0.1)',
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Category 2',
                                data: [800, 1200, 2000, 3500, 5500, 9000, 12000],
                                borderColor: '#3498db',
                                backgroundColor: 'rgba(52, 152, 219, 0.1)',
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Category 3',
                                data: [500, 800, 1500, 2500, 4000, 6500, 9000],
                                borderColor: '#2ecc71',
                                backgroundColor: 'rgba(46, 204, 113, 0.1)',
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'VIP',
                                data: [200, 350, 500, 850, 1200, 1800, 2500],
                                borderColor: '#f1c40f',
                                backgroundColor: 'rgba(241, 196, 15, 0.1)',
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
                                    text: 'Number of Tickets'
                                }
                            }
                        }
                    }
                });
            }

            // User Engagement Chart
            const engagementCtx = document.getElementById('engagementChart');
            if (engagementCtx) {
                const engagementChart = new Chart(engagementCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Active Users', 'Occasional Users', 'Inactive Users'],
                        datasets: [{
                            data: [65, 25, 10],
                            backgroundColor: [
                                '#2ecc71',
                                '#f1c40f',
                                '#e74c3c'
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        },
                        cutout: '70%'
                    }
                });
            }

            // Forum Activity Chart
            const forumActivityCtx = document.getElementById('forumActivityChart');
            if (forumActivityCtx) {
                const forumActivityChart = new Chart(forumActivityCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Match Discussions', 'Tickets & Travel', 'Fan Zone', 'Announcements',
                            'Help & Support', 'Off-Topic'
                        ],
                        datasets: [{
                            label: 'Posts',
                            data: [4500, 3200, 2800, 1500, 1200, 800],
                            backgroundColor: [
                                '#e63946',
                                '#3498db',
                                '#2ecc71',
                                '#f1c40f',
                                '#9b59b6',
                                '#1abc9c'
                            ],
                            borderWidth: 0
                        }]
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
                                title: {
                                    display: true,
                                    text: 'Number of Posts'
                                }
                            }
                        }
                    }
                });
            }

            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart');
            if (revenueCtx) {
                const revenueChart = new Chart(revenueCtx, {
                    type: 'pie',
                    data: {
                        labels: ['Ticket Sales', 'Merchandise', 'Food & Beverage', 'Sponsorships',
                            'Broadcasting Rights'
                        ],
                        datasets: [{
                            data: [60, 15, 10, 10, 5],
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
                        }
                    }
                });
            }

            // Revenue Timeline Chart
            const revenueTimelineCtx = document.getElementById('revenueTimelineChart');
            if (revenueTimelineCtx) {
                const revenueTimelineChart = new Chart(revenueTimelineCtx, {
                    type: 'line',
                    data: {
                        labels: ['6 months ago', '5 months ago', '4 months ago', '3 months ago',
                            '2 months ago', '1 month ago', 'Current'
                        ],
                        datasets: [{
                            label: 'Revenue (millions)',
                            data: [2.5, 3.8, 5.2, 8.5, 12.4, 18.6, 24.5],
                            borderColor: '#e63946',
                            backgroundColor: 'rgba(230, 57, 70, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
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
                                title: {
                                    display: true,
                                    text: 'Revenue ($ millions)'
                                }
                            }
                        }
                    }
                });
            }

            // User Retention Chart
            const retentionCtx = document.getElementById('retentionChart');
            if (retentionCtx) {
                const retentionChart = new Chart(retentionCtx, {
                    type: 'bar',
                    data: {
                        labels: ['1 Day', '7 Days', '14 Days', '30 Days', '60 Days', '90 Days'],
                        datasets: [{
                            label: 'Retention Rate',
                            data: [100, 85, 75, 68, 62, 58],
                            backgroundColor: '#3498db',
                            borderWidth: 0
                        }]
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
                                title: {
                                    display: true,
                                    text: 'Retention Rate (%)'
                                }
                            }
                        }
                    }
                });
            }

            // Initialize ApexCharts for heatmaps and funnel charts
            if (typeof ApexCharts !== 'undefined') {
                // Activity Heatmap
                const activityHeatmapOptions = {
                    series: [{
                        name: 'Activity',
                        data: generateHeatmapData()
                    }],
                    chart: {
                        height: 250,
                        type: 'heatmap',
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        heatmap: {
                            shadeIntensity: 0.5,
                            colorScale: {
                                ranges: [{
                                    from: 0,
                                    to: 10,
                                    name: 'low',
                                    color: '#eff2f7'
                                }, {
                                    from: 11,
                                    to: 20,
                                    name: 'medium',
                                    color: '#a8d5ba'
                                }, {
                                    from: 21,
                                    to: 30,
                                    name: 'high',
                                    color: '#57bb8a'
                                }, {
                                    from: 31,
                                    to: 40,
                                    name: 'very high',
                                    color: '#2ecc71'
                                }]
                            }
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                    },
                    yaxis: {
                        categories: ['12am', '4am', '8am', '12pm', '4pm', '8pm']
                    },
                    title: {
                        text: 'User Activity by Time of Day and Day of Week',
                        align: 'center',
                        style: {
                            fontSize: '14px'
                        }
                    }
                };

                if (document.getElementById('activityHeatmap')) {
                    const activityHeatmap = new ApexCharts(document.getElementById('activityHeatmap'),
                        activityHeatmapOptions);
                    activityHeatmap.render();
                }

                // Forum Activity Heatmap
                const forumHeatmapOptions = {
                    series: [{
                        name: 'Posts',
                        data: generateHeatmapData()
                    }],
                    chart: {
                        height: 250,
                        type: 'heatmap',
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        heatmap: {
                            shadeIntensity: 0.5,
                            colorScale: {
                                ranges: [{
                                    from: 0,
                                    to: 10,
                                    name: 'low',
                                    color: '#f8d7da'
                                }, {
                                    from: 11,
                                    to: 20,
                                    name: 'medium',
                                    color: '#f5c6cb'
                                }, {
                                    from: 21,
                                    to: 30,
                                    name: 'high',
                                    color: '#f1aeb5'
                                }, {
                                    from: 31,
                                    to: 40,
                                    name: 'very high',
                                    color: '#e63946'
                                }]
                            }
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                    },
                    yaxis: {
                        categories: ['12am', '4am', '8am', '12pm', '4pm', '8pm']
                    },
                    title: {
                        text: 'Forum Posts by Time of Day and Day of Week',
                        align: 'center',
                        style: {
                            fontSize: '14px'
                        }
                    }
                };

                if (document.getElementById('forumActivityHeatmap')) {
                    const forumHeatmap = new ApexCharts(document.getElementById('forumActivityHeatmap'),
                        forumHeatmapOptions);
                    forumHeatmap.render();
                }

                // Conversion Funnel
                const funnelOptions = {
                    series: [{
                        name: "Users",
                        data: [100000, 68000, 45000, 32000, 24500]
                    }],
                    chart: {
                        type: 'bar',
                        height: 350,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            dataLabels: {
                                position: 'top'
                            }
                        }
                    },
                    colors: ['#e63946'],
                    dataLabels: {
                        enabled: true,
                        formatter: function(val) {
                            return val.toLocaleString();
                        },
                        offsetX: 30,
                        style: {
                            fontSize: '12px',
                            colors: ['#fff']
                        }
                    },
                    stroke: {
                        width: 1,
                        colors: ['#fff']
                    },
                    xaxis: {
                        categories: ['Visited Site', 'Browsed Matches', 'Added to Cart', 'Started Checkout',
                            'Completed Purchase'
                        ],
                    },
                    yaxis: {
                        labels: {
                            show: true
                        }
                    }
                };

                if (document.getElementById('conversionFunnel')) {
                    const conversionFunnel = new ApexCharts(document.getElementById('conversionFunnel'),
                        funnelOptions);
                    conversionFunnel.render();
                }
            }

            // Draw sparklines
            const sparklineCanvases = document.querySelectorAll('.sparkline-canvas');
            sparklineCanvases.forEach(canvas => {
                const values = canvas.getAttribute('data-values').split(',').map(Number);
                const ctx = canvas.getContext('2d');
                drawSparkline(ctx, values, canvas.width, canvas.height);
            });

            // Helper function to generate random heatmap data
            function generateHeatmapData() {
                const data = [];
                for (let i = 0; i < 6; i++) {
                    for (let j = 0; j < 7; j++) {
                        const value = Math.floor(Math.random() * 40);
                        data.push({
                            x: j,
                            y: i,
                            value: value
                        });
                    }
                }
                return data;
            }

            // Helper function to draw sparklines
            function drawSparkline(ctx, values, width, height) {
                const max = Math.max(...values);
                const min = Math.min(...values);
                const range = max - min;

                const stepX = width / (values.length - 1);
                const stepY = height / range;

                ctx.clearRect(0, 0, width, height);

                // Draw line
                ctx.beginPath();
                ctx.moveTo(0, height - (values[0] - min) * stepY);

                for (let i = 1; i < values.length; i++) {
                    ctx.lineTo(i * stepX, height - (values[i] - min) * stepY);
                }

                ctx.strokeStyle = '#e63946';
                ctx.lineWidth = 2;
                ctx.stroke();

                // Fill area below the line
                ctx.lineTo(width, height);
                ctx.lineTo(0, height);
                ctx.closePath();

                ctx.fillStyle = 'rgba(230, 57, 70, 0.1)';
                ctx.fill();

                // Draw dots
                ctx.fillStyle = '#e63946';
                for (let i = 0; i < values.length; i++) {
                    ctx.beginPath();
                    ctx.arc(i * stepX, height - (values[i] - min) * stepY, 3, 0, Math.PI * 2);
                    ctx.fill();
                }
            }
        });
    </script>
@endsection
