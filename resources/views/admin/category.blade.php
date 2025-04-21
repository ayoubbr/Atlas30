@extends('admin.layout')

@section('title', 'Category Management - World Cup 2030')
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

        .modal.show {
            display: flex;
        }

        /* Category Card Styles */
        .category-cards-view {
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .category-card {
            display: flex;
            flex-direction: column;
            padding: 0;
            overflow: hidden;
            border-left: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            background-color: white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .category-header {
            height: 100px;
            background-color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .category-content {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .category-title {
            font-size: 1.2rem;
            margin-bottom: 5px;
            color: var(--secondary);
            text-align: center;
        }

        .category-price {
            font-size: 1.1rem;
            color: var(--gray-700);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: bold;
        }

        .category-price i {
            color: var(--primary);
            width: 16px;
        }

        .category-actions {
            padding: 15px 20px;
            border-top: 1px solid var(--gray-200);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* Table View Styles */
        .category-table-view {
            padding: 20px;
        }

        .match-table {
            width: 100%;
            border-collapse: collapse;
        }

        .match-table th,
        .match-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
        }

        .match-table th {
            background-color: var(--gray-100);
            font-weight: 600;
        }

        .table-category-title {
            font-weight: 600;
            color: var(--secondary);
        }

        .price-badge {
            background-color: var(--primary-light);
            color: var(--primary);
            padding: 4px 8px;
            border-radius: 12px;
            font-weight: 600;
        }

        /* Responsive Styles */
        @media (max-width: 1200px) {
            .category-cards-view {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .category-cards-view {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
@section('header-title', 'Category Management')
<main class="admin-main">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <h2 class="page-header-title">Category Management</h2>
            <p class="page-header-description">Create, edit, and manage ticket categories for World Cup 2030</p>
        </div>
        <div class="page-header-actions">
            <button class="btn btn-primary" id="add-category-btn">
                <i class="fas fa-plus"></i> Add New Category
            </button>
        </div>
    </div>

    <!-- Category List -->
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
        <div class="category-cards-view" id="category-cards-view">
            @if ($categories->isEmpty())
                <div class="no-categories">No categories found.</div>
            @else
                @foreach ($categories as $category)
                    <div class="match-card category-card">
                        {{-- Header --}}
                        <div class="category-header">
                            <h3 class="category-title" style="color: white; font-size: 1.5rem;">{{ $category->title }}
                            </h3>
                        </div>

                        {{-- Content --}}
                        <div class="category-content">
                            <div class="category-price">
                                <i class="fas fa-tag"></i>
                                Price: ${{ number_format($category->price, 2) }}
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="category-actions">
                            <button class="btn btn-sm btn-outline edit-category-btn" data-id="{{ $category->id }}"
                                data-title="{{ $category->title }}" data-price="{{ $category->price }}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger delete-category-btn" data-id="{{ $category->id }}">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Table View (hidden by default) -->
        <div class="category-table-view" id="category-table-view" style="display: none;">
            <table class="match-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="category-table-body">
                    @forelse ($categories as $category)
                        <tr>
                            <td>
                                <div class="table-category-title">{{ $category->title }}</div>
                            </td>
                            <td>
                                <span class="price-badge">${{ number_format($category->price, 2) }}</span>
                            </td>
                            <td>
                                {{ $category->created_at->format('M d, Y') }}
                            </td>
                            <td>
                                <div class="category-actions">
                                    <button class="btn btn-sm btn-outline edit-category-btn"
                                        data-id="{{ $category->id }}" data-title="{{ $category->title }}"
                                        data-price="{{ $category->price }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-category-btn"
                                        data-id="{{ $category->id }}">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 30px;">
                                No categories found.
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
<!-- Add/Edit Category Modal -->
<div class="modal" id="category-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="modal-title">Add New Category</h3>
            <button class="modal-close" id="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="category-form" method="POST" action="{{ route('admin.categories.store') }}">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">

                <div class="form-group">
                    <label for="category-title">Category Title</label>
                    <input type="text" id="category-title" class="form-control" required name="title">
                </div>

                <div class="form-group">
                    <label for="category-price">Price ($)</label>
                    <input type="number" id="category-price" class="form-control" required min="0"
                        step="0.01" name="price">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" id="cancel-btn">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="save-category-btn">Save Category</button>
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
            <p>Are you sure you want to delete this category? This action cannot be undone.</p>
            <form id="delete-form" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" id="cancel-delete-btn">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // DOM Elements
        const addCategoryBtn = document.getElementById('add-category-btn');
        const categoryModal = document.getElementById('category-modal');
        const modalClose = document.getElementById('modal-close');
        const cancelBtn = document.getElementById('cancel-btn');
        const categoryForm = document.getElementById('category-form');
        const deleteModal = document.getElementById('delete-modal');
        const deleteModalClose = document.getElementById('delete-modal-close');
        const cancelDeleteBtn = document.getElementById('cancel-delete-btn');
        const deleteForm = document.getElementById('delete-form');
        const categoryCardsView = document.getElementById('category-cards-view');
        const categoryTableView = document.getElementById('category-table-view');
        const viewBtns = document.querySelectorAll('.view-btn');

        // Add event listeners for all edit buttons
        document.querySelectorAll('.edit-category-btn').forEach(button => {
            button.addEventListener('click', function() {
                const categoryId = this.getAttribute('data-id');
                const categoryTitle = this.getAttribute('data-title');
                const categoryPrice = this.getAttribute('data-price');

                openEditCategoryModal(categoryId, categoryTitle, categoryPrice);
            });
        });

        // Add event listeners for all delete buttons
        document.querySelectorAll('.delete-category-btn').forEach(button => {
            button.addEventListener('click', function() {
                const categoryId = this.getAttribute('data-id');
                openDeleteModal(categoryId);
            });
        });

        // Event Listeners
        addCategoryBtn.addEventListener('click', function() {
            openAddCategoryModal();
        });

        modalClose.addEventListener('click', function() {
            closeCategoryModal();
        });

        cancelBtn.addEventListener('click', function() {
            closeCategoryModal();
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

        // Functions
        function changeView(view) {
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
                categoryCardsView.style.display = 'grid';
                categoryTableView.style.display = 'none';
            } else {
                categoryCardsView.style.display = 'none';
                categoryTableView.style.display = 'block';
            }
        }

        function openAddCategoryModal() {
            // Reset form
            categoryForm.reset();
            document.getElementById('form-method').value = 'POST';
            document.getElementById('modal-title').textContent = 'Add New Category';
            categoryForm.action = "{{ route('admin.categories.store') }}";

            // Show modal
            categoryModal.classList.add('show');
        }

        function openEditCategoryModal(categoryId, categoryTitle, categoryPrice) {
            // Set form values
            document.getElementById('category-title').value = categoryTitle;
            document.getElementById('category-price').value = categoryPrice;
            document.getElementById('form-method').value = 'PUT';

            // Update form action for update
            categoryForm.action = "{{ url('admin/categories') }}/" + categoryId;

            // Update modal title
            document.getElementById('modal-title').textContent = 'Edit Category';

            // Show modal
            categoryModal.classList.add('show');
        }

        function closeCategoryModal() {
            categoryModal.classList.remove('show');
        }

        function openDeleteModal(categoryId) {
            // Set the form action for delete
            deleteForm.action = "{{ url('admin/categories') }}/" + categoryId;

            // Show modal
            deleteModal.classList.add('show');
        }

        function closeDeleteModal() {
            deleteModal.classList.remove('show');
        }
    });
</script>
@endsection
