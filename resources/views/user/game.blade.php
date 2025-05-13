@extends('user.layout')

@section('title', $game->homeTeam->name . ' vs ' . $game->awayTeam->name . ' - World Cup 2030')

@section('css')
    <style>
        :root {
            --section-premium: #e63946;
            --section-standard: #3498db;
            --section-economy: #2ecc71;
            --section-vip: #9b59b6;
            --section-disabled: #7f8c8d;
        }

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

        /* Ticket Selection Panel */
        .ticket-selection-panel {
            flex: 1;
            min-width: 300px;
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .ticket-selection-header {
            margin-bottom: 20px;
        }

        .ticket-selection-header h3 {
            font-size: 1.3rem;
            margin-bottom: 5px;
        }

        .ticket-selection-subtitle {
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

        .ticket-quantity-container {
            margin-bottom: 30px;
        }

        .ticket-quantity-title {
            font-size: 1.1rem;
            margin-bottom: 15px;
        }

        .ticket-quantity-control {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .quantity-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--gray-200);
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .quantity-btn:hover {
            background-color: var(--gray-300);
        }

        .quantity-input {
            width: 60px;
            height: 40px;
            text-align: center;
            border: 1px solid var(--gray-300);
            margin: 0 10px;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .selected-tickets {
            margin-bottom: 30px;
        }

        .selected-tickets-title {
            font-size: 1.1rem;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--gray-300);
        }

        .selected-tickets-list {
            margin-bottom: 20px;
        }

        .selected-ticket-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background-color: var(--gray-100);
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .selected-ticket-info {
            flex: 1;
        }

        .selected-ticket-section {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .selected-ticket-quantity {
            font-size: 0.9rem;
            color: var(--gray-600);
        }

        .selected-ticket-price {
            font-weight: 600;
            color: var(--primary);
            font-size: 1.1rem;
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
        }

        .hide-tickets-number {
            display: none
        }
    </style>
@endsection

@section('content')
    <section class="page-header">
        <div class="container">
            <h1>{{ $game->homeTeam->name }} vs {{ $game->awayTeam->name }}</h1>
            <ul class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ route('games') }}">Games</a></li>
                <li>Match Details</li>
            </ul>
        </div>
    </section>

    <main class="container">
        <!-- Match Info -->
        <section class="match-info">
            <div class="match-info-header">
                <div class="match-info-title">
                    <h2>{{ $game->homeTeam->name }} vs {{ $game->awayTeam->name }}</h2>
                </div>
                <div class="match-stage-badge">{{ ucfirst($game->status) }}</div>
            </div>
            <div class="match-details">
                <div class="match-teams">
                    <div class="match-team">
                        <div class="team-flag"
                            style="background-image: url('{{ asset($game->homeTeam->flag) ?? 'https://via.placeholder.com/60x40/3498db/ffffff?text=' . substr($game->homeTeam->name, 0, 3) }}')">
                        </div>
                        <div class="team-name">{{ $game->homeTeam->name }}</div>
                    </div>
                    <div class="match-vs">
                        @if ($game->status == 'completed' || $game->status == 'live')
                            {{ $game->home_team_goals }} - {{ $game->away_team_goals }}
                        @else
                            VS
                        @endif
                    </div>
                    <div class="match-team">
                        <div class="team-flag"
                            style="background-image: url('{{ asset($game->awayTeam->flag) ?? 'https://via.placeholder.com/60x40/e74c3c/ffffff?text=' . substr($game->awayTeam->name, 0, 3) }}')">
                        </div>
                        <div class="team-name">{{ $game->awayTeam->name }}</div>
                    </div>
                </div>
                <div class="match-info-details">
                    <div class="match-info-item">
                        <i class="far fa-calendar-alt"></i>
                        <span>{{ $game->start_date }}</span>
                    </div>
                    <div class="match-info-item">
                        <i class="far fa-clock"></i>
                        <span>{{ $game->start_hour }}</span>
                    </div>
                    <div class="match-info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $game->stadium->name }}, {{ $game->stadium->city }}</span>
                    </div>
                    <div class="match-info-item">
                        <i class="fas fa-users"></i>
                        <span>Capacity: {{ number_format($game->stadium->capacity) }}</span>
                    </div>
                </div>
            </div>
        </section>

        @if ($game->status == 'upcoming' || $game->status == 'live')
            <div class="seat-selection-container">
                <section class="stadium-map-container">
                    <div class="stadium-map-header">
                        <div class="stadium-map-title">
                            <h3>Stadium Map</h3>
                            <div class="stadium-map-subtitle">Click on a section to select tickets</div>
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
                                <circle cx="400" cy="300" r="50" fill="none" stroke="white"
                                    stroke-width="2" />
                                <line x1="400" y1="200" x2="400" y2="400" stroke="white"
                                    stroke-width="2" />
                                <rect x="325" y="200" width="150" height="50" fill="none" stroke="white"
                                    stroke-width="2" />
                                <rect x="325" y="350" width="150" height="50" fill="none" stroke="white"
                                    stroke-width="2" />

                                <!-- Premium Section (North Stand) -->
                                <path id="section-premium" class="stadium-section" d="M250,150 L550,150 L550,200 L250,200 Z"
                                    fill="var(--section-premium)" stroke="#333" stroke-width="1" data-section="premium"
                                    data-price="250" data-available="50" />
                                <text x="400" y="175" text-anchor="middle" class="stadium-section-label" fill="white">
                                    Premium
                                </text>

                                <!-- Standard Section (South Stand) -->
                                <path id="section-standard" class="stadium-section"
                                    d="M250,400 L550,400 L550,450 L250,450 Z" fill="var(--section-standard)" stroke="#333"
                                    stroke-width="1" data-section="regular" data-price="180" data-available="80" />
                                <text x="400" y="425" text-anchor="middle" class="stadium-section-label" fill="white">
                                    Regular
                                </text>

                                <!-- Economy Section (East Stand) -->
                                <path id="section-economy" class="stadium-section"
                                    d="M550,200 L600,150 L600,450 L550,400 Z" fill="var(--section-economy)" stroke="#333"
                                    stroke-width="1" data-section="regular" data-price="120" data-available="100" />
                                <text x="575" y="300" text-anchor="middle" class="stadium-section-label" fill="white">
                                    Regular
                                </text>

                                <!-- Economy Section (West Stand) -->
                                <path id="section-economy-west" class="stadium-section"
                                    d="M250,200 L200,150 L200,450 L250,400 Z" fill="var(--section-economy)" stroke="#333"
                                    stroke-width="1" data-section="economy" data-price="120" data-available="100" />
                                <text x="225" y="300" text-anchor="middle" class="stadium-section-label" fill="white">
                                    Economy
                                </text>

                                <!-- VIP Section -->
                                <rect id="section-vip" class="stadium-section" x="350" y="120" width="100"
                                    height="30" fill="var(--section-vip)" stroke="#333" stroke-width="1"
                                    data-section="vip" data-price="350" data-available="20" />
                                <text x="400" y="140" text-anchor="middle" class="stadium-section-label" fill="white">
                                    VIP
                                </text>
                            </svg>
                        </div>
                    </div>
                    <div class="stadium-legend">
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: var(--section-premium);"></div>
                            <span>Premium ($250)</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: var(--section-standard);"></div>
                            <span>Standard ($180)</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: var(--section-economy);"></div>
                            <span>Economy ($120)</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: var(--section-vip);"></div>
                            <span>VIP ($350)</span>
                        </div>
                    </div>
                </section>

                <!-- Ticket Selection Panel -->
                <section class="ticket-selection-panel">
                    <div class="ticket-selection-header">
                        <h3>Select Tickets</h3>
                        <div class="ticket-selection-subtitle">Choose a section and number of tickets</div>
                    </div>

                    <div class="section-details">
                        <h4 class="section-title">Section Information</h4>
                        <div class="section-info">
                            <div class="section-info-item">
                                <div class="section-info-label">Section:</div>
                                <div class="section-info-value" id="selected-section-name">Select a section</div>
                            </div>
                            <div class="section-info-item">
                                <div class="section-info-label">Price per ticket:</div>
                                <div class="section-info-value highlight" id="selected-section-price">$0</div>
                            </div>
                            <div class="section-info-item">
                                <div class="section-info-label">Available tickets:</div>
                                <div class="section-info-value" id="selected-section-availability">0</div>
                            </div>
                        </div>
                    </div>

                    <div class="ticket-quantity-container hide-tickets-number" id="tickets-number">
                        <h4 class="ticket-quantity-title">Number of Tickets</h4>
                        <div class="ticket-quantity-control">
                            <button class="quantity-btn" id="decrease-quantity">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" class="quantity-input" id="ticket-quantity" value="1"
                                min="1" max="10">
                            <button class="quantity-btn" id="increase-quantity">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <p class="text-sm text-gray-600">Maximum 10 tickets per order</p>
                    </div>

                    <div class="selected-tickets">
                        <h4 class="selected-tickets-title">Your Selected Tickets</h4>
                        <div class="selected-tickets-list" id="selected-tickets-list">
                            <!-- Selected tickets will be shown here -->
                            <div class="text-center py-4 text-gray-500" id="no-tickets-message">
                                No tickets selected yet. Please select a section from the stadium map.
                            </div>
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

                    <form action="{{ route('tickets.buy', $game->id) }}" method="POST" id="checkout-form">
                        @csrf
                        <input type="hidden" name="game_id" value="{{ $game->id }}">
                        <input type="hidden" name="section" id="section-input" value="">
                        <input type="hidden" name="quantity" id="quantity-input" value="1">
                        <input type="hidden" name="price" id="price-input" value="0">
                        <div class="checkout-actions">
                            <button type="submit" class="btn btn-lg btn-success" id="checkout-btn" disabled>Proceed to
                                Checkout</button>
                            <button type="button" class="btn btn-lg btn-outline" id="clear-selection-btn" disabled>Clear
                                Selection</button>
                        </div>
                    </form>
                </section>
            </div>
        @else
            <div class="alert alert-info">
                <h4>Ticket Sales Closed</h4>
                <p>Ticket sales for this match are no longer available as the match is {{ $game->status }}.</p>
                <a href="{{ route('games') }}" class="btn btn-primary mt-3">View Other Matches</a>
            </div>
        @endif
    </main>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.querySelector('.mobile-menu');
            const navLinks = document.querySelector('.nav-links');

            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function() {
                    navLinks.classList.toggle('active');
                });
            }

            @if ($game->status != 'completed' && $game->status != 'canceled')
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

                const stadiumSections = document.querySelectorAll('.stadium-section');
                const selectedSectionName = document.getElementById('selected-section-name');
                const selectedSectionPrice = document.getElementById('selected-section-price');
                const selectedSectionAvailability = document.getElementById('selected-section-availability');
                const ticketQuantityInput = document.getElementById('ticket-quantity');
                const decreaseQuantityBtn = document.getElementById('decrease-quantity');
                const increaseQuantityBtn = document.getElementById('increase-quantity');
                const selectedTicketsList = document.getElementById('selected-tickets-list');
                const noTicketsMessage = document.getElementById('no-tickets-message');
                const checkoutBtn = document.getElementById('checkout-btn');
                const clearSelectionBtn = document.getElementById('clear-selection-btn');
                const sectionInput = document.getElementById('section-input');
                const quantityInput = document.getElementById('quantity-input');
                const priceInput = document.getElementById('price-input');

                let selectedSection = null;
                let ticketPrice = 0;

                decreaseQuantityBtn.addEventListener('click', function() {
                    let quantity = parseInt(ticketQuantityInput.value);
                    if (quantity > 1) {
                        quantity--;
                        ticketQuantityInput.value = quantity;
                        quantityInput.value = quantity;
                        updateOrderSummary();
                    }
                });

                increaseQuantityBtn.addEventListener('click', function() {
                    let quantity = parseInt(ticketQuantityInput.value);
                    let maxAvailable = parseInt(selectedSectionAvailability.textContent);
                    if (quantity < 10 && quantity < maxAvailable) {
                        quantity++;
                        ticketQuantityInput.value = quantity;
                        quantityInput.value = quantity;
                        updateOrderSummary();
                    }
                });

                ticketQuantityInput.addEventListener('change', function() {
                    let quantity = parseInt(this.value);
                    let maxAvailable = parseInt(selectedSectionAvailability.textContent);

                    if (isNaN(quantity) || quantity < 1) {
                        quantity = 1;
                    } else if (quantity > 10) {
                        quantity = 10;
                    } else if (quantity > maxAvailable) {
                        quantity = maxAvailable;
                    }

                    this.value = quantity;
                    quantityInput.value = quantity;
                    updateOrderSummary();
                });

                stadiumSections.forEach(section => {
                    section.addEventListener('click', function() {
                        stadiumSections.forEach(s => s.classList.remove('selected'));

                        this.classList.add('selected');

                        const sectionName = this.getAttribute('data-section');
                        const sectionPrice = this.getAttribute('data-price');
                        const availableSeats = this.getAttribute('data-available');
                        const ticketsNumber = document.getElementById('tickets-number');

                        selectedSection = sectionName;
                        ticketPrice = parseFloat(sectionPrice);

                        selectedSectionName.textContent = sectionName;
                        selectedSectionPrice.textContent = '$' + sectionPrice;
                        selectedSectionAvailability.textContent = availableSeats;

                        sectionInput.value = sectionName;
                        priceInput.value = sectionPrice;

                        // Reset quantity to 1 when changing sections
                        ticketQuantityInput.value = 1;
                        quantityInput.value = 1;


                        ticketsNumber.classList.remove('hide-tickets-number');
                        console.log(sectionPrice, ticketPrice, sectionName);

                        // Update max attribute based on available tickets
                        ticketQuantityInput.max = Math.min(10, availableSeats);

                        updateOrderSummary();
                    });
                });

                function updateOrderSummary() {
                    const summaryTickets = document.getElementById('summary-tickets');
                    const summarySubtotal = document.getElementById('summary-subtotal');
                    const summaryFee = document.getElementById('summary-fee');
                    const summaryTotal = document.getElementById('summary-total');

                    if (!selectedSection) {
                        return;
                    }

                    const quantity = parseInt(ticketQuantityInput.value);
                    const subtotal = quantity * ticketPrice;
                    const serviceFee = subtotal * 0.1; // 10% service fee
                    const total = subtotal + serviceFee;

                    summaryTickets.textContent = quantity;
                    summarySubtotal.textContent = '$' + subtotal.toFixed(2);
                    summaryFee.textContent = '$' + serviceFee.toFixed(2);
                    summaryTotal.textContent = '$' + total.toFixed(2);

                    updateSelectedTicketsDisplay(quantity);

                    if (selectedSection && quantity > 0) {
                        checkoutBtn.disabled = false;
                        clearSelectionBtn.disabled = false;
                    } else {
                        checkoutBtn.disabled = true;
                        clearSelectionBtn.disabled = true;
                    }
                }

                function updateSelectedTicketsDisplay(quantity) {
                    if (!selectedSection) {
                        noTicketsMessage.style.display = 'block';
                        selectedTicketsList.innerHTML = noTicketsMessage.outerHTML;
                        return;
                    }

                    noTicketsMessage.style.display = 'none';

                    const ticketItem = document.createElement('div');
                    ticketItem.className = 'selected-ticket-item';
                    ticketItem.innerHTML = `
                    <div class="selected-ticket-info">
                        <div class="selected-ticket-section">${selectedSection} Section</div>
                        <div class="selected-ticket-quantity">${quantity} ticket${quantity > 1 ? 's' : ''}</div>
                    </div>
                    <div class="selected-ticket-price">$${(ticketPrice * quantity).toFixed(2)}</div>
                `;

                    selectedTicketsList.innerHTML = '';
                    selectedTicketsList.appendChild(ticketItem);
                }

                // Clear selection button
                clearSelectionBtn.addEventListener('click', function() {
                    stadiumSections.forEach(s => s.classList.remove('selected'));
                    selectedSection = null;
                    ticketPrice = 0;

                    selectedSectionName.textContent = 'Select a section';
                    selectedSectionPrice.textContent = '$0';
                    selectedSectionAvailability.textContent = '0';
                    ticketQuantityInput.value = 1;

                    sectionInput.value = '';
                    quantityInput.value = 1;
                    priceInput.value = 0;

                    noTicketsMessage.style.display = 'block';
                    selectedTicketsList.innerHTML = noTicketsMessage.outerHTML;

                    updateOrderSummary();
                });
            @endif
        });
    </script>
@endsection
