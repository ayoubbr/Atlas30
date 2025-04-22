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
        @section('header-title', 'Stadium Management')
        <div class="page-header">
            <div class="page-header-content">
                <h2 class="page-header-title">Stadium Management</h2>
                <p class="page-header-description">Create, edit, and manage all World Cup 2030 stadiums</p>
            </div>
            <div class="page-header-actions">
                <button class="btn btn-primary" id="add-venue-btn">
                    <i class="fas fa-plus"></i> Add New Stadium
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
                @if ($stadiums->isEmpty())
                    <div class="no-venues">No stadiums found.</div>
                @else
                    @foreach ($stadiums as $venue)
                        <div class="match-card venue-card">
                            <div class="venue-image"
                                style="background-image: url('{{ asset($venue->image ?? 'https://via.placeholder.com/400x200/3498db/ffffff?text=' . urlencode($venue->name)) }}')">
                            </div>

                            <div class="venue-content">
                                <h3 class="venue-name">{{ $venue->name }}</h3>
                                <div class="venue-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $venue->city }}
                                </div>

                                <div class="venue-capacity">
                                    <i class="fas fa-users"></i>
                                    Capacity: {{ number_format($venue->capacity) }} seats
                                </div>
                            </div>

                            <div class="venue-actions">
                                <button class="btn btn-sm btn-outline edit-venue-btn" data-id="{{ $venue->id }}"
                                    data-name="{{ $venue->name }}" data-city="{{ $venue->city }}"
                                    data-capacity="{{ $venue->capacity }}" data-image="{{ $venue->image }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-danger delete-venue-btn" data-id="{{ $venue->id }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Table View -->
            <div class="venue-table-view" id="venue-table-view" style="display: none;">
                <table class="match-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Capacity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="venue-table-body">
                        @forelse ($stadiums as $venue)
                            <tr>
                                <td>
                                    <div class="table-image"
                                        style="background-image: url('{{ asset($venue->image ?? 'https://via.placeholder.com/100x60/3498db/ffffff?text=' . urlencode($venue->name)) }}')">
                                    </div>
                                </td>
                                <td>
                                    <div class="table-venue-name">{{ $venue->name }}</div>
                                </td>
                                <td>
                                    {{ $venue->city }}
                                </td>
                                <td>
                                    {{ number_format($venue->capacity) }} seats
                                </td>
                                <td>
                                    <div class="venue-actions">
                                        <button class="btn btn-sm btn-outline edit-venue-btn" data-id="{{ $venue->id }}"
                                            data-name="{{ $venue->name }}" data-city="{{ $venue->city }}"
                                            data-capacity="{{ $venue->capacity }}" data-image="{{ $venue->image }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-venue-btn"
                                            data-id="{{ $venue->id }}">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 30px;">
                                    No stadiums found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection

@section('modal')
    <!-- Add/Edit Stadium Modal -->
    <div class="modal" id="venue-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title">Add New Stadium</h3>
                <button class="modal-close" id="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="venue-form" method="POST" action=""
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="form-method" value="POST">

                    <div class="form-group">
                        <label for="venue-name">Stadium Name</label>
                        <input type="text" id="venue-name" class="form-control" required name="name">
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

                    <div class="form-group">
                        <label for="stadium-image">Stadium Image</label>
                        <input type="file" class="form-control" id="stadium-image" name="image" accept="image/*">
                        <div class="form-text" id="image-help-text">Upload an image of the stadium</div>
                        <img id="image-preview" src="#" alt="Image Preview"
                            style="display: none; max-width: 100%; margin-top: 10px;">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline" id="cancel-btn">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="save-venue-btn">Save Stadium</button>
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
                <p>Are you sure you want to delete this stadium? This action cannot be undone.</p>
                <form id="delete-form" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline" id="cancel-delete-btn">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete Stadium</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addVenueBtn = document.getElementById('add-venue-btn');
            const venueModal = document.getElementById('venue-modal');
            const modalClose = document.getElementById('modal-close');
            const cancelBtn = document.getElementById('cancel-btn');
            const venueForm = document.getElementById('venue-form');
            const deleteModal = document.getElementById('delete-modal');
            const deleteModalClose = document.getElementById('delete-modal-close');
            const cancelDeleteBtn = document.getElementById('cancel-delete-btn');
            const deleteForm = document.getElementById('delete-form');
            const venueCardsView = document.getElementById('venue-cards-view');
            const venueTableView = document.getElementById('venue-table-view');
            const viewBtns = document.querySelectorAll('.view-btn');
            const stadiumImage = document.getElementById('stadium-image');
            const imagePreview = document.getElementById('image-preview');
            const imageHelpText = document.getElementById('image-help-text');

            // Add event listeners for all edit buttons
            document.querySelectorAll('.edit-venue-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const venueId = this.getAttribute('data-id');
                    const venueName = this.getAttribute('data-name');
                    const venueCity = this.getAttribute('data-city');
                    const venueCapacity = this.getAttribute('data-capacity');
                    const venueImage = this.getAttribute('data-image');

                    openEditVenueModal(venueId, venueName, venueCity, venueCapacity, venueImage);
                });
            });

            // Add event listeners for all delete buttons
            document.querySelectorAll('.delete-venue-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const venueId = this.getAttribute('data-id');
                    openDeleteModal(venueId);
                });
            });

            // Event Listeners
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

            viewBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const view = this.getAttribute('data-view');
                    changeView(view);
                });
            });

            stadiumImage.addEventListener('change', function() {
                previewImage(this);
            });

            // Functions
            function changeView(view) {
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
            }

            function openAddVenueModal() {
                venueForm.reset();
                document.getElementById('form-method').value = 'POST';
                document.getElementById('modal-title').textContent = 'Add New Stadium';
                venueForm.action = "{{ route('admin.stadiums.store') }}";

                // Reset image preview
                imagePreview.style.display = 'none';
                stadiumImage.required = true;
                imageHelpText.textContent = 'Upload an image of the stadium';

                venueModal.classList.add('show');
            }

            function openEditVenueModal(venueId, venueName, venueCity, venueCapacity, venueImage) {
                document.getElementById('venue-name').value = venueName;
                document.getElementById('venue-city').value = venueCity;
                document.getElementById('venue-capacity').value = venueCapacity;
                document.getElementById('form-method').value = 'PUT';

                venueForm.action = "{{ url('admin/stadiums') }}/" + venueId;

                // Show image preview
                if (venueImage) {
                    imagePreview.src = "{{ asset('') }}" + venueImage;
                    imagePreview.style.display = 'block';
                    stadiumImage.required = false;
                    imageHelpText.textContent = 'Leave empty to keep current image';
                } else {
                    imagePreview.style.display = 'none';
                    stadiumImage.required = true;
                }

                document.getElementById('modal-title').textContent = 'Edit Stadium';
                venueModal.classList.add('show');
            }

            function closeVenueModal() {
                venueModal.classList.remove('show');
            }

            function openDeleteModal(venueId) {
                deleteForm.action = `/admin/stadiums/${venueId}`;
                deleteModal.classList.add('show');
            }

            function closeDeleteModal() {
                deleteModal.classList.remove('show');
            }

            function previewImage(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
        });
    </script>
@endsection
