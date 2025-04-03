@extends('user.layout')

@section('title', 'Matches - World Cup 2030')

@section('css')
    <style>
        /* Filters Section */
        .filters-section {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 40px;
        }

        .filters-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .filters-title h2 {
            font-size: 1.5rem;
        }

        .filters-toggle {
            background: none;
            border: none;
            color: var(--primary);
            font-size: 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .filters-toggle i {
            margin-left: 5px;
            transition: transform 0.3s ease;
        }

        .filters-toggle.collapsed i {
            transform: rotate(180deg);
        }

        .filters-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .filters-content.show {
            max-height: 500px;
        }

        .filters-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--gray-300);
            border-radius: 4px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(230, 57, 70, 0.2);
        }

        .filters-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        /* Search Bar */
        .search-bar {
            display: flex;
            margin-bottom: 30px;
        }

        .search-input {
            flex: 1;
            padding: 12px 20px;
            border: 1px solid var(--gray-300);
            border-right: none;
            border-radius: 4px 0 0 4px;
            font-size: 1rem;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .search-btn {
            padding: 0 20px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            background-color: #d32f2f;
        }

        /* Matches Section */
        .matches-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .matches-count {
            font-size: 1.1rem;
            color: var(--gray-700);
        }

        .matches-count span {
            font-weight: 700;
            color: var(--primary);
        }

        .sort-options {
            display: flex;
            align-items: center;
        }

        .sort-options label {
            margin-right: 10px;
            font-size: 0.9rem;
            color: var(--gray-700);
        }

        .sort-select {
            padding: 8px 12px;
            border: 1px solid var(--gray-300);
            border-radius: 4px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
        }

        .matches-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .match-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
        }

        .match-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .match-stage {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: var(--accent);
            color: var(--dark);
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 1;
        }

        .match-header {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://source.unsplash.com/random/400x200/?stadium') no-repeat center center/cover;
            padding: 20px;
            color: white;
            position: relative;
        }

        .match-date {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .match-day {
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }

        .match-day i {
            margin-right: 5px;
            color: var(--accent);
        }

        .match-time {
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }

        .match-time i {
            margin-right: 5px;
            color: var(--accent);
        }

        .match-venue {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
        }

        .match-venue i {
            margin-right: 5px;
            color: var(--accent);
        }

        .match-teams {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
        }

        .match-team {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 40%;
        }

        .team-flag {
            width: 60px;
            height: 40px;
            margin-bottom: 10px;
            background-size: cover;
            background-position: center;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .team-name {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .team-code {
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        .match-score {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 20%;
        }

        .score-display {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .match-status {
            font-size: 0.8rem;
            padding: 3px 8px;
            border-radius: 20px;
            background-color: var(--gray-200);
            color: var(--gray-700);
        }

        .match-status.upcoming {
            background-color: var(--info);
            color: white;
        }

        .match-status.live {
            background-color: var(--danger);
            color: white;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }

            100% {
                opacity: 1;
            }
        }

        .match-footer {
            padding: 15px 20px;
            border-top: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .match-group {
            font-size: 0.9rem;
            color: var(--gray-600);
        }

        .match-actions {
            display: flex;
            gap: 10px;
        }

        /* Match Details */
        .match-details {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            background-color: var(--gray-100);
            border-top: 1px solid var(--gray-200);
        }

        .match-details.show {
            max-height: 500px;
        }

        .match-details-content {
            padding: 20px;
        }

        .match-details-section {
            margin-bottom: 20px;
        }

        .match-details-section:last-child {
            margin-bottom: 0;
        }

        .match-details-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .match-details-title i {
            margin-right: 8px;
            color: var(--primary);
        }

        .stadium-info {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .stadium-image {
            width: 80px;
            height: 60px;
            border-radius: 4px;
            margin-right: 15px;
            background-size: cover;
            background-position: center;
        }

        .stadium-details h4 {
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .stadium-details p {
            font-size: 0.9rem;
            color: var(--gray-600);
        }

        .referee-info {
            display: flex;
            align-items: center;
        }

        .referee-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 15px;
            background-size: cover;
            background-position: center;
        }

        .referee-details h4 {
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .referee-details p {
            font-size: 0.9rem;
            color: var(--gray-600);
        }

        .ticket-info {
            background-color: white;
            border-radius: 4px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .ticket-categories {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
            margin-bottom: 15px;
        }

        .ticket-category {
            padding: 10px;
            border: 1px solid var(--gray-300);
            border-radius: 4px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .ticket-category:hover {
            border-color: var(--primary);
            background-color: var(--light);
        }

        .ticket-category.selected {
            border-color: var(--primary);
            background-color: var(--light);
        }

        .ticket-category h5 {
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .ticket-price {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary);
        }

        .ticket-availability {
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        .ticket-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .ticket-quantity {
            display: flex;
            align-items: center;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--gray-200);
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .quantity-btn:hover {
            background-color: var(--gray-300);
        }

        .quantity-input {
            width: 40px;
            height: 30px;
            text-align: center;
            border: 1px solid var(--gray-300);
            margin: 0 5px;
            font-size: 0.9rem;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            margin-top: 40px;
            margin-bottom: 60px;
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 4px;
            background-color: white;
            color: var(--gray-700);
            font-weight: 500;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .pagination a:hover {
            background-color: var(--gray-200);
            color: var(--dark);
        }

        .pagination a.active {
            background-color: var(--primary);
            color: white;
        }

        .pagination a.disabled {
            background-color: var(--gray-100);
            color: var(--gray-400);
            cursor: not-allowed;
            pointer-events: none;
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .matches-grid {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .mobile-menu {
                display: block;
            }

            .page-header h1 {
                font-size: 2rem;
            }

            .matches-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .matches-grid {
                grid-template-columns: 1fr;
            }

            .ticket-categories {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 576px) {
            .filters-form {
                grid-template-columns: 1fr;
            }

            .match-teams {
                flex-direction: column;
                gap: 20px;
            }

            .match-team {
                width: 100%;
            }

            .match-score {
                width: 100%;
                margin: 15px 0;
            }

            .score-display {
                font-size: 1.5rem;
            }

            .match-footer {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .match-actions {
                width: 100%;
                justify-content: space-between;
            }

            .ticket-categories {
                grid-template-columns: 1fr;
            }

            .ticket-actions {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }

        /* Add this to fix the match-stage positioning */
        .match-stage {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: var(--accent);
            color: var(--dark);
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 10;
            /* Increase z-index to ensure it's above other elements */
        }

        /* Fix the match-header to ensure proper positioning context */
        .match-header {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://source.unsplash.com/random/400x200/?stadium') no-repeat center center/cover;
            padding: 20px;
            color: white;
            position: relative;
            /* Ensure this is set for absolute positioning of children */
        }

        /* Fix the match details section */
        .match-details {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease;
            /* Increase transition time for smoother animation */
            background-color: var(--gray-100);
            border-top: 1px solid var(--gray-200);
        }

        .match-details.show {
            max-height: 800px;
            /* Increase max-height to ensure content fits */
        }
    </style>
@endsection

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>World Cup 2030 Matches</h1>
            <ul class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">Matches</a></li>
            </ul>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container">
        <!-- Filters Section -->
        <section class="filters-section">
            <div class="filters-title">
                <h2>Filter Matches</h2>
                <button class="filters-toggle">
                    Filter Options <i class="fas fa-chevron-down"></i>
                </button>
            </div>
            <div class="filters-content">
                <form class="filters-form">
                    <div class="form-group">
                        <label for="date-range">Date Range</label>
                        <select class="form-control" id="date-range">
                            <option value="">All Dates</option>
                            <option value="today">Today</option>
                            <option value="tomorrow">Tomorrow</option>
                            <option value="this-week">This Week</option>
                            <option value="next-week">Next Week</option>
                            <option value="this-month">This Month</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="team">Team</label>
                        <select class="form-control" id="team">
                            <option value="">All Teams</option>
                            <option value="brazil">Brazil</option>
                            <option value="france">France</option>
                            <option value="germany">Germany</option>
                            <option value="spain">Spain</option>
                            <option value="argentina">Argentina</option>
                            <option value="england">England</option>
                            <option value="portugal">Portugal</option>
                            <option value="netherlands">Netherlands</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="venue">Venue</label>
                        <select class="form-control" id="venue">
                            <option value="">All Venues</option>
                            <option value="rio-stadium">Rio Stadium</option>
                            <option value="berlin-arena">Berlin Arena</option>
                            <option value="london-stadium">London Stadium</option>
                            <option value="paris-arena">Paris Arena</option>
                            <option value="madrid-stadium">Madrid Stadium</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="stage">Stage</label>
                        <select class="form-control" id="stage">
                            <option value="">All Stages</option>
                            <option value="group">Group Stage</option>
                            <option value="round-16">Round of 16</option>
                            <option value="quarter">Quarter Finals</option>
                            <option value="semi">Semi Finals</option>
                            <option value="final">Final</option>
                        </select>
                    </div>
                </form>
                <div class="filters-actions">
                    <button class="btn btn-outline">Reset</button>
                    <button class="btn">Apply Filters</button>
                </div>
            </div>
        </section>

        <!-- Search Bar -->
        <div class="search-bar">
            <input type="text" class="search-input" placeholder="Search for matches, teams, or venues...">
            <button class="search-btn">
                <i class="fas fa-search"></i>
            </button>
        </div>

        <!-- Matches Section -->
        <section class="matches-section">
            <div class="matches-header">
                <div class="matches-count">
                    Showing <span>48</span> matches
                </div>
                <div class="sort-options">
                    <label for="sort-by">Sort by:</label>
                    <select class="sort-select" id="sort-by">
                        <option value="date-asc">Date (Earliest First)</option>
                        <option value="date-desc">Date (Latest First)</option>
                        <option value="group">Group</option>
                        <option value="stage">Stage</option>
                    </select>
                </div>
            </div>

            <div class="matches-grid">
                <!-- Match Card 1 -->
                <div class="match-card">
                    <div class="match-stage">Group A</div>
                    <div class="match-header">
                        <div class="match-date">
                            <div class="match-day">
                                <i class="far fa-calendar-alt"></i> June 15, 2030
                            </div>
                            <div class="match-time">
                                <i class="far fa-clock"></i> 18:00 GMT
                            </div>
                        </div>
                        <div class="match-venue">
                            <i class="fas fa-map-marker-alt"></i> Rio Stadium, Brazil
                        </div>
                    </div>
                    <div class="match-teams">
                        <div class="match-team">
                            <div class="team-flag"
                                style="background-image: url('https://via.placeholder.com/60x40/3498db/ffffff?text=BRA')">
                            </div>
                            <div class="team-name">Brazil</div>
                            <div class="team-code">BRA</div>
                        </div>
                        <div class="match-score">
                            <div class="score-display">vs</div>
                            <div class="match-status upcoming">Upcoming</div>
                        </div>
                        <div class="match-team">
                            <div class="team-flag"
                                style="background-image: url('https://via.placeholder.com/60x40/e74c3c/ffffff?text=FRA')">
                            </div>
                            <div class="team-name">France</div>
                            <div class="team-code">FRA</div>
                        </div>
                    </div>
                    <div class="match-footer">
                        <div class="match-group">Group A - Match 1</div>
                        <div class="match-actions">
                            <button class="btn btn-sm btn-outline match-details-btn" data-match="1">Details</button>
                            <button class="btn btn-sm">Buy Tickets</button>
                        </div>
                    </div>
                    <div class="match-details" id="match-details-1">
                        <div class="match-details-content">
                            <div class="match-details-section">
                                <div class="match-details-title">
                                    <i class="fas fa-info-circle"></i> Match Information
                                </div>
                                <div class="stadium-info">
                                    <div class="stadium-image"
                                        style="background-image: url('https://source.unsplash.com/random/160x120/?stadium,brazil')">
                                    </div>
                                    <div class="stadium-details">
                                        <h4>Rio Stadium</h4>
                                        <p>Capacity: 75,000 | Rio de Janeiro, Brazil</p>
                                    </div>
                                </div>
                                <div class="referee-info">
                                    <div class="referee-image"
                                        style="background-image: url('https://via.placeholder.com/80x80/cccccc/333333?text=Referee')">
                                    </div>
                                    <div class="referee-details">
                                        <h4>Michael Johnson</h4>
                                        <p>Head Referee | England</p>
                                    </div>
                                </div>
                            </div>
                            <div class="match-details-section">
                                <div class="match-details-title">
                                    <i class="fas fa-ticket-alt"></i> Ticket Information
                                </div>
                                <div class="ticket-info">
                                    <div class="ticket-categories">
                                        <div class="ticket-category">
                                            <h5>Category 1</h5>
                                            <div class="ticket-price">$250</div>
                                            <div class="ticket-availability">Limited</div>
                                        </div>
                                        <div class="ticket-category">
                                            <h5>Category 2</h5>
                                            <div class="ticket-price">$180</div>
                                            <div class="ticket-availability">Available</div>
                                        </div>
                                        <div class="ticket-category">
                                            <h5>Category 3</h5>
                                            <div class="ticket-price">$120</div>
                                            <div class="ticket-availability">Available</div>
                                        </div>
                                    </div>
                                    <div class="ticket-actions">
                                        <div class="ticket-quantity">
                                            <button class="quantity-btn minus">-</button>
                                            <input type="text" class="quantity-input" value="2" min="1"
                                                max="6">
                                            <button class="quantity-btn plus">+</button>
                                        </div>
                                        <button class="btn">Add to Cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Match Card 2 -->
                <div class="match-card">
                    <div class="match-stage">Group B</div>
                    <div class="match-header">
                        <div class="match-date">
                            <div class="match-day">
                                <i class="far fa-calendar-alt"></i> June 16, 2030
                            </div>
                            <div class="match-time">
                                <i class="far fa-clock"></i> 15:00 GMT
                            </div>
                        </div>
                        <div class="match-venue">
                            <i class="fas fa-map-marker-alt"></i> Berlin Arena, Germany
                        </div>
                    </div>
                    <div class="match-teams">
                        <div class="match-team">
                            <div class="team-flag"
                                style="background-image: url('https://via.placeholder.com/60x40/2ecc71/ffffff?text=GER')">
                            </div>
                            <div class="team-name">Germany</div>
                            <div class="team-code">GER</div>
                        </div>
                        <div class="match-score">
                            <div class="score-display">vs</div>
                            <div class="match-status upcoming">Upcoming</div>
                        </div>
                        <div class="match-team">
                            <div class="team-flag"
                                style="background-image: url('https://via.placeholder.com/60x40/f39c12/ffffff?text=ESP')">
                            </div>
                            <div class="team-name">Spain</div>
                            <div class="team-code">ESP</div>
                        </div>
                    </div>
                    <div class="match-footer">
                        <div class="match-group">Group B - Match 1</div>
                        <div class="match-actions">
                            <button class="btn btn-sm btn-outline match-details-btn" data-match="2">Details</button>
                            <button class="btn btn-sm">Buy Tickets</button>
                        </div>
                    </div>
                    <div class="match-details" id="match-details-2">
                        <div class="match-details-content">
                            <div class="match-details-section">
                                <div class="match-details-title">
                                    <i class="fas fa-info-circle"></i> Match Information
                                </div>
                                <div class="stadium-info">
                                    <div class="stadium-image"
                                        style="background-image: url('https://source.unsplash.com/random/160x120/?stadium,germany')">
                                    </div>
                                    <div class="stadium-details">
                                        <h4>Berlin Arena</h4>
                                        <p>Capacity: 70,000 | Berlin, Germany</p>
                                    </div>
                                </div>
                                <div class="referee-info">
                                    <div class="referee-image"
                                        style="background-image: url('https://via.placeholder.com/80x80/cccccc/333333?text=Referee')">
                                    </div>
                                    <div class="referee-details">
                                        <h4>Carlos Rodriguez</h4>
                                        <p>Head Referee | Spain</p>
                                    </div>
                                </div>
                            </div>
                            <div class="match-details-section">
                                <div class="match-details-title">
                                    <i class="fas fa-ticket-alt"></i> Ticket Information
                                </div>
                                <div class="ticket-info">
                                    <div class="ticket-categories">
                                        <div class="ticket-category">
                                            <h5>Category 1</h5>
                                            <div class="ticket-price">$250</div>
                                            <div class="ticket-availability">Limited</div>
                                        </div>
                                        <div class="ticket-category">
                                            <h5>Category 2</h5>
                                            <div class="ticket-price">$180</div>
                                            <div class="ticket-availability">Available</div>
                                        </div>
                                        <div class="ticket-category">
                                            <h5>Category 3</h5>
                                            <div class="ticket-price">$120</div>
                                            <div class="ticket-availability">Available</div>
                                        </div>
                                    </div>
                                    <div class="ticket-actions">
                                        <div class="ticket-quantity">
                                            <button class="quantity-btn minus">-</button>
                                            <input type="text" class="quantity-input" value="2" min="1"
                                                max="6">
                                            <button class="quantity-btn plus">+</button>
                                        </div>
                                        <button class="btn">Add to Cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Match Card 3 -->
                <div class="match-card">
                    <div class="match-stage">Group C</div>
                    <div class="match-header">
                        <div class="match-date">
                            <div class="match-day">
                                <i class="far fa-calendar-alt"></i> June 17, 2030
                            </div>
                            <div class="match-time">
                                <i class="far fa-clock"></i> 20:00 GMT
                            </div>
                        </div>
                        <div class="match-venue">
                            <i class="fas fa-map-marker-alt"></i> London Stadium, England
                        </div>
                    </div>
                    <div class="match-teams">
                        <div class="match-team">
                            <div class="team-flag"
                                style="background-image: url('https://via.placeholder.com/60x40/9b59b6/ffffff?text=ARG')">
                            </div>
                            <div class="team-name">Argentina</div>
                            <div class="team-code">ARG</div>
                        </div>
                        <div class="match-score">
                            <div class="score-display">vs</div>
                            <div class="match-status upcoming">Upcoming</div>
                        </div>
                        <div class="match-team">
                            <div class="team-flag"
                                style="background-image: url('https://via.placeholder.com/60x40/34495e/ffffff?text=ENG')">
                            </div>
                            <div class="team-name">England</div>
                            <div class="team-code">ENG</div>
                        </div>
                    </div>
                    <div class="match-footer">
                        <div class="match-group">Group C - Match 1</div>
                        <div class="match-actions">
                            <button class="btn btn-sm btn-outline match-details-btn" data-match="3">Details</button>
                            <button class="btn btn-sm">Buy Tickets</button>
                        </div>
                    </div>
                    <div class="match-details" id="match-details-3">
                        <div class="match-details-content">
                            <div class="match-details-section">
                                <div class="match-details-title">
                                    <i class="fas fa-info-circle"></i> Match Information
                                </div>
                                <div class="stadium-info">
                                    <div class="stadium-image"
                                        style="background-image: url('https://source.unsplash.com/random/160x120/?stadium,london')">
                                    </div>
                                    <div class="stadium-details">
                                        <h4>London Stadium</h4>
                                        <p>Capacity: 80,000 | London, England</p>
                                    </div>
                                </div>
                                <div class="referee-info">
                                    <div class="referee-image"
                                        style="background-image: url('https://via.placeholder.com/80x80/cccccc/333333?text=Referee')">
                                    </div>
                                    <div class="referee-details">
                                        <h4>Pierre Dupont</h4>
                                        <p>Head Referee | France</p>
                                    </div>
                                </div>
                            </div>
                            <div class="match-details-section">
                                <div class="match-details-title">
                                    <i class="fas fa-ticket-alt"></i> Ticket Information
                                </div>
                                <div class="ticket-info">
                                    <div class="ticket-categories">
                                        <div class="ticket-category">
                                            <h5>Category 1</h5>
                                            <div class="ticket-price">$250</div>
                                            <div class="ticket-availability">Limited</div>
                                        </div>
                                        <div class="ticket-category">
                                            <h5>Category 2</h5>
                                            <div class="ticket-price">$180</div>
                                            <div class="ticket-availability">Available</div>
                                        </div>
                                        <div class="ticket-category">
                                            <h5>Category 3</h5>
                                            <div class="ticket-price">$120</div>
                                            <div class="ticket-availability">Available</div>
                                        </div>
                                    </div>
                                    <div class="ticket-actions">
                                        <div class="ticket-quantity">
                                            <button class="quantity-btn minus">-</button>
                                            <input type="text" class="quantity-input" value="2" min="1"
                                                max="6">
                                            <button class="quantity-btn plus">+</button>
                                        </div>
                                        <button class="btn">Add to Cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Match Card 4 -->
                <div class="match-card">
                    <div class="match-stage">Group D</div>
                    <div class="match-header">
                        <div class="match-date">
                            <div class="match-day">
                                <i class="far fa-calendar-alt"></i> June 18, 2030
                            </div>
                            <div class="match-time">
                                <i class="far fa-clock"></i> 17:00 GMT
                            </div>
                        </div>
                        <div class="match-venue">
                            <i class="fas fa-map-marker-alt"></i> Paris Arena, France
                        </div>
                    </div>
                    <div class="match-teams">
                        <div class="match-team">
                            <div class="team-flag"
                                style="background-image: url('https://via.placeholder.com/60x40/1abc9c/ffffff?text=POR')">
                            </div>
                            <div class="team-name">Portugal</div>
                            <div class="team-code">POR</div>
                        </div>
                        <div class="match-score">
                            <div class="score-display">vs</div>
                            <div class="match-status upcoming">Upcoming</div>
                        </div>
                        <div class="match-team">
                            <div class="team-flag"
                                style="background-image: url('https://via.placeholder.com/60x40/e67e22/ffffff?text=NED')">
                            </div>
                            <div class="team-name">Netherlands</div>
                            <div class="team-code">NED</div>
                        </div>
                    </div>
                    <div class="match-footer">
                        <div class="match-group">Group D - Match 1</div>
                        <div class="match-actions">
                            <button class="btn btn-sm btn-outline match-details-btn" data-match="4">Details</button>
                            <button class="btn btn-sm">Buy Tickets</button>
                        </div>
                    </div>
                    <div class="match-details" id="match-details-4">
                        <div class="match-details-content">
                            <div class="match-details-section">
                                <div class="match-details-title">
                                    <i class="fas fa-info-circle"></i> Match Information
                                </div>
                                <div class="stadium-info">
                                    <div class="stadium-image"
                                        style="background-image: url('https://source.unsplash.com/random/160x120/?stadium,paris')">
                                    </div>
                                    <div class="stadium-details">
                                        <h4>Paris Arena</h4>
                                        <p>Capacity: 65,000 | Paris, France</p>
                                    </div>
                                </div>
                                <div class="referee-info">
                                    <div class="referee-image"
                                        style="background-image: url('https://via.placeholder.com/80x80/cccccc/333333?text=Referee')">
                                    </div>
                                    <div class="referee-details">
                                        <h4>Marco Rossi</h4>
                                        <p>Head Referee | Italy</p>
                                    </div>
                                </div>
                            </div>
                            <div class="match-details-section">
                                <div class="match-details-title">
                                    <i class="fas fa-ticket-alt"></i> Ticket Information
                                </div>
                                <div class="ticket-info">
                                    <div class="ticket-categories">
                                        <div class="ticket-category">
                                            <h5>Category 1</h5>
                                            <div class="ticket-price">$250</div>
                                            <div class="ticket-availability">Limited</div>
                                        </div>
                                        <div class="ticket-category">
                                            <h5>Category 2</h5>
                                            <div class="ticket-price">$180</div>
                                            <div class="ticket-availability">Available</div>
                                        </div>
                                        <div class="ticket-category">
                                            <h5>Category 3</h5>
                                            <div class="ticket-price">$120</div>
                                            <div class="ticket-availability">Available</div>
                                        </div>
                                    </div>
                                    <div class="ticket-actions">
                                        <div class="ticket-quantity">
                                            <button class="quantity-btn minus">-</button>
                                            <input type="text" class="quantity-input" value="2" min="1"
                                                max="6">
                                            <button class="quantity-btn plus">+</button>
                                        </div>
                                        <button class="btn">Add to Cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <ul class="pagination">
                <li><a href="#" class="disabled"><i class="fas fa-chevron-left"></i></a></li>
                <li><a href="#" class="active">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#"><i class="fas fa-chevron-right"></i></a></li>
            </ul>
        </section>
    </main>
@endsection

@section('js')
    <!-- JavaScript -->
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

            // Filters toggle
            const filtersToggle = document.querySelector('.filters-toggle');
            const filtersContent = document.querySelector('.filters-content');

            if (filtersToggle && filtersContent) {
                filtersToggle.addEventListener('click', function() {
                    filtersContent.classList.toggle('show');
                    filtersToggle.classList.toggle('collapsed');
                });
            }

            // Match details toggle - Fixed implementation
            const detailsBtns = document.querySelectorAll('.match-details-btn');

            if (detailsBtns.length > 0) {
                detailsBtns.forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        const matchId = this.getAttribute('data-match');
                        const detailsSection = document.querySelector('#match-details-' + matchId);

                        if (detailsSection) {
                            // Close all other details sections first
                            document.querySelectorAll('.match-details.show').forEach(function(
                                section) {
                                if (section !== detailsSection) {
                                    section.classList.remove('show');
                                    const otherBtn = document.querySelector(
                                        `.match-details-btn[data-match="${section.id.split('-').pop()}"]`
                                        );
                                    if (otherBtn) otherBtn.textContent = 'Details';
                                }
                            });

                            // Toggle the clicked section
                            detailsSection.classList.toggle('show');

                            if (detailsSection.classList.contains('show')) {
                                this.textContent = 'Hide Details';
                            } else {
                                this.textContent = 'Details';
                            }
                        }
                    });
                });
            }

            // Ticket category selection
            const ticketCategories = document.querySelectorAll('.ticket-category');

            if (ticketCategories.length > 0) {
                ticketCategories.forEach(function(category) {
                    category.addEventListener('click', function() {
                        const parent = this.closest('.ticket-categories');

                        if (parent) {
                            parent.querySelectorAll('.ticket-category').forEach(function(cat) {
                                cat.classList.remove('selected');
                            });

                            this.classList.add('selected');
                        }
                    });
                });
            }

            // Quantity buttons
            const minusBtns = document.querySelectorAll('.quantity-btn.minus');
            const plusBtns = document.querySelectorAll('.quantity-btn.plus');

            if (minusBtns.length > 0 && plusBtns.length > 0) {
                minusBtns.forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        const input = this.nextElementSibling;
                        let value = parseInt(input.value);

                        if (value > parseInt(input.getAttribute('min'))) {
                            input.value = value - 1;
                        }
                    });
                });

                plusBtns.forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        const input = this.previousElementSibling;
                        let value = parseInt(input.value);

                        if (value < parseInt(input.getAttribute('max'))) {
                            input.value = value + 1;
                        }
                    });
                });
            }
        });
    </script>
@endsection
