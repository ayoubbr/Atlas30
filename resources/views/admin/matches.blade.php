@extends('admin.layout')

@section('title', 'Match Management - World Cup 2030')
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
    </style>
@endsection

@section('content')

    <!-- Main Content -->
    <main class="admin-main">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <h2 class="page-header-title">Match Management</h2>
                <p class="page-header-description">Create, edit, and manage all World Cup 2030 matches</p>
            </div>
            <div class="page-header-actions">
                <button class="btn btn-primary" id="add-match-btn">
                    <i class="fas fa-plus"></i> Add New Match
                </button>
            </div>
        </div>

        <!-- Match Filters -->
        <div class="match-filters">
            <div class="filter-group">
                <label for="filter-stage">Stage:</label>
                <select id="filter-stage" class="filter-select">
                    <option value="all">All Stages</option>
                    <option value="group">Group Stage</option>
                    <option value="round16">Round of 16</option>
                    <option value="quarter">Quarter Finals</option>
                    <option value="semi">Semi Finals</option>
                    <option value="final">Final</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="filter-team">Team:</label>
                <select id="filter-team" class="filter-select">
                    <option value="all">All Teams</option>
                    <option value="brazil">Brazil</option>
                    <option value="germany">Germany</option>
                    <option value="spain">Spain</option>
                    <option value="france">France</option>
                    <option value="england">England</option>
                    <option value="argentina">Argentina</option>
                    <option value="portugal">Portugal</option>
                    <option value="netherlands">Netherlands</option>
                    <option value="italy">Italy</option>
                    <option value="belgium">Belgium</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="filter-venue">Venue:</label>
                <select id="filter-venue" class="filter-select">
                    <option value="all">All Venues</option>
                    <option value="rio">Rio Stadium, Brazil</option>
                    <option value="madrid">Madrid Stadium, Spain</option>
                    <option value="paris">Paris Stadium, France</option>
                    <option value="london">London Stadium, England</option>
                    <option value="berlin">Berlin Stadium, Germany</option>
                    <option value="rome">Rome Stadium, Italy</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="filter-status">Status:</label>
                <select id="filter-status" class="filter-select">
                    <option value="all">All Statuses</option>
                    <option value="scheduled">Scheduled</option>
                    <option value="live">Live</option>
                    <option value="completed">Completed</option>
                    <option value="postponed">Postponed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <div class="filter-group">
                <button class="btn btn-outline" id="reset-filters">
                    <i class="fas fa-undo"></i> Reset Filters
                </button>
            </div>
        </div>

        <!-- Match List -->
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
            <div class="match-cards-view" id="match-cards-view">
                <!-- Cards will be dynamically generated here -->
            </div>

            <!-- Table View (hidden by default) -->
            <div class="match-table-view" id="match-table-view" style="display: none;">
                <table class="match-table">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Teams</th>
                            <th>Venue</th>
                            <th>Stage</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="match-table-body">
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


    <!-- Add/Edit Match Modal -->
    <div class="modal" id="match-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title">Add New Match</h3>
                <button class="modal-close" id="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="match-form">
                    <input type="hidden" id="match-id">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="match-date">Date</label>
                            <input type="date" id="match-date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="match-time">Time (GMT)</label>
                            <input type="time" id="match-time" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="team1">Team 1</label>
                            <select id="team1" class="form-control" required>
                                <option value="">Select Team</option>
                                <option value="brazil">Brazil</option>
                                <option value="germany">Germany</option>
                                <option value="spain">Spain</option>
                                <option value="france">France</option>
                                <option value="england">England</option>
                                <option value="argentina">Argentina</option>
                                <option value="portugal">Portugal</option>
                                <option value="netherlands">Netherlands</option>
                                <option value="italy">Italy</option>
                                <option value="belgium">Belgium</option>
                                <option value="croatia">Croatia</option>
                                <option value="uruguay">Uruguay</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="team2">Team 2</label>
                            <select id="team2" class="form-control" required>
                                <option value="">Select Team</option>
                                <option value="brazil">Brazil</option>
                                <option value="germany">Germany</option>
                                <option value="spain">Spain</option>
                                <option value="france">France</option>
                                <option value="england">England</option>
                                <option value="argentina">Argentina</option>
                                <option value="portugal">Portugal</option>
                                <option value="netherlands">Netherlands</option>
                                <option value="italy">Italy</option>
                                <option value="belgium">Belgium</option>
                                <option value="croatia">Croatia</option>
                                <option value="uruguay">Uruguay</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="venue">Venue</label>
                        <select id="venue" class="form-control" required>
                            <option value="">Select Venue</option>
                            <option value="rio">Rio Stadium, Brazil</option>
                            <option value="madrid">Madrid Stadium, Spain</option>
                            <option value="paris">Paris Stadium, France</option>
                            <option value="london">London Stadium, England</option>
                            <option value="berlin">Berlin Stadium, Germany</option>
                            <option value="rome">Rome Stadium, Italy</option>
                            <option value="buenos">Buenos Aires Stadium, Argentina</option>
                            <option value="montevideo">Montevideo Stadium, Uruguay</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="stage">Stage</label>
                            <select id="stage" class="form-control" required>
                                <option value="">Select Stage</option>
                                <option value="group">Group Stage</option>
                                <option value="round16">Round of 16</option>
                                <option value="quarter">Quarter Finals</option>
                                <option value="semi">Semi Finals</option>
                                <option value="final">Final</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" class="form-control" required>
                                <option value="scheduled">Scheduled</option>
                                <option value="live">Live</option>
                                <option value="completed">Completed</option>
                                <option value="postponed">Postponed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row score-inputs" style="display: none;">
                        <div class="form-group">
                            <label for="team1-score">Team 1 Score</label>
                            <input type="number" id="team1-score" class="form-control" min="0" value="0">
                        </div>
                        <div class="form-group">
                            <label for="team2-score">Team 2 Score</label>
                            <input type="number" id="team2-score" class="form-control" min="0" value="0">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea id="notes" class="form-control" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" id="cancel-btn">Cancel</button>
                <button class="btn btn-primary" id="save-match-btn">Save Match</button>
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
                <p>Are you sure you want to delete this match? This action cannot be undone.</p>
                <input type="hidden" id="delete-match-id">
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" id="cancel-delete-btn">Cancel</button>
                <button class="btn btn-danger" id="confirm-delete-btn">Delete Match</button>
            </div>
        </div>
    </div>
@endsection

@section('js')

    <!-- JavaScript -->
    <script src="js/match-management.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DOM Elements
            const menuToggle = document.getElementById('menu-toggle');
            const sidebar = document.getElementById('sidebar');
            const addMatchBtn = document.getElementById('add-match-btn');
            const matchModal = document.getElementById('match-modal');
            const modalClose = document.getElementById('modal-close');
            const cancelBtn = document.getElementById('cancel-btn');
            const saveMatchBtn = document.getElementById('save-match-btn');
            const deleteModal = document.getElementById('delete-modal');
            const deleteModalClose = document.getElementById('delete-modal-close');
            const cancelDeleteBtn = document.getElementById('cancel-delete-btn');
            const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
            const matchForm = document.getElementById('match-form');
            const matchCardsView = document.getElementById('match-cards-view');
            const matchTableView = document.getElementById('match-table-view');
            const matchTableBody = document.getElementById('match-table-body');
            const viewBtns = document.querySelectorAll('.view-btn');
            const statusSelect = document.getElementById('status');
            const scoreInputs = document.querySelector('.score-inputs');
            const filterStage = document.getElementById('filter-stage');
            const filterTeam = document.getElementById('filter-team');
            const filterVenue = document.getElementById('filter-venue');
            const filterStatus = document.getElementById('filter-status');
            const resetFiltersBtn = document.getElementById('reset-filters');
            const prevPageBtn = document.getElementById('prev-page');
            const nextPageBtn = document.getElementById('next-page');
            const currentPageSpan = document.getElementById('current-page');
            const totalPagesSpan = document.getElementById('total-pages');
            const searchInput = document.querySelector('.search-input');

            // State
            let matches = [];
            let currentPage = 1;
            let itemsPerPage = 8;
            let currentView = 'card';
            let currentFilters = {
                stage: 'all',
                team: 'all',
                venue: 'all',
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

            addMatchBtn.addEventListener('click', function() {
                openAddMatchModal();
            });

            modalClose.addEventListener('click', function() {
                closeMatchModal();
            });

            cancelBtn.addEventListener('click', function() {
                closeMatchModal();
            });

            deleteModalClose.addEventListener('click', function() {
                closeDeleteModal();
            });

            cancelDeleteBtn.addEventListener('click', function() {
                closeDeleteModal();
            });

            saveMatchBtn.addEventListener('click', function() {
                saveMatch();
            });

            confirmDeleteBtn.addEventListener('click', function() {
                deleteMatch();
            });

            viewBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const view = this.getAttribute('data-view');
                    changeView(view);
                });
            });

            statusSelect.addEventListener('change', function() {
                toggleScoreInputs();
            });

            filterStage.addEventListener('change', function() {
                currentFilters.stage = this.value;
                currentPage = 1;
                renderMatches();
            });

            filterTeam.addEventListener('change', function() {
                currentFilters.team = this.value;
                currentPage = 1;
                renderMatches();
            });

            filterVenue.addEventListener('change', function() {
                currentFilters.venue = this.value;
                currentPage = 1;
                renderMatches();
            });

            filterStatus.addEventListener('change', function() {
                currentFilters.status = this.value;
                currentPage = 1;
                renderMatches();
            });

            resetFiltersBtn.addEventListener('click', function() {
                resetFilters();
            });

            prevPageBtn.addEventListener('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    renderMatches();
                }
            });

            nextPageBtn.addEventListener('click', function() {
                const totalPages = Math.ceil(getFilteredMatches().length / itemsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    renderMatches();
                }
            });

            searchInput.addEventListener('input', function() {
                currentFilters.search = this.value.toLowerCase();
                currentPage = 1;
                renderMatches();
            });

            // Functions
            function initSampleData() {
                // Check if we already have data in localStorage
                const storedMatches = localStorage.getItem('worldCupMatches');
                if (storedMatches) {
                    matches = JSON.parse(storedMatches);
                    renderMatches();
                    return;
                }

                // Sample match data
                matches = [{
                        id: 1,
                        date: '2030-06-12',
                        time: '15:00',
                        team1: 'brazil',
                        team2: 'germany',
                        venue: 'rio',
                        stage: 'group',
                        status: 'scheduled',
                        team1Score: 0,
                        team2Score: 0,
                        notes: 'Opening match of Group A'
                    },
                    {
                        id: 2,
                        date: '2030-06-13',
                        time: '12:00',
                        team1: 'spain',
                        team2: 'portugal',
                        venue: 'madrid',
                        stage: 'group',
                        status: 'scheduled',
                        team1Score: 0,
                        team2Score: 0,
                        notes: 'Iberian derby'
                    },
                    {
                        id: 3,
                        date: '2030-06-13',
                        time: '18:00',
                        team1: 'france',
                        team2: 'netherlands',
                        venue: 'paris',
                        stage: 'group',
                        status: 'scheduled',
                        team1Score: 0,
                        team2Score: 0,
                        notes: ''
                    },
                    {
                        id: 4,
                        date: '2030-06-14',
                        time: '15:00',
                        team1: 'argentina',
                        team2: 'england',
                        venue: 'buenos',
                        stage: 'group',
                        status: 'scheduled',
                        team1Score: 0,
                        team2Score: 0,
                        notes: ''
                    },
                    {
                        id: 5,
                        date: '2030-06-15',
                        time: '12:00',
                        team1: 'italy',
                        team2: 'belgium',
                        venue: 'rome',
                        stage: 'group',
                        status: 'scheduled',
                        team1Score: 0,
                        team2Score: 0,
                        notes: ''
                    },
                    {
                        id: 6,
                        date: '2030-06-15',
                        time: '18:00',
                        team1: 'uruguay',
                        team2: 'croatia',
                        venue: 'montevideo',
                        stage: 'group',
                        status: 'scheduled',
                        team1Score: 0,
                        team2Score: 0,
                        notes: ''
                    },
                    {
                        id: 7,
                        date: '2030-06-16',
                        time: '15:00',
                        team1: 'germany',
                        team2: 'spain',
                        venue: 'berlin',
                        stage: 'group',
                        status: 'scheduled',
                        team1Score: 0,
                        team2Score: 0,
                        notes: ''
                    },
                    {
                        id: 8,
                        date: '2030-06-17',
                        time: '12:00',
                        team1: 'brazil',
                        team2: 'argentina',
                        venue: 'rio',
                        stage: 'group',
                        status: 'scheduled',
                        team1Score: 0,
                        team2Score: 0,
                        notes: 'South American classic'
                    }
                ];

                // Save to localStorage
                saveMatchesToStorage();
                renderMatches();
            }

            function saveMatchesToStorage() {
                localStorage.setItem('worldCupMatches', JSON.stringify(matches));
            }

            function renderMatches() {
                const filteredMatches = getFilteredMatches();
                const totalPages = Math.ceil(filteredMatches.length / itemsPerPage);

                // Update pagination info
                currentPageSpan.textContent = currentPage;
                totalPagesSpan.textContent = totalPages;

                // Enable/disable pagination buttons
                prevPageBtn.disabled = currentPage <= 1;
                nextPageBtn.disabled = currentPage >= totalPages;

                // Get current page matches
                const startIndex = (currentPage - 1) * itemsPerPage;
                const endIndex = startIndex + itemsPerPage;
                const currentMatches = filteredMatches.slice(startIndex, endIndex);

                // Render based on current view
                if (currentView === 'card') {
                    renderCardView(currentMatches);
                } else {
                    renderTableView(currentMatches);
                }
            }

            function getFilteredMatches() {
                return matches.filter(match => {
                    // Apply filters
                    if (currentFilters.stage !== 'all' && match.stage !== currentFilters.stage)
                        return false;
                    if (currentFilters.venue !== 'all' && match.venue !== currentFilters.venue)
                        return false;
                    if (currentFilters.status !== 'all' && match.status !== currentFilters.status)
                        return false;

                    // Team filter (check both teams)
                    if (currentFilters.team !== 'all' && match.team1 !== currentFilters.team && match
                        .team2 !== currentFilters.team) return false;

                    // Search filter
                    if (currentFilters.search) {
                        const searchTerm = currentFilters.search.toLowerCase();
                        const team1Name = getTeamName(match.team1).toLowerCase();
                        const team2Name = getTeamName(match.team2).toLowerCase();
                        const venueName = getVenueName(match.venue).toLowerCase();

                        if (!team1Name.includes(searchTerm) &&
                            !team2Name.includes(searchTerm) &&
                            !venueName.includes(searchTerm) &&
                            !match.date.includes(searchTerm)) {
                            return false;
                        }
                    }

                    return true;
                });
            }

            function renderCardView(matches) {
                matchCardsView.innerHTML = '';

                if (matches.length === 0) {
                    matchCardsView.innerHTML =
                        '<div class="no-matches">No matches found. Try adjusting your filters.</div>';
                    return;
                }

                matches.forEach(match => {
                    const matchCard = document.createElement('div');
                    matchCard.className = 'match-card';

                    const matchDate = new Date(`${match.date}T${match.time}:00`);
                    const formattedDate = matchDate.toLocaleDateString('en-US', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                    const formattedTime = matchDate.toLocaleTimeString('en-US', {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    });

                    matchCard.innerHTML = `
                <div class="match-date">
                    <i class="far fa-calendar-alt"></i> ${formattedDate} - ${formattedTime}
                </div>
                <div class="match-teams">
                    <div class="match-team">
                        <div class="team-flag" style="background-image: url('https://via.placeholder.com/40x30/${getTeamColor(match.team1)}/ffffff?text=${match.team1.substring(0, 3).toUpperCase()}')"></div>
                        <div class="team-name">${getTeamName(match.team1)}</div>
                    </div>
                    ${match.status === 'completed' || match.status === 'live' ? 
                        `<div class="match-score">
                                                                  <span>${match.team1Score}</span>
                                                                  <span>-</span>
                                                                  <span>${match.team2Score}</span>
                                                              </div>` : 
                        `<div class="match-vs">VS</div>`
                    }
                    <div class="match-team">
                        <div class="team-flag" style="background-image: url('https://via.placeholder.com/40x30/${getTeamColor(match.team2)}/ffffff?text=${match.team2.substring(0, 3).toUpperCase()}')"></div>
                        <div class="team-name">${getTeamName(match.team2)}</div>
                    </div>
                </div>
                <div class="match-venue">
                    <i class="fas fa-map-marker-alt"></i> ${getVenueName(match.venue)}
                </div>
                <div class="match-info">
                    <div class="match-stage">${getStageName(match.stage)}</div>
                    <div class="status-badge status-${match.status}">${getStatusName(match.status)}</div>
                </div>
                ${match.notes ? `<div class="match-notes">${match.notes}</div>` : ''}
                <div class="match-actions">
                    <button class="btn btn-sm btn-outline edit-match-btn" data-id="${match.id}">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-danger delete-match-btn" data-id="${match.id}">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            `;

                    matchCardsView.appendChild(matchCard);

                    // Add event listeners to the buttons
                    const editBtn = matchCard.querySelector('.edit-match-btn');
                    const deleteBtn = matchCard.querySelector('.delete-match-btn');

                    editBtn.addEventListener('click', function() {
                        const matchId = parseInt(this.getAttribute('data-id'));
                        openEditMatchModal(matchId);
                    });

                    deleteBtn.addEventListener('click', function() {
                        const matchId = parseInt(this.getAttribute('data-id'));
                        openDeleteModal(matchId);
                    });
                });
            }

            function renderTableView(matches) {
                matchTableBody.innerHTML = '';

                if (matches.length === 0) {
                    matchTableBody.innerHTML = `
                <tr>
                    <td colspan="6" style="text-align: center; padding: 30px;">
                        No matches found. Try adjusting your filters.
                    </td>
                </tr>
            `;
                    return;
                }

                matches.forEach(match => {
                    const matchRow = document.createElement('tr');

                    const matchDate = new Date(`${match.date}T${match.time}:00`);
                    const formattedDate = matchDate.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });
                    const formattedTime = matchDate.toLocaleTimeString('en-US', {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    });

                    matchRow.innerHTML = `
                <td>
                    ${formattedDate}<br>
                    <span style="color: var(--gray-600);">${formattedTime}</span>
                </td>
                <td>
                    <div class="table-teams">
                        <div class="table-team">
                            <div class="table-flag" style="background-image: url('https://via.placeholder.com/24x16/${getTeamColor(match.team1)}/ffffff?text=${match.team1.substring(0, 3).toUpperCase()}')"></div>
                            <span>${getTeamName(match.team1)}</span>
                        </div>
                        ${match.status === 'completed' || match.status === 'live' ? 
                            `<div style="margin: 0 10px; font-weight: 600;">${match.team1Score} - ${match.team2Score}</div>` : 
                            `<div style="margin: 0 10px;">vs</div>`
                        }
                        <div class="table-team">
                            <div class="table-flag" style="background-image: url('https://via.placeholder.com/24x16/${getTeamColor(match.team2)}/ffffff?text=${match.team2.substring(0, 3).toUpperCase()}')"></div>
                            <span>${getTeamName(match.team2)}</span>
                        </div>
                    </div>
                </td>
                <td>${getVenueName(match.venue)}</td>
                <td>${getStageName(match.stage)}</td>
                <td><span class="status-badge status-${match.status}">${getStatusName(match.status)}</span></td>
                <td>
                    <div class="match-actions">
                        <button class="btn btn-sm btn-outline edit-match-btn" data-id="${match.id}">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-danger delete-match-btn" data-id="${match.id}">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </td>
            `;

                    matchTableBody.appendChild(matchRow);

                    // Add event listeners to the buttons
                    const editBtn = matchRow.querySelector('.edit-match-btn');
                    const deleteBtn = matchRow.querySelector('.delete-match-btn');

                    editBtn.addEventListener('click', function() {
                        const matchId = parseInt(this.getAttribute('data-id'));
                        openEditMatchModal(matchId);
                    });

                    deleteBtn.addEventListener('click', function() {
                        const matchId = parseInt(this.getAttribute('data-id'));
                        openDeleteModal(matchId);
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
                    matchCardsView.style.display = 'grid';
                    matchTableView.style.display = 'none';
                } else {
                    matchCardsView.style.display = 'none';
                    matchTableView.style.display = 'block';
                }

                renderMatches();
            }

            function openAddMatchModal() {
                // Reset form
                matchForm.reset();
                document.getElementById('match-id').value = '';
                document.getElementById('modal-title').textContent = 'Add New Match';

                // Set default date to tomorrow
                const tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                document.getElementById('match-date').value = tomorrow.toISOString().split('T')[0];

                // Hide score inputs for new matches
                scoreInputs.style.display = 'none';

                // Show modal
                matchModal.classList.add('show');
            }

            function openEditMatchModal(matchId) {
                const match = matches.find(m => m.id === matchId);
                if (!match) return;

                // Set form values
                document.getElementById('match-id').value = match.id;
                document.getElementById('match-date').value = match.date;
                document.getElementById('match-time').value = match.time;
                document.getElementById('team1').value = match.team1;
                document.getElementById('team2').value = match.team2;
                document.getElementById('venue').value = match.venue;
                document.getElementById('stage').value = match.stage;
                document.getElementById('status').value = match.status;
                document.getElementById('team1-score').value = match.team1Score;
                document.getElementById('team2-score').value = match.team2Score;
                document.getElementById('notes').value = match.notes || '';

                // Show/hide score inputs based on status
                toggleScoreInputs();

                // Update modal title
                document.getElementById('modal-title').textContent = 'Edit Match';

                // Show modal
                matchModal.classList.add('show');
            }

            function closeMatchModal() {
                matchModal.classList.remove('show');
            }

            function openDeleteModal(matchId) {
                document.getElementById('delete-match-id').value = matchId;
                deleteModal.classList.add('show');
            }

            function closeDeleteModal() {
                deleteModal.classList.remove('show');
            }

            function toggleScoreInputs() {
                const status = statusSelect.value;
                if (status === 'completed' || status === 'live') {
                    scoreInputs.style.display = 'flex';
                } else {
                    scoreInputs.style.display = 'none';
                }
            }

            function saveMatch() {
                // Validate form
                if (!matchForm.checkValidity()) {
                    matchForm.reportValidity();
                    return;
                }

                // Get form values
                const matchId = document.getElementById('match-id').value;
                const date = document.getElementById('match-date').value;
                const time = document.getElementById('match-time').value;
                const team1 = document.getElementById('team1').value;
                const team2 = document.getElementById('team2').value;
                const venue = document.getElementById('venue').value;
                const stage = document.getElementById('stage').value;
                const status = document.getElementById('status').value;
                const team1Score = parseInt(document.getElementById('team1-score').value) || 0;
                const team2Score = parseInt(document.getElementById('team2-score').value) || 0;
                const notes = document.getElementById('notes').value;

                // Validate teams are different
                if (team1 === team2) {
                    alert('Teams cannot be the same');
                    return;
                }

                if (matchId) {
                    // Update existing match
                    const index = matches.findIndex(m => m.id === parseInt(matchId));
                    if (index !== -1) {
                        matches[index] = {
                            ...matches[index],
                            date,
                            time,
                            team1,
                            team2,
                            venue,
                            stage,
                            status,
                            team1Score,
                            team2Score,
                            notes
                        };
                    }
                } else {
                    // Add new match
                    const newId = matches.length > 0 ? Math.max(...matches.map(m => m.id)) + 1 : 1;
                    matches.push({
                        id: newId,
                        date,
                        time,
                        team1,
                        team2,
                        venue,
                        stage,
                        status,
                        team1Score,
                        team2Score,
                        notes
                    });
                }

                // Save to localStorage and render
                saveMatchesToStorage();
                renderMatches();
                closeMatchModal();
            }

            function deleteMatch() {
                const matchId = parseInt(document.getElementById('delete-match-id').value);
                matches = matches.filter(m => m.id !== matchId);

                // Save to localStorage and render
                saveMatchesToStorage();
                renderMatches();
                closeDeleteModal();
            }

            function resetFilters() {
                filterStage.value = 'all';
                filterTeam.value = 'all';
                filterVenue.value = 'all';
                filterStatus.value = 'all';
                searchInput.value = '';

                currentFilters = {
                    stage: 'all',
                    team: 'all',
                    venue: 'all',
                    status: 'all',
                    search: ''
                };

                currentPage = 1;
                renderMatches();
            }

            // Helper functions
            function getTeamName(teamCode) {
                const teams = {
                    'brazil': 'Brazil',
                    'germany': 'Germany',
                    'spain': 'Spain',
                    'france': 'France',
                    'england': 'England',
                    'argentina': 'Argentina',
                    'portugal': 'Portugal',
                    'netherlands': 'Netherlands',
                    'italy': 'Italy',
                    'belgium': 'Belgium',
                    'croatia': 'Croatia',
                    'uruguay': 'Uruguay'
                };
                return teams[teamCode] || teamCode;
            }

            function getTeamColor(teamCode) {
                const colors = {
                    'brazil': '3498db',
                    'germany': 'e74c3c',
                    'spain': 'f39c12',
                    'france': '9b59b6',
                    'england': '34495e',
                    'argentina': '1abc9c',
                    'portugal': '2ecc71',
                    'netherlands': 'e67e22',
                    'italy': '3498db',
                    'belgium': 'e74c3c',
                    'croatia': 'c0392b',
                    'uruguay': '2980b9'
                };
                return colors[teamCode] || '7f8c8d';
            }

            function getVenueName(venueCode) {
                const venues = {
                    'rio': 'Rio Stadium, Brazil',
                    'madrid': 'Madrid Stadium, Spain',
                    'paris': 'Paris Stadium, France',
                    'london': 'London Stadium, England',
                    'berlin': 'Berlin Stadium, Germany',
                    'rome': 'Rome Stadium, Italy',
                    'buenos': 'Buenos Aires Stadium, Argentina',
                    'montevideo': 'Montevideo Stadium, Uruguay'
                };
                return venues[venueCode] || venueCode;
            }

            function getStageName(stageCode) {
                const stages = {
                    'group': 'Group Stage',
                    'round16': 'Round of 16',
                    'quarter': 'Quarter Finals',
                    'semi': 'Semi Finals',
                    'final': 'Final'
                };
                return stages[stageCode] || stageCode;
            }

            function getStatusName(statusCode) {
                const statuses = {
                    'scheduled': 'Scheduled',
                    'live': 'Live',
                    'completed': 'Completed',
                    'postponed': 'Postponed',
                    'cancelled': 'Cancelled'
                };
                return statuses[statusCode] || statusCode;
            }
        });
    </script>
@endsection
