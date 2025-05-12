@extends('admin.layout')

@section('title', 'Role Management - World Cup 2030')
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

        /* Role Card Styles */
        .role-cards-view {
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .role-card {
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

        .role-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .role-header {
            height: 80px;
            background-color: var(--secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .role-content {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .role-name {
            font-size: 1.2rem;
            margin-bottom: 5px;
            color: var(--secondary);
            text-align: center;
        }

        .role-description {
            font-size: 0.9rem;
            color: var(--gray-600);
            text-align: center;
            line-height: 1.5;
        }

        .role-actions {
            padding: 15px 20px;
            /* border-top: 1px solid var(--gray-200); */
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* Table View Styles */
        .role-table-view {
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

        .table-role-name {
            font-weight: 600;
            color: var(--secondary);
        }

        .role-badge {
            background-color: var(--secondary-light);
            color: var(--secondary);
            padding: 4px 8px;
            border-radius: 12px;
            font-weight: 600;
        }

        /* Responsive Styles */
        @media (max-width: 1200px) {
            .role-cards-view {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .role-cards-view {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
@section('header-title', 'Roles Management')
    <main class="admin-main">
        <div class="page-header">
            <div class="page-header-content">
                <h2 class="page-header-title">Role Management</h2>
                <p class="page-header-description">Create, edit, and manage user roles for World Cup 2030</p>
            </div>
            <div class="page-header-actions">
                <button class="btn btn-primary" id="add-role-btn">
                    <i class="fas fa-plus"></i> Add New Role
                </button>
            </div>
        </div>

        <div class="match-list-container">
            <div class="view-toggle">
                <button class="view-btn active" data-view="card">
                    <i class="fas fa-th-large"></i> Card View
                </button>
                <button class="view-btn" data-view="table">
                    <i class="fas fa-list"></i> Table View
                </button>
            </div>

            <div class="role-cards-view" id="role-cards-view">
                @if ($roles->isEmpty())
                    <div class="no-roles">No roles found.</div>
                @else
                    @foreach ($roles as $role)
                        <div class="match-card role-card">
                            <div class="role-header">
                                <h3 class="role-name" style="color: white; font-size: 1.5rem;">{{ $role->name }}</h3>
                            </div>

                            <div class="role-content">
                                <div class="role-description">
                                    {{ $role->description ?? 'No description available' }}
                                </div>
                            </div>

                            <div class="role-actions">
                                <button class="btn btn-sm btn-outline edit-role-btn" data-id="{{ $role->id }}"
                                    data-name="{{ $role->name }}" data-description="{{ $role->description }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-danger delete-role-btn" data-id="{{ $role->id }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Table View -->
            <div class="role-table-view" id="role-table-view" style="display: none;">
                <table class="match-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="role-table-body">
                        @forelse ($roles as $role)
                            <tr>
                                <td>
                                    <span class="role-badge">{{ $role->name }}</span>
                                </td>
                                <td>
                                    {{ $role->description ?? 'No description available' }}
                                </td>
                                <td>
                                    {{ $role->created_at->format('M d, Y') }}
                                </td>
                                <td>
                                    <div class="role-actions">
                                        <button class="btn btn-sm btn-outline edit-role-btn" data-id="{{ $role->id }}"
                                            data-name="{{ $role->name }}" data-description="{{ $role->description }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-role-btn"
                                            data-id="{{ $role->id }}">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 30px;">
                                    No roles found.
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
    <!-- Add/Edit Role Modal -->
    <div class="modal" id="role-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title">Add New Role</h3>
                <button class="modal-close" id="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="role-form" method="POST" action="{{ route('admin.roles.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="form-method" value="POST">

                    <div class="form-group">
                        <label for="role-name">Role Name</label>
                        <input type="text" id="role-name" class="form-control" required name="name">
                    </div>

                    <div class="form-group">
                        <label for="role-description">Description</label>
                        <textarea id="role-description" class="form-control" name="description" rows="3"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline" id="cancel-btn">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="save-role-btn">Save Role</button>
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
                <p>Are you sure you want to delete this role? This action cannot be undone.</p>
                <form id="delete-form" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline" id="cancel-delete-btn">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addRoleBtn = document.getElementById('add-role-btn');
            const roleModal = document.getElementById('role-modal');
            const modalClose = document.getElementById('modal-close');
            const cancelBtn = document.getElementById('cancel-btn');
            const roleForm = document.getElementById('role-form');
            const deleteModal = document.getElementById('delete-modal');
            const deleteModalClose = document.getElementById('delete-modal-close');
            const cancelDeleteBtn = document.getElementById('cancel-delete-btn');
            const deleteForm = document.getElementById('delete-form');
            const roleCardsView = document.getElementById('role-cards-view');
            const roleTableView = document.getElementById('role-table-view');
            const viewBtns = document.querySelectorAll('.view-btn');

            // Add event listeners all edit buttons
            document.querySelectorAll('.edit-role-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const roleId = this.getAttribute('data-id');
                    const roleName = this.getAttribute('data-name');
                    const roleDescription = this.getAttribute('data-description');

                    openEditRoleModal(roleId, roleName, roleDescription);
                });
            });

            // Add event listeners all delete buttons
            document.querySelectorAll('.delete-role-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const roleId = this.getAttribute('data-id');
                    openDeleteModal(roleId);
                });
            });

            addRoleBtn.addEventListener('click', function() {
                openAddRoleModal();
            });

            modalClose.addEventListener('click', function() {
                closeRoleModal();
            });

            cancelBtn.addEventListener('click', function() {
                closeRoleModal();
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
                viewBtns.forEach(btn => {
                    if (btn.getAttribute('data-view') === view) {
                        btn.classList.add('active');
                    } else {
                        btn.classList.remove('active');
                    }
                });

                if (view === 'card') {
                    roleCardsView.style.display = 'grid';
                    roleTableView.style.display = 'none';
                } else {
                    roleCardsView.style.display = 'none';
                    roleTableView.style.display = 'block';
                }
            }

            function openAddRoleModal() {
                roleForm.reset();
                document.getElementById('form-method').value = 'POST';
                document.getElementById('modal-title').textContent = 'Add New Role';
                roleForm.action = "{{ route('admin.roles.store') }}";

                roleModal.classList.add('show');
            }

            function openEditRoleModal(roleId, roleName, roleDescription) {
                document.getElementById('role-name').value = roleName;
                document.getElementById('role-description').value = roleDescription || '';
                document.getElementById('form-method').value = 'PUT';

                roleForm.action = "{{ url('admin/roles') }}/" + roleId;
                document.getElementById('modal-title').textContent = 'Edit Role';

                roleModal.classList.add('show');
            }

            function closeRoleModal() {
                roleModal.classList.remove('show');
            }

            function openDeleteModal(roleId) {
                deleteForm.action = "{{ url('admin/roles') }}/" + roleId;

                deleteModal.classList.add('show');
            }

            function closeDeleteModal() {
                deleteModal.classList.remove('show');
            }
        });
    </script>
@endsection
