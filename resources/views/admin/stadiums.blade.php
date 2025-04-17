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
                <form id="venue-form" method="POST"  enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="venue-id">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="venue-name">Venue Name</label>
                            <input type="text" id="venue-name" class="form-control" required name="name">
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="venue-city">City</label>
                            <input type="text" id="venue-city" class="form-control" required name="city">
                        </div>
                        <div class="form-group">
                            <label for="venue-capacity">Capacity</label>
                            <input type="number" id="venue-capacity" class="form-control" required min="1"
                                name="capacity">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="venue-city" for="stadiumImage">Stadium Image</label>
                            <input type="file" class="venue-form-control" id="stadiumImage" name="image"
                                accept="image/*" required>
                            <img id="imagePreview" src="#" alt="Image Preview"
                                style="display: none; width: 80px; margin-top: 10px;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline" type="button" id="cancel-btn">Cancel</button>
                        <button class="btn btn-primary" type="submit" id="save-venue-btn">Save Venue</button>
                    </div>
                </form>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                document.getElementById('venue-id').value = '';
                document.getElementById('modal-title').textContent = 'Add New Venue';


                venueForm.action = "{{ route('admin.stadiums.store') }}";
                const methodInput = venueForm.querySelector('input[name="_method"]');

                if (methodInput) methodInput.remove();
                const imagePreview = document.getElementById('imagePreview');

                if (imagePreview) {
                    imagePreview.style.display = 'none';
                    imagePreview.src = '#';
                }
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
                venueForm.reset();
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

            function truncateText(text, maxLength) {
                if (!text) return '';
                if (text.length <= maxLength) return text;
                return text.substring(0, maxLength) + '...';
            }
        });
    </script>
@endsection
