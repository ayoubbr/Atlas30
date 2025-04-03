@extends('user.layout')

@section('title', 'Seat Selection - World Cup 2030')

@section('css')
    <style>
        /* Match Info */
        .match-info {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .match-info-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .match-info-title h2 {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }

        .match-info-subtitle {
            color: var(--gray-600);
            font-size: 0.9rem;
        }

        .match-stage-badge {
            background-color: var(--accent);
            color: var(--dark);
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .match-details {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
        }

        .match-teams {
            display: flex;
            align-items: center;
            flex: 1;
            min-width: 300px;
        }

        .match-team {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
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

        .match-vs {
            margin: 0 20px;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--gray-600);
        }

        .match-info-details {
            flex: 1;
            min-width: 300px;
        }

        .match-info-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .match-info-item i {
            color: var(--primary);
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Seat Selection Container */
        .seat-selection-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 40px;
        }

        /* Stadium Map */
        .stadium-map-container {
            flex: 2;
            min-width: 300px;
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .stadium-map-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .stadium-map-title h3 {
            font-size: 1.3rem;
            margin-bottom: 5px;
        }

        .stadium-map-subtitle {
            color: var(--gray-600);
            font-size: 0.9rem;
        }

        .stadium-controls {
            display: flex;
            gap: 10px;
        }

        .zoom-control {
            display: flex;
            align-items: center;
            background-color: var(--gray-100);
            border-radius: 4px;
            overflow: hidden;
        }

        .zoom-btn {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--gray-200);
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .zoom-btn:hover {
            background-color: var(--gray-300);
        }

        .reset-view-btn {
            background-color: var(--gray-200);
            border: none;
            border-radius: 4px;
            padding: 0 15px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .reset-view-btn:hover {
            background-color: var(--gray-300);
        }

        .stadium-map-wrapper {
            position: relative;
            overflow: hidden;
            border: 1px solid var(--gray-300);
            border-radius: 4px;
            height: 500px;
            margin-bottom: 20px;
        }

        .stadium-map {
            width: 100%;
            height: 100%;
            transition: transform 0.3s ease;
            transform-origin: center;
            cursor: grab;
        }

        .stadium-map.grabbing {
            cursor: grabbing;
        }

        .stadium-map svg {
            width: 100%;
            height: 100%;
        }

        .stadium-section {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .stadium-section:hover {
            opacity: 0.8;
        }

        .stadium-section.selected {
            stroke: var(--accent);
            stroke-width: 2;
        }

        .stadium-section-label {
            font-size: 12px;
            font-weight: 600;
            pointer-events: none;
        }

        .stadium-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
        }

        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            margin-right: 8px;
        }

        /* Seat Selection Panel */
        .seat-selection-panel {
            flex: 1;
            min-width: 300px;
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .seat-selection-header {
            margin-bottom: 20px;
        }

        .seat-selection-header h3 {
            font-size: 1.3rem;
            margin-bottom: 5px;
        }

        .seat-selection-subtitle {
            color: var(--gray-600);
            font-size: 0.9rem;
        }

        .section-details {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.1rem;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--gray-300);
        }

        .section-info {
            margin-bottom: 20px;
        }

        .section-info-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .section-info-label {
            color: var(--gray-700);
        }

        .section-info-value {
            font-weight: 600;
        }

        .section-info-value.highlight {
            color: var(--primary);
        }

        .seat-grid-container {
            margin-bottom: 30px;
        }

        .seat-grid-title {
            font-size: 1rem;
            margin-bottom: 15px;
        }

        .seat-grid {
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            gap: 5px;
            margin-bottom: 15px;
        }

        .seat {
            width: 100%;
            aspect-ratio: 1;
            border-radius: 4px;
            background-color: var(--seat-available);
            border: 1px solid var(--gray-400);
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--gray-700);
        }

        .seat:hover {
            transform: scale(1.1);
            z-index: 1;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .seat.selected {
            background-color: var(--seat-selected);
            border-color: var(--accent);
            color: var(--dark);
        }

        .seat.reserved {
            background-color: var(--seat-reserved);
            cursor: not-allowed;
            pointer-events: none;
            color: var(--gray-500);
        }

        .seat.disabled {
            background-color: var(--category-disabled);
            cursor: not-allowed;
            pointer-events: none;
        }

        .seat-grid-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 10px;
        }

        .seat-legend-item {
            display: flex;
            align-items: center;
            font-size: 0.8rem;
        }

        .seat-legend-color {
            width: 15px;
            height: 15px;
            border-radius: 3px;
            margin-right: 5px;
            border: 1px solid var(--gray-400);
        }

        .selected-seats {
            margin-bottom: 30px;
        }

        .selected-seats-title {
            font-size: 1.1rem;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--gray-300);
        }

        .selected-seats-list {
            max-height: 200px;
            overflow-y: auto;
            margin-bottom: 20px;
        }

        .selected-seat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: var(--gray-100);
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .selected-seat-info {
            flex: 1;
        }

        .selected-seat-location {
            font-weight: 600;
            margin-bottom: 3px;
        }

        .selected-seat-category {
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        .selected-seat-price {
            font-weight: 600;
            color: var(--primary);
            margin-right: 10px;
        }

        .remove-seat-btn {
            background: none;
            border: none;
            color: var(--gray-600);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .remove-seat-btn:hover {
            color: var(--danger);
        }

        .order-summary {
            background-color: var(--gray-100);
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .order-summary-title {
            font-size: 1rem;
            margin-bottom: 15px;
        }

        .order-summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .order-summary-label {
            color: var(--gray-700);
        }

        .order-summary-value {
            font-weight: 600;
        }

        .order-total {
            display: flex;
            justify-content: space-between;
            padding-top: 10px;
            margin-top: 10px;
            border-top: 1px solid var(--gray-300);
            font-size: 1.1rem;
        }

        .order-total-label {
            font-weight: 600;
        }

        .order-total-value {
            font-weight: 700;
            color: var(--primary);
        }

        .checkout-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .seat-selection-container {
                flex-direction: column;
            }

            .stadium-map-wrapper {
                height: 400px;
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

            .match-teams {
                justify-content: center;
            }

            .stadium-map-wrapper {
                height: 350px;
            }

            .seat-grid {
                grid-template-columns: repeat(6, 1fr);
            }
        }

        @media (max-width: 576px) {
            .match-details {
                flex-direction: column;
                gap: 20px;
            }

            .match-teams {
                justify-content: space-between;
            }

            .stadium-map-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .stadium-controls {
                width: 100%;
                justify-content: space-between;
            }

            .stadium-map-wrapper {
                height: 300px;
            }

            .seat-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }
    </style>
@endsection

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Select Your Seats</h1>
            <ul class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">Matches</a></li>
                <li><a href="#">Tickets</a></li>
                <li><a href="#">Seat Selection</a></li>
            </ul>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container">
        <!-- Match Info -->
        <section class="match-info">
            <div class="match-info-header">
                <div class="match-info-title">
                    <h2>Brazil vs France</h2>
                    <div class="match-info-subtitle">Group A - Match 1</div>
                </div>
                <div class="match-stage-badge">Group Stage</div>
            </div>
            <div class="match-details">
                <div class="match-teams">
                    <div class="match-team">
                        <div class="team-flag"
                            style="background-image: url('https://via.placeholder.com/60x40/3498db/ffffff?text=BRA')">
                        </div>
                        <div class="team-name">Brazil</div>
                    </div>
                    <div class="match-vs">VS</div>
                    <div class="match-team">
                        <div class="team-flag"
                            style="background-image: url('https://via.placeholder.com/60x40/e74c3c/ffffff?text=FRA')">
                        </div>
                        <div class="team-name">France</div>
                    </div>
                </div>
                <div class="match-info-details">
                    <div class="match-info-item">
                        <i class="far fa-calendar-alt"></i>
                        <span>June 15, 2030</span>
                    </div>
                    <div class="match-info-item">
                        <i class="far fa-clock"></i>
                        <span>18:00 GMT</span>
                    </div>
                    <div class="match-info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Rio Stadium, Brazil</span>
                    </div>
                    <div class="match-info-item">
                        <i class="fas fa-users"></i>
                        <span>Capacity: 75,000</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Seat Selection Container -->
        <div class="seat-selection-container">
            <!-- Stadium Map -->
            <section class="stadium-map-container">
                <div class="stadium-map-header">
                    <div class="stadium-map-title">
                        <h3>Stadium Map</h3>
                        <div class="stadium-map-subtitle">Click on a section to select seats</div>
                    </div>
                    <div class="stadium-controls">
                        <div class="zoom-control">
                            <button class="zoom-btn" id="zoom-out">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button class="zoom-btn" id="zoom-in">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <button class="reset-view-btn" id="reset-view">
                            <i class="fas fa-sync-alt"></i> Reset
                        </button>
                    </div>
                </div>
                <div class="stadium-map-wrapper">
                    <div class="stadium-map" id="stadium-map">
                        <svg viewBox="0 0 800 600" xmlns="http://www.w3.org/2000/svg">
                            <!-- Field -->
                            <rect x="250" y="200" width="300" height="200" fill="#27ae60" stroke="#1d8348"
                                stroke-width="2" />

                            <!-- Field Lines -->
                            <circle cx="400" cy="300" r="50" fill="none" stroke="white" stroke-width="2" />
                            <line x1="400" y1="200" x2="400" y2="400" stroke="white"
                                stroke-width="2" />
                            <rect x="325" y="200" width="150" height="50" fill="none" stroke="white"
                                stroke-width="2" />
                            <rect x="325" y="350" width="150" height="50" fill="none" stroke="white"
                                stroke-width="2" />

                            <!-- North Stand (Category 1) -->
                            <path id="section-north" class="stadium-section" d="M250,150 L550,150 L550,200 L250,200 Z"
                                fill="#e63946" stroke="#333" stroke-width="1" data-section="North Stand"
                                data-category="Category 1" data-price="250" />
                            <text x="400" y="175" text-anchor="middle" class="stadium-section-label" fill="white">North
                                Stand</text>

                            <!-- South Stand (Category 1) -->
                            <path id="section-south" class="stadium-section" d="M250,400 L550,400 L550,450 L250,450 Z"
                                fill="#e63946" stroke="#333" stroke-width="1" data-section="South Stand"
                                data-category="Category 1" data-price="250" />
                            <text x="400" y="425" text-anchor="middle" class="stadium-section-label" fill="white">South
                                Stand</text>

                            <!-- East Stand (Category 2) -->
                            <path id="section-east" class="stadium-section" d="M550,200 L600,150 L600,450 L550,400 Z"
                                fill="#3498db" stroke="#333" stroke-width="1" data-section="East Stand"
                                data-category="Category 2" data-price="180" />
                            <text x="575" y="300" text-anchor="middle" class="stadium-section-label" fill="white">East
                                Stand</text>

                            <!-- West Stand (Category 2) -->
                            <path id="section-west" class="stadium-section" d="M250,200 L200,150 L200,450 L250,400 Z"
                                fill="#3498db" stroke="#333" stroke-width="1" data-section="West Stand"
                                data-category="Category 2" data-price="180" />
                            <text x="225" y="300" text-anchor="middle" class="stadium-section-label" fill="white">West
                                Stand</text>

                            <!-- Northeast Corner (Category 3) -->
                            <path id="section-northeast" class="stadium-section" d="M550,150 L600,150 L550,200 Z"
                                fill="#2ecc71" stroke="#333" stroke-width="1" data-section="Northeast Corner"
                                data-category="Category 3" data-price="120" />
                            <text x="567" y="167" text-anchor="middle" class="stadium-section-label"
                                fill="white">NE</text>

                            <!-- Northwest Corner (Category 3) -->
                            <path id="section-northwest" class="stadium-section" d="M250,150 L200,150 L250,200 Z"
                                fill="#2ecc71" stroke="#333" stroke-width="1" data-section="Northwest Corner"
                                data-category="Category 3" data-price="120" />
                            <text x="233" y="167" text-anchor="middle" class="stadium-section-label"
                                fill="white">NW</text>

                            <!-- Southeast Corner (Category 3) -->
                            <path id="section-southeast" class="stadium-section" d="M550,400 L600,450 L550,450 Z"
                                fill="#2ecc71" stroke="#333" stroke-width="1" data-section="Southeast Corner"
                                data-category="Category 3" data-price="120" />
                            <text x="567" y="433" text-anchor="middle" class="stadium-section-label"
                                fill="white">SE</text>

                            <!-- Southwest Corner (Category 3) -->
                            <path id="section-southwest" class="stadium-section" d="M250,400 L200,450 L250,450 Z"
                                fill="#2ecc71" stroke="#333" stroke-width="1" data-section="Southwest Corner"
                                data-category="Category 3" data-price="120" />
                            <text x="233" y="433" text-anchor="middle" class="stadium-section-label"
                                fill="white">SW</text>

                            <!-- VIP Boxes (Category VIP) -->
                            <rect id="section-vip-north" class="stadium-section" x="350" y="120" width="100"
                                height="30" fill="#9b59b6" stroke="#333" stroke-width="1" data-section="VIP North"
                                data-category="VIP" data-price="350" />
                            <text x="400" y="140" text-anchor="middle" class="stadium-section-label" fill="white">VIP
                                North</text>

                            <rect id="section-vip-south" class="stadium-section" x="350" y="450" width="100"
                                height="30" fill="#9b59b6" stroke="#333" stroke-width="1" data-section="VIP South"
                                data-category="VIP" data-price="350" />
                            <text x="400" y="470" text-anchor="middle" class="stadium-section-label" fill="white">VIP
                                South</text>

                            <!-- Disabled Access Areas -->
                            <rect id="section-disabled-east" class="stadium-section" x="550" y="290" width="30"
                                height="20" fill="#7f8c8d" stroke="#333" stroke-width="1"
                                data-section="Disabled Access East" data-category="Disabled Access" data-price="120" />
                            <text x="565" y="305" text-anchor="middle" class="stadium-section-label"
                                fill="white">DA</text>

                            <rect id="section-disabled-west" class="stadium-section" x="220" y="290" width="30"
                                height="20" fill="#7f8c8d" stroke="#333" stroke-width="1"
                                data-section="Disabled Access West" data-category="Disabled Access" data-price="120" />
                            <text x="235" y="305" text-anchor="middle" class="stadium-section-label"
                                fill="white">DA</text>
                        </svg>
                    </div>
                </div>
                <div class="stadium-legend">
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: var(--category-1);"></div>
                        <span>Category 1 ($250)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: var(--category-2);"></div>
                        <span>Category 2 ($180)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: var(--category-3);"></div>
                        <span>Category 3 ($120)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: var(--category-vip);"></div>
                        <span>VIP ($350)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: var(--category-disabled);"></div>
                        <span>Disabled Access ($120)</span>
                    </div>
                </div>
            </section>

            <!-- Seat Selection Panel -->
            <section class="seat-selection-panel">
                <div class="seat-selection-header">
                    <h3>Select Your Seats</h3>
                    <div class="seat-selection-subtitle">Choose seats from the selected section</div>
                </div>

                <div class="section-details">
                    <h4 class="section-title">Section Information</h4>
                    <div class="section-info">
                        <div class="section-info-item">
                            <div class="section-info-label">Section:</div>
                            <div class="section-info-value" id="selected-section-name">North Stand</div>
                        </div>
                        <div class="section-info-item">
                            <div class="section-info-label">Category:</div>
                            <div class="section-info-value" id="selected-section-category">Category 1</div>
                        </div>
                        <div class="section-info-item">
                            <div class="section-info-label">Price per seat:</div>
                            <div class="section-info-value highlight" id="selected-section-price">$250</div>
                        </div>
                        <div class="section-info-item">
                            <div class="section-info-label">Available seats:</div>
                            <div class="section-info-value" id="selected-section-availability">42</div>
                        </div>
                    </div>
                </div>

                <div class="seat-grid-container">
                    <h4 class="seat-grid-title">Select seats from Row 12</h4>
                    <div class="seat-grid" id="seat-grid">
                        <div class="seat" data-seat="12-1">1</div>
                        <div class="seat" data-seat="12-2">2</div>
                        <div class="seat reserved" data-seat="12-3">3</div>
                        <div class="seat reserved" data-seat="12-4">4</div>
                        <div class="seat" data-seat="12-5">5</div>
                        <div class="seat" data-seat="12-6">6</div>
                        <div class="seat" data-seat="12-7">7</div>
                        <div class="seat" data-seat="12-8">8</div>
                        <div class="seat" data-seat="12-9">9</div>
                        <div class="seat" data-seat="12-10">10</div>
                        <div class="seat reserved" data-seat="12-11">11</div>
                        <div class="seat" data-seat="12-12">12</div>
                        <div class="seat" data-seat="12-13">13</div>
                        <div class="seat" data-seat="12-14">14</div>
                        <div class="seat" data-seat="12-15">15</div>
                        <div class="seat" data-seat="12-16">16</div>
                    </div>
                    <div class="seat-grid-legend">
                        <div class="seat-legend-item">
                            <div class="seat-legend-color" style="background-color: var(--seat-available);"></div>
                            <span>Available</span>
                        </div>
                        <div class="seat-legend-item">
                            <div class="seat-legend-color" style="background-color: var(--seat-selected);"></div>
                            <span>Selected</span>
                        </div>
                        <div class="seat-legend-item">
                            <div class="seat-legend-color" style="background-color: var(--seat-reserved);"></div>
                            <span>Reserved</span>
                        </div>
                    </div>
                </div>

                <div class="selected-seats">
                    <h4 class="selected-seats-title">Your Selected Seats</h4>
                    <div class="selected-seats-list" id="selected-seats-list">
                        <!-- Selected seats will be added here dynamically -->
                    </div>
                </div>

                <div class="order-summary">
                    <h4 class="order-summary-title">Order Summary</h4>
                    <div class="order-summary-item">
                        <div class="order-summary-label">Tickets:</div>
                        <div class="order-summary-value" id="summary-tickets">0</div>
                    </div>
                    <div class="order-summary-item">
                        <div class="order-summary-label">Subtotal:</div>
                        <div class="order-summary-value" id="summary-subtotal">$0.00</div>
                    </div>
                    <div class="order-summary-item">
                        <div class="order-summary-label">Service Fee:</div>
                        <div class="order-summary-value" id="summary-fee">$0.00</div>
                    </div>
                    <div class="order-total">
                        <div class="order-total-label">Total:</div>
                        <div class="order-total-value" id="summary-total">$0.00</div>
                    </div>
                </div>

                <div class="checkout-actions">
                    <button class="btn btn-lg btn-success" id="checkout-btn" disabled>Proceed to Checkout</button>
                    <button class="btn btn-lg btn-outline" id="clear-selection-btn" disabled>Clear Selection</button>
                </div>
            </section>
        </div>
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

            // Stadium Map Zoom and Pan
            const stadiumMap = document.getElementById('stadium-map');
            const zoomInBtn = document.getElementById('zoom-in');
            const zoomOutBtn = document.getElementById('zoom-out');
            const resetViewBtn = document.getElementById('reset-view');

            let scale = 1;
            let translateX = 0;
            let translateY = 0;
            let isDragging = false;
            let startX, startY;

            function updateMapTransform() {
                stadiumMap.style.transform = `translate(${translateX}px, ${translateY}px) scale(${scale})`;
            }

            zoomInBtn.addEventListener('click', function() {
                if (scale < 2) {
                    scale += 0.1;
                    updateMapTransform();
                }
            });

            zoomOutBtn.addEventListener('click', function() {
                if (scale > 0.5) {
                    scale -= 0.1;
                    updateMapTransform();
                }
            });

            resetViewBtn.addEventListener('click', function() {
                scale = 1;
                translateX = 0;
                translateY = 0;
                updateMapTransform();
            });

            stadiumMap.addEventListener('mousedown', function(e) {
                isDragging = true;
                startX = e.clientX - translateX;
                startY = e.clientY - translateY;
                stadiumMap.classList.add('grabbing');
            });

            document.addEventListener('mousemove', function(e) {
                if (isDragging) {
                    translateX = e.clientX - startX;
                    translateY = e.clientY - startY;
                    updateMapTransform();
                }
            });

            document.addEventListener('mouseup', function() {
                isDragging = false;
                stadiumMap.classList.remove('grabbing');
            });

            // Stadium Section Selection
            const stadiumSections = document.querySelectorAll('.stadium-section');
            const selectedSectionName = document.getElementById('selected-section-name');
            const selectedSectionCategory = document.getElementById('selected-section-category');
            const selectedSectionPrice = document.getElementById('selected-section-price');

            stadiumSections.forEach(section => {
                section.addEventListener('click', function() {
                    // Remove selected class from all sections
                    stadiumSections.forEach(s => s.classList.remove('selected'));

                    // Add selected class to clicked section
                    this.classList.add('selected');

                    // Update section details
                    const sectionName = this.getAttribute('data-section');
                    const sectionCategory = this.getAttribute('data-category');
                    const sectionPrice = this.getAttribute('data-price');

                    selectedSectionName.textContent = sectionName;
                    selectedSectionCategory.textContent = sectionCategory;
                    selectedSectionPrice.textContent = '$' + sectionPrice;

                    // Update seat grid title
                    document.querySelector('.seat-grid-title').textContent =
                        `Select seats from ${sectionName}`;
                });
            });

            // Seat Selection
            const seats = document.querySelectorAll('.seat:not(.reserved):not(.disabled)');
            const selectedSeatsList = document.getElementById('selected-seats-list');
            const summaryTickets = document.getElementById('summary-tickets');
            const summarySubtotal = document.getElementById('summary-subtotal');
            const summaryFee = document.getElementById('summary-fee');
            const summaryTotal = document.getElementById('summary-total');
            const checkoutBtn = document.getElementById('checkout-btn');
            const clearSelectionBtn = document.getElementById('clear-selection-btn');

            let selectedSeats = [];

            seats.forEach(seat => {
                seat.addEventListener('click', function() {
                    const seatId = this.getAttribute('data-seat');
                    const sectionName = selectedSectionName.textContent;
                    const sectionCategory = selectedSectionCategory.textContent;
                    const sectionPrice = parseFloat(selectedSectionPrice.textContent.replace('$',
                        ''));

                    if (this.classList.contains('selected')) {
                        // Deselect seat
                        this.classList.remove('selected');

                        // Remove from selected seats array
                        selectedSeats = selectedSeats.filter(s => s.id !== seatId);

                        // Remove from selected seats list
                        const seatElement = document.getElementById(`selected-seat-${seatId}`);
                        if (seatElement) {
                            seatElement.remove();
                        }
                    } else {
                        // Select seat
                        this.classList.add('selected');

                        // Add to selected seats array
                        selectedSeats.push({
                            id: seatId,
                            section: sectionName,
                            category: sectionCategory,
                            price: sectionPrice
                        });

                        // Add to selected seats list
                        const seatElement = document.createElement('div');
                        seatElement.id = `selected-seat-${seatId}`;
                        seatElement.className = 'selected-seat-item';
                        seatElement.innerHTML = `
                            <div class="selected-seat-info">
                                <div class="selected-seat-location">${sectionName}, Seat ${seatId}</div>
                                <div class="selected-seat-category">${sectionCategory}</div>
                            </div>
                            <div class="selected-seat-price">$${sectionPrice}</div>
                            <button class="remove-seat-btn" data-seat="${seatId}">
                                <i class="fas fa-times"></i>
                            </button>
                        `;
                        selectedSeatsList.appendChild(seatElement);

                        // Add event listener to remove button
                        const removeBtn = seatElement.querySelector('.remove-seat-btn');
                        removeBtn.addEventListener('click', function() {
                            const seatId = this.getAttribute('data-seat');
                            const seatElement = document.getElementById(
                                `selected-seat-${seatId}`);
                            const seat = document.querySelector(
                                `.seat[data-seat="${seatId}"]`);

                            // Remove from selected seats array
                            selectedSeats = selectedSeats.filter(s => s.id !== seatId);

                            // Remove from selected seats list
                            if (seatElement) {
                                seatElement.remove();
                            }

                            // Deselect seat in grid
                            if (seat) {
                                seat.classList.remove('selected');
                            }

                            // Update order summary
                            updateOrderSummary();
                        });
                    }

                    // Update order summary
                    updateOrderSummary();
                });
            });

            function updateOrderSummary() {
                const ticketCount = selectedSeats.length;
                const subtotal = selectedSeats.reduce((total, seat) => total + seat.price, 0);
                const serviceFee = subtotal * 0.1; // 10% service fee
                const total = subtotal + serviceFee;

                summaryTickets.textContent = ticketCount;
                summarySubtotal.textContent = '$' + subtotal.toFixed(2);
                summaryFee.textContent = '$' + serviceFee.toFixed(2);
                summaryTotal.textContent = '$' + total.toFixed(2);

                // Enable/disable checkout and clear buttons
                if (ticketCount > 0) {
                    checkoutBtn.disabled = false;
                    clearSelectionBtn.disabled = false;
                } else {
                    checkoutBtn.disabled = true;
                    clearSelectionBtn.disabled = true;
                }
            }

            // Clear selection button
            clearSelectionBtn.addEventListener('click', function() {
                // Clear selected seats array
                selectedSeats = [];

                // Clear selected seats list
                selectedSeatsList.innerHTML = '';

                // Deselect all seats in grid
                seats.forEach(seat => {
                    seat.classList.remove('selected');
                });

                // Update order summary
                updateOrderSummary();
            });

            // Checkout button
            checkoutBtn.addEventListener('click', function() {
                alert('Proceeding to checkout with ' + selectedSeats.length + ' tickets.');
                // In a real application, this would redirect to a checkout page
            });

            // Initialize with North Stand selected
            document.getElementById('section-north').click();
        });
    </script>
@endsection
