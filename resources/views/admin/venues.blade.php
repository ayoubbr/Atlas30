@extends('admin.layout')

@section('title', 'Venue Management - World Cup 2030')
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

        /* Venue Card Styles */
        .venue-cards-view {
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .venue-card {
            display: flex;
            flex-direction: column;
            padding: 0;
            overflow: hidden;
            border-left: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            background-color: white;
        }

        .venue-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .venue-image {
            height: 160px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .venue-image .status-badge {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .venue-content {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .venue-name {
            font-size: 1.2rem;
            margin-bottom: 5px;
            color: var(--secondary);
        }

        .venue-location,
        .venue-capacity,
        .venue-year,
        .venue-surface {
            font-size: 0.9rem;
            color: var(--gray-700);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .venue-location i,
        .venue-capacity i,
        .venue-year i,
        .venue-surface i {
            color: var(--primary);
            width: 16px;
        }

        .venue-description {
            margin-top: 10px;
            font-size: 0.9rem;
            color: var(--gray-600);
            line-height: 1.5;
        }

        .venue-features {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-top: 10px;
        }

        .feature-badge {
            background-color: var(--gray-100);
            color: var(--gray-700);
            font-size: 0.7rem;
            padding: 3px 8px;
            border-radius: 12px;
        }

        .venue-actions {
            padding: 15px 20px;
            border-top: 1px solid var(--gray-200);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* Table View Styles */
        .table-image {
            width: 100px;
            height: 60px;
            background-size: cover;
            background-position: center;
            border-radius: var(--border-radius);
        }

        .table-venue-name {
            font-weight: 600;
            color: var(--secondary);
        }

        .table-venue-year {
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        /* Status Badge Colors */
        .status-operational {
            background-color: var(--success-light);
            color: var(--success);
        }

        .status-under-construction {
            background-color: var(--warning-light);
            color: var(--warning);
        }

        .status-renovation {
            background-color: var(--info-light);
            color: var(--info);
        }

        .status-planned {
            background-color: var(--gray-200);
            color: var(--gray-700);
        }

        /* Checkbox Group */
        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 5px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkbox-item input[type="checkbox"] {
            width: 16px;
            height: 16px;
        }

        /* Form Text */
        .form-text {
            font-size: 0.8rem;
            color: var(--gray-600);
            margin-top: 5px;
        }

        /* Responsive Styles */
        @media (max-width: 1200px) {
            .venue-cards-view {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .venue-cards-view {
                grid-template-columns: 1fr;
            }

            .table-image {
                width: 80px;
                height: 50px;
            }
        }
    </style>
@endsection

@section('content')
    <main class="admin-main">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <h2 class="page-header-title">Venue Management</h2>
                <p class="page-header-description">Create, edit, and manage all World Cup 2030 venues and stadiums
                </p>
            </div>
            <div class="page-header-actions">
                <button class="btn btn-primary" id="add-venue-btn">
                    <i class="fas fa-plus"></i> Add New Venue
                </button>
            </div>
        </div>

        <!-- Venue Filters -->
        <div class="match-filters">
            <div class="filter-group">
                <label for="filter-country">Country:</label>
                <select id="filter-country" class="filter-select">
                    <option value="all">All Countries</option>
                    <option value="brazil">Brazil</option>
                    <option value="spain">Spain</option>
                    <option value="france">France</option>
                    <option value="england">England</option>
                    <option value="germany">Germany</option>
                    <option value="italy">Italy</option>
                    <option value="argentina">Argentina</option>
                    <option value="uruguay">Uruguay</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="filter-capacity">Capacity:</label>
                <select id="filter-capacity" class="filter-select">
                    <option value="all">All Capacities</option>
                    <option value="small">Small (< 40,000)</option>
                    <option value="medium">Medium (40,000 - 60,000)</option>
                    <option value="large">Large (60,000 - 80,000)</option>
                    <option value="xlarge">Extra Large (> 80,000)</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="filter-status">Status:</label>
                <select id="filter-status" class="filter-select">
                    <option value="all">All Statuses</option>
                    <option value="operational">Operational</option>
                    <option value="under-construction">Under Construction</option>
                    <option value="renovation">Under Renovation</option>
                    <option value="planned">Planned</option>
                </select>
            </div>

            <div class="filter-group">
                <button class="btn btn-outline" id="reset-filters">
                    <i class="fas fa-undo"></i> Reset Filters
                </button>
            </div>
        </div>

        <!-- Venue List -->
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
            <div class="venue-cards-view" id="venue-cards-view">
                <!-- Cards will be dynamically generated here -->
            </div>

            <!-- Table View (hidden by default) -->
            <div class="venue-table-view" id="venue-table-view" style="display: none;">
                <table class="match-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Capacity</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="venue-table-body">
                        <!-- Table rows will be dynamically generated here -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <button class="pagination-btn" id="prev-page" disabled>
                    <i class="fas fa-chevron-left"></i> Previous
                </button>
                <div class="pagination-info">
                    Page <span id="current-page">1</span> of <span id="total-pages">1</span>
                </div>
                <button class="pagination-btn" id="next-page">
                    Next <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </main>
@endsection

@section('modal')
    <!-- Add/Edit Venue Modal -->
    <div class="modal" id="venue-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title">Add New Venue</h3>
                <button class="modal-close" id="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="venue-form">
                    <input type="hidden" id="venue-id">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="venue-name">Venue Name</label>
                            <input type="text" id="venue-name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="venue-code">Venue Code</label>
                            <input type="text" id="venue-code" class="form-control" required
                                placeholder="e.g. rio, madrid">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="venue-city">City</label>
                            <input type="text" id="venue-city" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="venue-country">Country</label>
                            <select id="venue-country" class="form-control" required>
                                <option value="">Select Country</option>
                                <option value="brazil">Brazil</option>
                                <option value="spain">Spain</option>
                                <option value="france">France</option>
                                <option value="england">England</option>
                                <option value="germany">Germany</option>
                                <option value="italy">Italy</option>
                                <option value="argentina">Argentina</option>
                                <option value="uruguay">Uruguay</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="venue-capacity">Capacity</label>
                            <input type="number" id="venue-capacity" class="form-control" required min="1">
                        </div>
                        <div class="form-group">
                            <label for="venue-status">Status</label>
                            <select id="venue-status" class="form-control" required>
                                <option value="operational">Operational</option>
                                <option value="under-construction">Under Construction</option>
                                <option value="renovation">Under Renovation</option>
                                <option value="planned">Planned</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="venue-image">Image URL</label>
                        <input type="url" id="venue-image" class="form-control"
                            placeholder="https://example.com/image.jpg">
                        <small class="form-text">Leave empty to use a placeholder image</small>
                    </div>

                    <div class="form-group">
                        <label for="venue-description">Description</label>
                        <textarea id="venue-description" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="venue-year">Year Built</label>
                            <input type="number" id="venue-year" class="form-control" min="1900" max="2030">
                        </div>
                        <div class="form-group">
                            <label for="venue-surface">Playing Surface</label>
                            <select id="venue-surface" class="form-control">
                                <option value="">Select Surface Type</option>
                                <option value="natural">Natural Grass</option>
                                <option value="artificial">Artificial Turf</option>
                                <option value="hybrid">Hybrid</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="venue-features">Features</label>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <input type="checkbox" id="feature-roof" class="feature-checkbox">
                                <label for="feature-roof">Retractable Roof</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="feature-vip" class="feature-checkbox">
                                <label for="feature-vip">VIP Boxes</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="feature-parking" class="feature-checkbox">
                                <label for="feature-parking">Parking Facilities</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="feature-accessible" class="feature-checkbox">
                                <label for="feature-accessible">Accessibility Features</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="feature-screens" class="feature-checkbox">
                                <label for="feature-screens">Giant Screens</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" id="cancel-btn">Cancel</button>
                <button class="btn btn-primary" id="save-venue-btn">Save Venue</button>
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
                <p>Are you sure you want to delete this venue? This action cannot be undone.</p>
                <input type="hidden" id="delete-venue-id">
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" id="cancel-delete-btn">Cancel</button>
                <button class="btn btn-danger" id="confirm-delete-btn">Delete Venue</button>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DOM Elements
            const menuToggle = document.getElementById('menu-toggle');
            const sidebar = document.getElementById('sidebar');
            const addVenueBtn = document.getElementById('add-venue-btn');
            const venueModal = document.getElementById('venue-modal');
            const modalClose = document.getElementById('modal-close');
            const cancelBtn = document.getElementById('cancel-btn');
            const saveVenueBtn = document.getElementById('save-venue-btn');
            const deleteModal = document.getElementById('delete-modal');
            const deleteModalClose = document.getElementById('delete-modal-close');
            const cancelDeleteBtn = document.getElementById('cancel-delete-btn');
            const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
            const venueForm = document.getElementById('venue-form');
            const venueCardsView = document.getElementById('venue-cards-view');
            const venueTableView = document.getElementById('venue-table-view');
            const venueTableBody = document.getElementById('venue-table-body');
            const viewBtns = document.querySelectorAll('.view-btn');
            const filterCountry = document.getElementById('filter-country');
            const filterCapacity = document.getElementById('filter-capacity');
            const filterStatus = document.getElementById('filter-status');
            const resetFiltersBtn = document.getElementById('reset-filters');
            const prevPageBtn = document.getElementById('prev-page');
            const nextPageBtn = document.getElementById('next-page');
            const currentPageSpan = document.getElementById('current-page');
            const totalPagesSpan = document.getElementById('total-pages');
            const searchInput = document.querySelector('.search-input');

            // State
            let venues = [];
            let currentPage = 1;
            let itemsPerPage = 8;
            let currentView = 'card';
            let currentFilters = {
                country: 'all',
                capacity: 'all',
                status: 'all',
                search: ''
            };

            // Initialize with sample data
            initSampleData();

            // Event Listeners
            if (menuToggle) {
                menuToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }

            addVenueBtn.addEventListener('click', function() {
                openAddVenueModal();
            });

            modalClose.addEventListener('click', function() {
                closeVenueModal();
            });

            cancelBtn.addEventListener('click', function() {
                closeVenueModal();
            });

            deleteModalClose.addEventListener('click', function() {
                closeDeleteModal();
            });

            cancelDeleteBtn.addEventListener('click', function() {
                closeDeleteModal();
            });

            saveVenueBtn.addEventListener('click', function() {
                saveVenue();
            });

            confirmDeleteBtn.addEventListener('click', function() {
                deleteVenue();
            });

            viewBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const view = this.getAttribute('data-view');
                    changeView(view);
                });
            });

            filterCountry.addEventListener('change', function() {
                currentFilters.country = this.value;
                currentPage = 1;
                renderVenues();
            });

            filterCapacity.addEventListener('change', function() {
                currentFilters.capacity = this.value;
                currentPage = 1;
                renderVenues();
            });

            filterStatus.addEventListener('change', function() {
                currentFilters.status = this.value;
                currentPage = 1;
                renderVenues();
            });

            resetFiltersBtn.addEventListener('click', function() {
                resetFilters();
            });

            prevPageBtn.addEventListener('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    renderVenues();
                }
            });

            nextPageBtn.addEventListener('click', function() {
                const totalPages = Math.ceil(getFilteredVenues().length / itemsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    renderVenues();
                }
            });

            searchInput.addEventListener('input', function() {
                currentFilters.search = this.value.toLowerCase();
                currentPage = 1;
                renderVenues();
            });

            // Functions
            function initSampleData() {
                // Check if we already have data in localStorage
                const storedVenues = localStorage.getItem('worldCupVenues');
                if (storedVenues) {
                    venues = JSON.parse(storedVenues);
                    renderVenues();
                    return;
                }

                // Sample venue data
                venues = [{
                        id: 1,
                        name: 'Maracanã Stadium',
                        code: 'rio',
                        city: 'Rio de Janeiro',
                        country: 'brazil',
                        capacity: 78838,
                        status: 'operational',
                        image: 'https://via.placeholder.com/800x500/3498db/ffffff?text=Maracana+Stadium',
                        description: 'One of the most famous stadiums in the world, Maracanã has hosted two World Cup finals.',
                        yearBuilt: 1950,
                        surface: 'natural',
                        features: ['vip', 'parking', 'accessible', 'screens']
                    },
                    {
                        id: 2,
                        name: 'Santiago Bernabéu',
                        code: 'madrid',
                        city: 'Madrid',
                        country: 'spain',
                        capacity: 81044,
                        status: 'renovation',
                        image: 'https://via.placeholder.com/800x500/f39c12/ffffff?text=Santiago+Bernabeu',
                        description: 'Home of Real Madrid, this iconic stadium is undergoing major renovations to be ready for the World Cup.',
                        yearBuilt: 1947,
                        surface: 'natural',
                        features: ['roof', 'vip', 'parking', 'accessible', 'screens']
                    },
                    {
                        id: 3,
                        name: 'Stade de France',
                        code: 'paris',
                        city: 'Paris',
                        country: 'france',
                        capacity: 80698,
                        status: 'operational',
                        image: 'https://via.placeholder.com/800x500/9b59b6/ffffff?text=Stade+de+France',
                        description: 'The national stadium of France, it hosted the 1998 World Cup final.',
                        yearBuilt: 1998,
                        surface: 'hybrid',
                        features: ['vip', 'parking', 'accessible', 'screens']
                    },
                    {
                        id: 4,
                        name: 'Wembley Stadium',
                        code: 'london',
                        city: 'London',
                        country: 'england',
                        capacity: 90000,
                        status: 'operational',
                        image: 'https://via.placeholder.com/800x500/34495e/ffffff?text=Wembley+Stadium',
                        description: 'The largest stadium in the UK and home of the England national football team.',
                        yearBuilt: 2007,
                        surface: 'hybrid',
                        features: ['roof', 'vip', 'parking', 'accessible', 'screens']
                    },
                    {
                        id: 5,
                        name: 'Allianz Arena',
                        code: 'munich',
                        city: 'Munich',
                        country: 'germany',
                        capacity: 75000,
                        status: 'operational',
                        image: 'https://via.placeholder.com/800x500/e74c3c/ffffff?text=Allianz+Arena',
                        description: 'Known for its unique exterior of inflated ETFE plastic panels, it can change color for different events.',
                        yearBuilt: 2005,
                        surface: 'natural',
                        features: ['roof', 'vip', 'parking', 'accessible', 'screens']
                    },
                    {
                        id: 6,
                        name: 'Olympiastadion',
                        code: 'berlin',
                        city: 'Berlin',
                        country: 'germany',
                        capacity: 74475,
                        status: 'operational',
                        image: 'https://via.placeholder.com/800x500/2ecc71/ffffff?text=Olympiastadion',
                        description: 'Built for the 1936 Summer Olympics, it has been renovated for modern football events.',
                        yearBuilt: 1936,
                        surface: 'natural',
                        features: ['vip', 'parking', 'accessible', 'screens']
                    },
                    {
                        id: 7,
                        name: 'Estadio Monumental',
                        code: 'buenos',
                        city: 'Buenos Aires',
                        country: 'argentina',
                        capacity: 72000,
                        status: 'renovation',
                        image: 'https://via.placeholder.com/800x500/1abc9c/ffffff?text=Estadio+Monumental',
                        description: 'The largest stadium in Argentina and home to River Plate.',
                        yearBuilt: 1938,
                        surface: 'natural',
                        features: ['vip', 'parking', 'accessible']
                    },
                    {
                        id: 8,
                        name: 'Estadio Centenario',
                        code: 'montevideo',
                        city: 'Montevideo',
                        country: 'uruguay',
                        capacity: 60235,
                        status: 'renovation',
                        image: 'https://via.placeholder.com/800x500/3498db/ffffff?text=Estadio+Centenario',
                        description: 'A historic stadium built for the first FIFA World Cup in 1930.',
                        yearBuilt: 1930,
                        surface: 'natural',
                        features: ['parking', 'accessible']
                    }
                ];

                // Save to localStorage
                saveVenuesToStorage();
                renderVenues();
            }

            function saveVenuesToStorage() {
                localStorage.setItem('worldCupVenues', JSON.stringify(venues));
            }

            function renderVenues() {
                const filteredVenues = getFilteredVenues();
                const totalPages = Math.ceil(filteredVenues.length / itemsPerPage);

                // Update pagination info
                currentPageSpan.textContent = currentPage;
                totalPagesSpan.textContent = totalPages;

                // Enable/disable pagination buttons
                prevPageBtn.disabled = currentPage <= 1;
                nextPageBtn.disabled = currentPage >= totalPages;

                // Get current page venues
                const startIndex = (currentPage - 1) * itemsPerPage;
                const endIndex = startIndex + itemsPerPage;
                const currentVenues = filteredVenues.slice(startIndex, endIndex);

                // Render based on current view
                if (currentView === 'card') {
                    renderCardView(currentVenues);
                } else {
                    renderTableView(currentVenues);
                }
            }

            function getFilteredVenues() {
                return venues.filter(venue => {
                    // Apply filters
                    if (currentFilters.country !== 'all' && venue.country !== currentFilters.country)
                        return false;

                    // Capacity filter
                    if (currentFilters.capacity !== 'all') {
                        const capacity = venue.capacity;
                        if (currentFilters.capacity === 'small' && capacity >= 40000) return false;
                        if (currentFilters.capacity === 'medium' && (capacity < 40000 || capacity > 60000))
                            return false;
                        if (currentFilters.capacity === 'large' && (capacity < 60000 || capacity > 80000))
                            return false;
                        if (currentFilters.capacity === 'xlarge' && capacity <= 80000) return false;
                    }

                    // Status filter
                    if (currentFilters.status !== 'all' && venue.status !== currentFilters.status)
                        return false;

                    // Search filter
                    if (currentFilters.search) {
                        const searchTerm = currentFilters.search.toLowerCase();
                        const venueName = venue.name.toLowerCase();
                        const venueCity = venue.city.toLowerCase();
                        const venueCountry = getCountryName(venue.country).toLowerCase();

                        if (!venueName.includes(searchTerm) &&
                            !venueCity.includes(searchTerm) &&
                            !venueCountry.includes(searchTerm)) {
                            return false;
                        }
                    }

                    return true;
                });
            }

            function renderCardView(venues) {
                venueCardsView.innerHTML = '';

                if (venues.length === 0) {
                    venueCardsView.innerHTML =
                        '<div class="no-venues">No venues found. Try adjusting your filters.</div>';
                    return;
                }

                venues.forEach(venue => {
                    const venueCard = document.createElement('div');
                    venueCard.className = 'match-card venue-card';

                    // Get features as formatted string
                    const featuresList = venue.features && venue.features.length > 0 ?
                        `<div class="venue-features">
                ${venue.features.map(feature => `<span class="feature-badge">${getFeatureName(feature)}</span>`).join('')}
              </div>` :
                        '';

                    venueCard.innerHTML = `
            <div class="venue-image" style="background-image: url('${venue.image || `https://via.placeholder.com/400x200/3498db/ffffff?text=${venue.name}`}')">
                <div class="status-badge status-${venue.status}">${getStatusName(venue.status)}</div>
            </div>
            <div class="venue-content">
                <h3 class="venue-name">${venue.name}</h3>
                <div class="venue-location">
                    <i class="fas fa-map-marker-alt"></i> ${venue.city}, ${getCountryName(venue.country)}
                </div>
                <div class="venue-capacity">
                    <i class="fas fa-users"></i> Capacity: ${venue.capacity.toLocaleString()} seats
                </div>
                ${venue.yearBuilt ? `<div class="venue-year">
                                                            <i class="fas fa-calendar-alt"></i> Built: ${venue.yearBuilt}
                                                        </div>` : ''}
                ${venue.surface ? `<div class="venue-surface">
                                                            <i class="fas fa-leaf"></i> Surface: ${getSurfaceName(venue.surface)}
                                                        </div>` : ''}
                ${featuresList}
                ${venue.description ? `<div class="venue-description">${truncateText(venue.description, 100)}</div>` : ''}
            </div>
            <div class="venue-actions">
                <button class="btn btn-sm btn-outline edit-venue-btn" data-id="${venue.id}">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-sm btn-danger delete-venue-btn" data-id="${venue.id}">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        `;

                    venueCardsView.appendChild(venueCard);

                    // Add event listeners to the buttons
                    const editBtn = venueCard.querySelector('.edit-venue-btn');
                    const deleteBtn = venueCard.querySelector('.delete-venue-btn');

                    editBtn.addEventListener('click', function() {
                        const venueId = parseInt(this.getAttribute('data-id'));
                        openEditVenueModal(venueId);
                    });

                    deleteBtn.addEventListener('click', function() {
                        const venueId = parseInt(this.getAttribute('data-id'));
                        openDeleteModal(venueId);
                    });
                });
            }

            function renderTableView(venues) {
                venueTableBody.innerHTML = '';

                if (venues.length === 0) {
                    venueTableBody.innerHTML = `
            <tr>
                <td colspan="6" style="text-align: center; padding: 30px;">
                    No venues found. Try adjusting your filters.
                </td>
            </tr>
        `;
                    return;
                }

                venues.forEach(venue => {
                    const venueRow = document.createElement('tr');

                    venueRow.innerHTML = `
            <td>
                <div class="table-image" style="background-image: url('${venue.image || `https://via.placeholder.com/100x60/3498db/ffffff?text=${venue.name}`}')"></div>
            </td>
            <td>
                <div class="table-venue-name">${venue.name}</div>
                ${venue.yearBuilt ? `<div class="table-venue-year">Built: ${venue.yearBuilt}</div>` : ''}
            </td>
            <td>
                ${venue.city}, ${getCountryName(venue.country)}
            </td>
            <td>
                ${venue.capacity.toLocaleString()} seats
            </td>
            <td>
                <span class="status-badge status-${venue.status}">${getStatusName(venue.status)}</span>
            </td>
            <td>
                <div class="venue-actions">
                    <button class="btn btn-sm btn-outline edit-venue-btn" data-id="${venue.id}">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-danger delete-venue-btn" data-id="${venue.id}">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </td>
        `;

                    venueTableBody.appendChild(venueRow);

                    // Add event listeners to the buttons
                    const editBtn = venueRow.querySelector('.edit-venue-btn');
                    const deleteBtn = venueRow.querySelector('.delete-venue-btn');

                    editBtn.addEventListener('click', function() {
                        const venueId = parseInt(this.getAttribute('data-id'));
                        openEditVenueModal(venueId);
                    });

                    deleteBtn.addEventListener('click', function() {
                        const venueId = parseInt(this.getAttribute('data-id'));
                        openDeleteModal(venueId);
                    });
                });
            }

            function changeView(view) {
                currentView = view;

                // Update active button
                viewBtns.forEach(btn => {
                    if (btn.getAttribute('data-view') === view) {
                        btn.classList.add('active');
                    } else {
                        btn.classList.remove('active');
                    }
                });

                // Show/hide views
                if (view === 'card') {
                    venueCardsView.style.display = 'grid';
                    venueTableView.style.display = 'none';
                } else {
                    venueCardsView.style.display = 'none';
                    venueTableView.style.display = 'block';
                }

                renderVenues();
            }

            function openAddVenueModal() {
                // Reset form
                venueForm.reset();
                document.getElementById('venue-id').value = '';
                document.getElementById('modal-title').textContent = 'Add New Venue';

                // Reset checkboxes
                document.querySelectorAll('.feature-checkbox').forEach(checkbox => {
                    checkbox.checked = false;
                });

                // Show modal
                venueModal.classList.add('show');
            }

            function openEditVenueModal(venueId) {
                const venue = venues.find(v => v.id === venueId);
                if (!venue) return;

                // Set form values
                document.getElementById('venue-id').value = venue.id;
                document.getElementById('venue-name').value = venue.name;
                document.getElementById('venue-code').value = venue.code;
                document.getElementById('venue-city').value = venue.city;
                document.getElementById('venue-country').value = venue.country;
                document.getElementById('venue-capacity').value = venue.capacity;
                document.getElementById('venue-status').value = venue.status;
                document.getElementById('venue-image').value = venue.image || '';
                document.getElementById('venue-description').value = venue.description || '';
                document.getElementById('venue-year').value = venue.yearBuilt || '';
                document.getElementById('venue-surface').value = venue.surface || '';

                // Set checkboxes
                document.querySelectorAll('.feature-checkbox').forEach(checkbox => {
                    const featureId = checkbox.id.replace('feature-', '');
                    checkbox.checked = venue.features && venue.features.includes(featureId);
                });

                // Update modal title
                document.getElementById('modal-title').textContent = 'Edit Venue';

                // Show modal
                venueModal.classList.add('show');
            }

            function closeVenueModal() {
                venueModal.classList.remove('show');
            }

            function openDeleteModal(venueId) {
                document.getElementById('delete-venue-id').value = venueId;
                deleteModal.classList.add('show');
            }

            function closeDeleteModal() {
                deleteModal.classList.remove('show');
            }

            function saveVenue() {
                // Validate form
                if (!venueForm.checkValidity()) {
                    venueForm.reportValidity();
                    return;
                }

                // Get form values
                const venueId = document.getElementById('venue-id').value;
                const name = document.getElementById('venue-name').value;
                const code = document.getElementById('venue-code').value;
                const city = document.getElementById('venue-city').value;
                const country = document.getElementById('venue-country').value;
                const capacity = parseInt(document.getElementById('venue-capacity').value);
                const status = document.getElementById('venue-status').value;
                const image = document.getElementById('venue-image').value;
                const description = document.getElementById('venue-description').value;
                const yearBuilt = document.getElementById('venue-year').value ? parseInt(document.getElementById(
                    'venue-year').value) : null;
                const surface = document.getElementById('venue-surface').value;

                // Get selected features
                const features = [];
                document.querySelectorAll('.feature-checkbox:checked').forEach(checkbox => {
                    features.push(checkbox.id.replace('feature-', ''));
                });

                if (venueId) {
                    // Update existing venue
                    const index = venues.findIndex(v => v.id === parseInt(venueId));
                    if (index !== -1) {
                        venues[index] = {
                            ...venues[index],
                            name,
                            code,
                            city,
                            country,
                            capacity,
                            status,
                            image,
                            description,
                            yearBuilt,
                            surface,
                            features
                        };
                    }
                } else {
                    // Add new venue
                    const newId = venues.length > 0 ? Math.max(...venues.map(v => v.id)) + 1 : 1;
                    venues.push({
                        id: newId,
                        name,
                        code,
                        city,
                        country,
                        capacity,
                        status,
                        image,
                        description,
                        yearBuilt,
                        surface,
                        features
                    });
                }

                // Save to localStorage and render
                saveVenuesToStorage();
                renderVenues();
                closeVenueModal();
            }

            function deleteVenue() {
                const venueId = parseInt(document.getElementById('delete-venue-id').value);
                venues = venues.filter(v => v.id !== venueId);

                // Save to localStorage and render
                saveVenuesToStorage();
                renderVenues();
                closeDeleteModal();
            }

            function resetFilters() {
                filterCountry.value = 'all';
                filterCapacity.value = 'all';
                filterStatus.value = 'all';
                searchInput.value = '';

                currentFilters = {
                    country: 'all',
                    capacity: 'all',
                    status: 'all',
                    search: ''
                };

                currentPage = 1;
                renderVenues();
            }

            // Helper functions
            function getCountryName(countryCode) {
                const countries = {
                    'brazil': 'Brazil',
                    'spain': 'Spain',
                    'france': 'France',
                    'england': 'England',
                    'germany': 'Germany',
                    'italy': 'Italy',
                    'argentina': 'Argentina',
                    'uruguay': 'Uruguay'
                };
                return countries[countryCode] || countryCode;
            }

            function getStatusName(statusCode) {
                const statuses = {
                    'operational': 'Operational',
                    'under-construction': 'Under Construction',
                    'renovation': 'Under Renovation',
                    'planned': 'Planned'
                };
                return statuses[statusCode] || statusCode;
            }

            function getSurfaceName(surfaceCode) {
                const surfaces = {
                    'natural': 'Natural Grass',
                    'artificial': 'Artificial Turf',
                    'hybrid': 'Hybrid Surface'
                };
                return surfaces[surfaceCode] || surfaceCode;
            }

            function getFeatureName(featureCode) {
                const features = {
                    'roof': 'Retractable Roof',
                    'vip': 'VIP Boxes',
                    'parking': 'Parking',
                    'accessible': 'Accessibility',
                    'screens': 'Giant Screens'
                };
                return features[featureCode] || featureCode;
            }

            function truncateText(text, maxLength) {
                if (!text) return '';
                if (text.length <= maxLength) return text;
                return text.substring(0, maxLength) + '...';
            }
        });
    </script>
@endsection
