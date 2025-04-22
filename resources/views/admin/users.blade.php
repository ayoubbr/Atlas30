@extends('admin.layout')

@section('title', 'User Management - World Cup 2030')

@section('css')
    <style>
        /* User-specific styles */
        .user-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .user-card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: var(--transition);
        }

        .user-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .user-card-header {
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid var(--gray-200);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
            background-color: var(--gray-200);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--gray-500);
        }

        .user-info {
            flex: 1;
        }

        .user-email {
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        .user-card-body {
            padding: 20px;
        }

        .user-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .user-detail {
            display: flex;
            flex-direction: column;
        }

        .detail-label {
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        .detail-value {
            font-weight: 600;
            font-size: 0.95rem;
        }

        .user-card-footer {
            padding: 15px 20px;
            border-top: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--gray-50);
        }

        .user-status {
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-active {
            color: var(--success);
        }

        .status-inactive {
            color: var(--gray-600);
        }

        .status-suspended {
            color: var(--warning);
        }

        .status-banned {
            color: var(--danger);
        }

        .user-actions {
            display: flex;
            gap: 10px;
        }

        .user-table-container {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .user-table {
            width: 100%;
            border-collapse: collapse;
        }

        .user-table th,
        .user-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
        }

        .user-table th {
            background-color: var(--gray-100);
            font-weight: 600;
            color: var(--gray-700);
        }

        .user-table tbody tr:hover {
            background-color: var(--gray-50);
        }

        .user-table tbody tr:last-child td {
            border-bottom: none;
        }

        .user-table-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
            background-color: var(--gray-200);
            margin-right: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-500);
            font-size: 1rem;
        }

        .user-table-name {
            display: flex;
            align-items: center;
            font-weight: 600;
        }

        .user-table-actions {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }

        .role-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .role-admin {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .role-moderator {
            background-color: var(--info-light);
            color: var(--info);
        }

        .role-editor {
            background-color: var(--warning-light);
            color: var(--warning);
        }

        .role-user {
            background-color: var(--gray-200);
            color: var(--gray-700);
        }

        .user-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .user-stats-card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 20px;
            display: flex;
            align-items: center;
            transition: var(--transition);
        }

        .user-stats-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .stats-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-right: 15px;
            position: relative;
        }

        .stats-icon::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: currentColor;
            opacity: 0.15;
            z-index: -1;
        }

        .stats-icon-users {
            color: var(--primary);
        }

        .stats-icon-active {
            color: var(--success);
        }

        .stats-icon-new {
            color: var(--info);
        }

        .stats-content {
            flex: 1;
        }

        .stats-value {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--gray-800);
        }

        .stats-label {
            font-size: 0.9rem;
            color: var(--gray-600);
        }

        .user-search {
            position: relative;
            margin-bottom: 20px;
        }

        .search-input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 1px solid var(--gray-300);
            border-radius: var(--border-radius);
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-500);
            font-size: 1.1rem;
        }

        .user-form-group {
            margin-bottom: 20px;
        }

        .user-form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--gray-300);
            border-radius: var(--border-radius);
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
        }

        .user-form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.1);
        }

        .user-form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .user-form-col {
            flex: 1;
        }

        .user-activity-list {
            max-height: 300px;
            overflow-y: auto;
        }

        .permissions-list {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 15px;
        }

        .permission-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .permission-checkbox {
            width: 18px;
            height: 18px;
        }

        .permission-label {
            font-size: 0.9rem;
        }

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
            z-index: 1000;
        }

        .user-activity-chart {
            height: 300px;
            margin-top: 20px;
        }

        .pagination {
            justify-content: center;
        }
    </style>
@endsection

@section('content')

@section('header-title', 'User Management')
<!-- Main Content -->
<main class="admin-main">
    <div class="page-header">
        <div>
            <h2 class="page-header-title">User Management</h2>
            <p class="page-header-description">Manage all users of the World Cup 2030 platform</p>
        </div>
        <div class="page-header-actions">
            <button class="btn btn-primary" id="addUserBtn">
                <i class="fas fa-user-plus"></i> Add User
            </button>
        </div>
    </div>

    <div class="user-stats">
        <div class="user-stats-card">
            <div class="stats-icon stats-icon-users">
                <i class="fas fa-users"></i>
            </div>
            <div class="stats-content">
                <div class="stats-value">{{ number_format($totalUsers) }}</div>
                <div class="stats-label">Total Users</div>
            </div>
        </div>

        <div class="user-stats-card">
            <div class="stats-icon stats-icon-active">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stats-content">
                <div class="stats-value">{{ number_format($activeUsers) }}</div>
                <div class="stats-label">Active Users</div>
            </div>
        </div>

        <div class="user-stats-card">
            <div class="stats-icon stats-icon-new">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="stats-content">
                <div class="stats-value">{{ number_format($newUsers) }}</div>
                <div class="stats-label">New Users (Last 7 Days)</div>
            </div>
        </div>
    </div>

    <!-- User Search & Filters -->
    <div class="user-search">
        <i class="fas fa-search search-icon"></i>
        <input type="text" class="search-input" id="user-search-input"
            placeholder="Search users by name or email ...">
    </div>

    <div class="match-filters">
        <div class="filter-group">
            <label for="role-filter">Role</label>
            <select id="role-filter" class="filter-select">
                <option value="">All Roles</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <label for="status-filter">Status</label>
            <select id="status-filter" class="filter-select">
                <option value="">All Statuses</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="suspended">Suspended</option>
                <option value="banned">Banned</option>
            </select>
        </div>

        <div class="filter-group" style="display: flex; align-items: flex-end; justify-content: end;">
            <button class="btn btn-primary" id="apply-filters-btn">
                <i class="fas fa-filter"></i> Apply Filters
            </button>
        </div>
    </div>

    <!-- User Table -->
    <div class="user-table-container">
        <div class="view-toggle">
            <button class="view-btn active">
                <i class="fas fa-table"></i> Table View
            </button>
        </div>

        <div class="table-responsive">
            <table class="user-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Registration Date</th>
                        <th>Last Login</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="user-table-name">
                                    <div class="user-table-avatar"
                                        style="background-image: url('{{ $user->image ?? 'https://via.placeholder.com/40x40' }}')">
                                    </div>
                                    {{ $user->firstname }} {{ $user->lastname }}
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="role-badge role-{{ strtolower($user->role->name) }}">
                                    {{ $user->role->name }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('M j, Y') }}</td>
                            <td>{{ $user->last_login ?? 'Never' }}</td>
                            <td><span
                                    class="status-badge status-{{ $user->status }}">{{ ucfirst($user->status) }}</span>
                            </td>
                            <td>
                                <div class="user-table-actions">
                                    <button class="btn btn-sm btn-outline view-user-btn" data-id="{{ $user->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline edit-user-btn" data-id="{{ $user->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline btn-danger delete-user-btn"
                                        data-id="{{ $user->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">No users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            @if ($users->hasPages())
                <div class="pagination-container">
                    <ul class="pagination">
                        @if ($users->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">&laquo;</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a href="{{ $users->previousPageUrl() }}" class="page-link">&laquo;</a>
                            </li>
                        @endif

                        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                            @if ($page == $users->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        @if ($users->hasMorePages())
                            <li class="page-item">
                                <a href="{{ $users->nextPageUrl() }}" class="page-link">&raquo;</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">&raquo;</span>
                            </li>
                        @endif
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <!-- User Registration Chart -->
    <div class="user-card">
        <div class="user-card-header">
            <h3>User Registration Trend</h3>
        </div>
        <div class="user-card-body">
            <div class="user-activity-chart">
                <canvas id="userRegistrationChart"></canvas>
            </div>
        </div>
    </div>
</main>
@endsection

@section('modal')
<!-- Add/Edit User Modal -->
<div class="modal" id="userModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="userModalTitle">Add New User</h3>
            <button class="modal-close" id="closeUserModal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="userForm" method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">

                <div class="user-form-row">
                    <div class="user-form-col">
                        <div class="user-form-group">
                            <label class="user-form-label" for="firstname">First Name</label>
                            <input type="text" class="user-form-control" id="firstname" name="firstname"
                                placeholder="Enter first name" required>
                        </div>
                    </div>
                    <div class="user-form-col">
                        <div class="user-form-group">
                            <label class="user-form-label" for="lastname">Last Name</label>
                            <input type="text" class="user-form-control" id="lastname" name="lastname"
                                placeholder="Enter last name" required>
                        </div>
                    </div>
                </div>

                <div class="user-form-group">
                    <label class="user-form-label" for="email">Email Address</label>
                    <input type="email" class="user-form-control" id="email" name="email"
                        placeholder="Enter email address" required>
                </div>

                <div class="user-form-row">
                    <div class="user-form-col">
                        <div class="user-form-group">
                            <label class="user-form-label" for="password">Password</label>
                            <input type="password" class="user-form-control" id="password" name="password"
                                placeholder="Enter password">
                        </div>
                    </div>
                    <div class="user-form-col">
                        <div class="user-form-group">
                            <label class="user-form-label" for="password_confirmation">Confirm Password</label>
                            <input type="password" class="user-form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Confirm password">
                        </div>
                    </div>
                </div>

                <div class="user-form-row">
                    <div class="user-form-col">
                        <div class="user-form-group">
                            <label class="user-form-label" for="role_id">User Role</label>
                            <select class="user-form-control" id="role_id" name="role_id" required>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="user-form-col">
                        <div class="user-form-group">
                            <label class="user-form-label" for="status">Account Status</label>
                            <select class="user-form-control" id="status" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="suspended">Suspended</option>
                                <option value="banned">Banned</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" id="cancelUserBtn">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveUserBtn">Save User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View User Modal -->
<div class="modal" id="viewUserModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="viewUserModalTitle">User Details</h3>
            <button class="modal-close" id="closeViewUserModal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="user-card">
                <div class="user-card-header">
                    <div class="user-avatar" id="viewUserAvatar"
                        style="background-image: url('https://via.placeholder.com/60x60')"></div>
                    <div class="user-info">
                        <div class="user-name" id="viewUserName">John Smith</div>
                        <div class="user-email" id="viewUserEmail">john.smith@example.com</div>
                    </div>
                </div>
                <div class="user-card-body">
                    <div class="user-details">
                        <div class="user-detail">
                            <div class="detail-label">Role</div>
                            <div class="detail-value" id="viewUserRole">Administrator</div>
                        </div>
                        <div class="user-detail">
                            <div class="detail-label">Status</div>
                            <div class="detail-value" id="viewUserStatus">Active</div>
                        </div>
                        <div class="user-detail">
                            <div class="detail-label">Registration Date</div>
                            <div class="detail-value" id="viewUserRegistration">Jan 15, 2023</div>
                        </div>
                        <div class="user-detail">
                            <div class="detail-label">Tickets Purchased</div>
                            <div class="detail-value" id="viewUserTickets">5</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" id="closeViewUserBtn">Close</button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal" id="deleteUserModal">
    <div class="modal-content modal-sm">
        <div class="modal-header">
            <h3 class="modal-title">Confirm Delete</h3>
            <button class="modal-close" id="closeDeleteModal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this user? This action cannot be undone.</p>
            <p><strong>User: </strong><span id="deleteUserName">John Smith</span></p>
            <form id="delete-user-form" method="POST" action="">
                @csrf
                @method('DELETE')
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" id="cancelDeleteBtn">Cancel</button>
            <button class="btn btn-danger" id="confirmDeleteBtn">Delete User</button>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile menu toggle
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.querySelector('.admin-sidebar');

        if (menuToggle && sidebar) {
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
            });
        }

        // User Modal
        const userModal = document.getElementById('userModal');
        const addUserBtn = document.getElementById('addUserBtn');
        const closeUserModal = document.getElementById('closeUserModal');
        const cancelUserBtn = document.getElementById('cancelUserBtn');
        const editUserBtns = document.querySelectorAll('.edit-user-btn');
        const userForm = document.getElementById('userForm');

        if (addUserBtn && userModal) {
            addUserBtn.addEventListener('click', function() {
                document.getElementById('userModalTitle').textContent = 'Add New User';
                document.getElementById('form-method').value = 'POST';
                userForm.action = "{{ route('admin.users.store') }}";
                userForm.reset();
                userModal.classList.add('show');
            });
        }

        if (closeUserModal && userModal) {
            closeUserModal.addEventListener('click', function() {
                userModal.classList.remove('show');
            });
        }

        if (cancelUserBtn && userModal) {
            cancelUserBtn.addEventListener('click', function() {
                userModal.classList.remove('show');
            });
        }

        if (editUserBtns.length && userModal) {
            editUserBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const userId = this.getAttribute('data-id');
                    document.getElementById('userModalTitle').textContent = 'Edit User';
                    document.getElementById('form-method').value = 'PUT';
                    userForm.action = "{{ url('admin/users') }}/" + userId;

                    fetch("{{ url('admin/users') }}/" + userId)
                        .then(response => response.json())
                        .then(data => {
                            const user = data.user;
                            document.getElementById('firstname').value = user.firstname;
                            document.getElementById('lastname').value = user.lastname;
                            document.getElementById('email').value = user.email;
                            document.getElementById('role_id').value = user.role_id;
                            document.getElementById('status').value = user.status;

                            document.getElementById('password').value = '';
                            document.getElementById('password_confirmation').value = '';

                            userModal.classList.add('show');
                        })
                        .catch(error => {
                            console.error('Error fetching user data:', error);
                        });
                });
            });
        }

        // View User Modal
        const viewUserModal = document.getElementById('viewUserModal');
        const viewUserBtns = document.querySelectorAll('.view-user-btn');
        const closeViewUserModal = document.getElementById('closeViewUserModal');
        const closeViewUserBtn = document.getElementById('closeViewUserBtn');

        if (viewUserBtns.length && viewUserModal) {
            viewUserBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const userId = this.getAttribute('data-id');

                    fetch("{{ url('admin/users') }}/" + userId)
                        .then(response => response.json())
                        .then(data => {
                            const user = data.user;

                            document.getElementById('viewUserName').textContent = user
                                .firstname + ' ' + user.lastname;
                            document.getElementById('viewUserEmail').textContent = user
                                .email;
                            document.getElementById('viewUserRole').textContent = user.role
                                .name;
                            document.getElementById('viewUserStatus').textContent = user
                                .status.charAt(0).toUpperCase() + user.status.slice(1);
                            document.getElementById('viewUserRegistration').textContent =
                                new Date(user.created_at).toLocaleDateString('en-US', {
                                    year: 'numeric',
                                    month: 'short',
                                    day: 'numeric'
                                });

                            document.getElementById('viewUserTickets').textContent = user
                                .tickets.length;

                            if (user.image) {
                                document.getElementById('viewUserAvatar').style
                                    .backgroundImage = `url('${user.image}')`;
                            } else {
                                document.getElementById('viewUserAvatar').style
                                    .backgroundImage =
                                    "url('https://via.placeholder.com/60x60')";
                            }

                            viewUserModal.classList.add('show');
                        })
                        .catch(error => {
                            console.error('Error fetching user data:', error);
                        });
                });
            });
        }

        if (closeViewUserModal && viewUserModal) {
            closeViewUserModal.addEventListener('click', function() {
                viewUserModal.classList.remove('show');
            });
        }

        if (closeViewUserBtn && viewUserModal) {
            closeViewUserBtn.addEventListener('click', function() {
                viewUserModal.classList.remove('show');
            });
        }

        // Delete User Modal
        const deleteUserModal = document.getElementById('deleteUserModal');
        const deleteUserBtns = document.querySelectorAll('.delete-user-btn');
        const closeDeleteModal = document.getElementById('closeDeleteModal');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const deleteUserForm = document.getElementById('delete-user-form');

        if (deleteUserBtns.length && deleteUserModal) {
            deleteUserBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const userId = this.getAttribute('data-id');
                    const userName = this.closest('tr').querySelector('.user-table-name')
                        .textContent.trim();

                    document.getElementById('deleteUserName').textContent = userName;
                    deleteUserForm.action = "{{ url('admin/users') }}/" + userId;

                    deleteUserModal.classList.add('show');
                });
            });
        }

        if (closeDeleteModal && deleteUserModal) {
            closeDeleteModal.addEventListener('click', function() {
                deleteUserModal.classList.remove('show');
            });
        }

        if (cancelDeleteBtn && deleteUserModal) {
            cancelDeleteBtn.addEventListener('click', function() {
                deleteUserModal.classList.remove('show');
            });
        }

        if (confirmDeleteBtn && deleteUserForm) {
            confirmDeleteBtn.addEventListener('click', function() {
                deleteUserForm.submit();
            });
        }

        // Edit from view button
        const editFromViewBtn = document.querySelector('.edit-from-view-btn');
        if (editFromViewBtn && userModal && viewUserModal) {
            editFromViewBtn.addEventListener('click', function() {
                const userName = document.getElementById('viewUserName').textContent;
                const userId = document.querySelector('.view-user-btn[data-id]').getAttribute(
                    'data-id');

                viewUserModal.classList.remove('show');

                document.getElementById('userModalTitle').textContent = 'Edit User';
                document.getElementById('form-method').value = 'PUT';
                userForm.action = "{{ url('admin/users') }}/" + userId;

                fetch("{{ url('admin/users') }}/" + userId)
                    .then(response => response.json())
                    .then(data => {
                        const user = data.user;
                        document.getElementById('firstname').value = user.firstname;
                        document.getElementById('lastname').value = user.lastname;
                        document.getElementById('email').value = user.email;
                        document.getElementById('role_id').value = user.role_id;
                        document.getElementById('status').value = user.status;

                        document.getElementById('password').value = '';
                        document.getElementById('password_confirmation').value = '';

                        userModal.classList.add('show');
                    })
                    .catch(error => {
                        console.error('Error fetching user data:', error);
                    });
            });
        }

        // User Registration Chart
        const userRegistrationCtx = document.getElementById('userRegistrationChart');
        if (userRegistrationCtx) {
            const chartData = @json($chartData);
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const chartValues = Object.values(chartData);

            const userRegistrationChart = new Chart(userRegistrationCtx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'New Users',
                        data: chartValues,
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
                            position: 'top'
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
                                text: 'Number of Users'
                            }
                        }
                    }
                }
            });
        }

        // Search functionality
        const searchInput = document.getElementById('user-search-input');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('.user-table tbody tr');

                rows.forEach(row => {
                    const name = row.querySelector('.user-table-name')?.textContent
                        .toLowerCase() || '';
                    const email = row.querySelector('td:nth-child(2)')?.textContent
                        .toLowerCase() || '';

                    if (name.includes(searchTerm) || email.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }

        // Filter functionality
        const applyFiltersBtn = document.getElementById('apply-filters-btn');
        if (applyFiltersBtn) {
            applyFiltersBtn.addEventListener('click', function() {
                const roleFilter = document.getElementById('role-filter').value;
                const statusFilter = document.getElementById('status-filter').value;
                const rows = document.querySelectorAll('.user-table tbody tr');

                rows.forEach(row => {
                    const role = row.querySelector('.role-badge')?.textContent.trim()
                        .toLowerCase() || '';
                    const status = row.querySelector('.status-badge')?.textContent.trim()
                        .toLowerCase() || '';

                    const roleMatch = !roleFilter || role === roleFilter.toLowerCase();
                    const statusMatch = !statusFilter || status === statusFilter.toLowerCase();

                    if (roleMatch && statusMatch) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endsection
