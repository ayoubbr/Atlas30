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
        width: 60px;
        height: 60px;
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
    
    .user-name {
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 5px;
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
    
    .stats-icon-online {
        color: var(--warning);
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
    
    .activity-item {
        display: flex;
        padding: 12px 0;
        border-bottom: 1px solid var(--gray-200);
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .activity-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: var(--gray-100);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        flex-shrink: 0;
    }
    
    .activity-icon-login {
        color: var(--success);
    }
    
    .activity-icon-purchase {
        color: var(--primary);
    }
    
    .activity-icon-forum {
        color: var(--info);
    }
    
    .activity-icon-profile {
        color: var(--warning);
    }
    
    .activity-content {
        flex: 1;
    }
    
    .activity-text {
        margin-bottom: 5px;
        font-size: 0.9rem;
    }
    
    .activity-time {
        font-size: 0.8rem;
        color: var(--gray-500);
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
</style>
@endsection

@section('content')
<!-- Header -->
<header class="admin-header">
    <div class="header-left">
        <div class="menu-toggle" id="menu-toggle">
            <i class="fas fa-bars"></i>
        </div>
        <h1 class="page-title">User Management</h1>
    </div>
    
    <div class="header-right">
        <div class="header-search">
            <input type="text" class="search-input" placeholder="Search users...">
            <i class="fas fa-search search-icon"></i>
        </div>
        
        <div class="header-actions">
            <div class="action-btn">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">5</span>
            </div>
            <div class="action-btn">
                <i class="fas fa-envelope"></i>
                <span class="notification-badge">3</span>
            </div>
        </div>
        
        <div class="user-profile">
            <div class="user-avatar">
                <img src="https://via.placeholder.com/40x40" alt="Admin Avatar">
            </div>
            <div class="user-info">
                <div class="user-name">John Doe</div>
                <div class="user-role">Administrator</div>
            </div>
        </div>
    </div>
</header>

<!-- Main Content -->
<main class="admin-main">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="page-header-title">User Management</h2>
            <p class="page-header-description">Manage all users of the World Cup 2030 platform</p>
        </div>
        <div class="page-header-actions">
            <button class="btn btn-outline" id="exportUsersBtn">
                <i class="fas fa-file-export"></i> Export Users
            </button>
            <button class="btn btn-primary" id="addUserBtn">
                <i class="fas fa-user-plus"></i> Add User
            </button>
        </div>
    </div>
    
    <!-- User Stats -->
    <div class="user-stats">
        <div class="user-stats-card">
            <div class="stats-icon stats-icon-users">
                <i class="fas fa-users"></i>
            </div>
            <div class="stats-content">
                <div class="stats-value">125,842</div>
                <div class="stats-label">Total Users</div>
            </div>
        </div>
        
        <div class="user-stats-card">
            <div class="stats-icon stats-icon-active">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stats-content">
                <div class="stats-value">98,651</div>
                <div class="stats-label">Active Users</div>
            </div>
        </div>
        
        <div class="user-stats-card">
            <div class="stats-icon stats-icon-new">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="stats-content">
                <div class="stats-value">1,248</div>
                <div class="stats-label">New Users (Last 7 Days)</div>
            </div>
        </div>
        
        <div class="user-stats-card">
            <div class="stats-icon stats-icon-online">
                <i class="fas fa-signal"></i>
            </div>
            <div class="stats-content">
                <div class="stats-value">3,542</div>
                <div class="stats-label">Online Now</div>
            </div>
        </div>
    </div>
    
    <!-- User Search & Filters -->
    <div class="user-search">
        <i class="fas fa-search search-icon"></i>
        <input type="text" class="search-input" placeholder="Search users by name, email, or location...">
    </div>
    
    <div class="match-filters">
        <div class="filter-group">
            <label for="role-filter">Role</label>
            <select id="role-filter" class="filter-select">
                <option value="">All Roles</option>
                <option value="admin">Administrator</option>
                <option value="moderator">Moderator</option>
                <option value="editor">Editor</option>
                <option value="user">Regular User</option>
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
        
        <div class="filter-group">
            <label for="registration-filter">Registration Date</label>
            <select id="registration-filter" class="filter-select">
                <option value="">All Time</option>
                <option value="today">Today</option>
                <option value="week">This Week</option>
                <option value="month">This Month</option>
                <option value="year">This Year</option>
            </select>
        </div>
        
        <div class="filter-group">
            <label for="sort-filter">Sort By</label>
            <select id="sort-filter" class="filter-select">
                <option value="name">Name</option>
                <option value="email">Email</option>
                <option value="registration">Registration Date</option>
                <option value="last_login">Last Login</option>
            </select>
        </div>
        
        <div class="filter-group" style="display: flex; align-items: flex-end;">
            <button class="btn btn-primary">
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
            <button class="view-btn">
                <i class="fas fa-th-large"></i> Card View
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
                    <tr>
                        <td>
                            <div class="user-table-name">
                                <div class="user-table-avatar" style="background-image: url('https://via.placeholder.com/40x40')"></div>
                                John Smith
                            </div>
                        </td>
                        <td>john.smith@example.com</td>
                        <td><span class="role-badge role-admin">Administrator</span></td>
                        <td>Jan 15, 2023</td>
                        <td>Today, 10:45 AM</td>
                        <td><span class="status-badge status-scheduled">Active</span></td>
                        <td>
                            <div class="user-table-actions">
                                <button class="btn btn-sm btn-outline view-user-btn" data-id="1">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline edit-user-btn" data-id="1">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline btn-danger delete-user-btn" data-id="1">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-table-name">
                                <div class="user-table-avatar" style="background-image: url('https://via.placeholder.com/40x40')"></div>
                                Maria Rodriguez
                            </div>
                        </td>
                        <td>maria.rodriguez@example.com</td>
                        <td><span class="role-badge role-moderator">Moderator</span></td>
                        <td>Mar 22, 2023</td>
                        <td>Yesterday, 3:20 PM</td>
                        <td><span class="status-badge status-scheduled">Active</span></td>
                        <td>
                            <div class="user-table-actions">
                                <button class="btn btn-sm btn-outline view-user-btn" data-id="2">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline edit-user-btn" data-id="2">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline btn-danger delete-user-btn" data-id="2">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-table-name">
                                <div class="user-table-avatar" style="background-image: url('https://via.placeholder.com/40x40')"></div>
                                David Johnson
                            </div>
                        </td>
                        <td>david.johnson@example.com</td>
                        <td><span class="role-badge role-editor">Editor</span></td>
                        <td>Apr 10, 2023</td>
                        <td>Today, 9:15 AM</td>
                        <td><span class="status-badge status-scheduled">Active</span></td>
                        <td>
                            <div class="user-table-actions">
                                <button class="btn btn-sm btn-outline view-user-btn" data-id="3">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline edit-user-btn" data-id="3">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline btn-danger delete-user-btn" data-id="3">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-table-name">
                                <div class="user-table-avatar" style="background-image: url('https://via.placeholder.com/40x40')"></div>
                                Sarah Williams
                            </div>
                        </td>
                        <td>sarah.williams@example.com</td>
                        <td><span class="role-badge role-user">Regular User</span></td>
                        <td>May 5, 2023</td>
                        <td>3 days ago</td>
                        <td><span class="status-badge status-live">Suspended</span></td>
                        <td>
                            <div class="user-table-actions">
                                <button class="btn btn-sm btn-outline view-user-btn" data-id="4">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline edit-user-btn" data-id="4">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline btn-danger delete-user-btn" data-id="4">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-table-name">
                                <div class="user-table-avatar" style="background-image: url('https://via.placeholder.com/40x40')"></div>
                                Michael Brown
                            </div>
                        </td>
                        <td>michael.brown@example.com</td>
                        <td><span class="role-badge role-user">Regular User</span></td>
                        <td>Jun 18, 2023</td>
                        <td>1 week ago</td>
                        <td><span class="status-badge status-cancelled">Banned</span></td>
                        <td>
                            <div class="user-table-actions">
                                <button class="btn btn-sm btn-outline view-user-btn" data-id="5">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline edit-user-btn" data-id="5">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline btn-danger delete-user-btn" data-id="5">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-table-name">
                                <div class="user-table-avatar" style="background-image: url('https://via.placeholder.com/40x40')"></div>
                                Emily Davis
                            </div>
                        </td>
                        <td>emily.davis@example.com</td>
                        <td><span class="role-badge role-user">Regular User</span></td>
                        <td>Jul 7, 2023</td>
                        <td>Today, 11:30 AM</td>
                        <td><span class="status-badge status-scheduled">Active</span></td>
                        <td>
                            <div class="user-table-actions">
                                <button class="btn btn-sm btn-outline view-user-btn" data-id="6">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline edit-user-btn" data-id="6">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline btn-danger delete-user-btn" data-id="6">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-table-name">
                                <div class="user-table-avatar" style="background-image: url('https://via.placeholder.com/40x40')"></div>
                                James Wilson
                            </div>
                        </td>
                        <td>james.wilson@example.com</td>
                        <td><span class="role-badge role-user">Regular User</span></td>
                        <td>Aug 12, 2023</td>
                        <td>2 days ago</td>
                        <td><span class="status-badge status-completed">Inactive</span></td>
                        <td>
                            <div class="user-table-actions">
                                <button class="btn btn-sm btn-outline view-user-btn" data-id="7">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline edit-user-btn" data-id="7">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline btn-danger delete-user-btn" data-id="7">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-table-name">
                                <div class="user-table-avatar" style="background-image: url('https://via.placeholder.com/40x40')"></div>
                                Sophia Martinez
                            </div>
                        </td>
                        <td>sophia.martinez@example.com</td>
                        <td><span class="role-badge role-user">Regular User</span></td>
                        <td>Sep 3, 2023</td>
                        <td>Today, 8:45 AM</td>
                        <td><span class="status-badge status-scheduled">Active</span></td>
                        <td>
                            <div class="user-table-actions">
                                <button class="btn btn-sm btn-outline view-user-btn" data-id="8">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline edit-user-btn" data-id="8">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline btn-danger delete-user-btn" data-id="8">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="pagination">
            <button class="pagination-btn" disabled>
                <i class="fas fa-chevron-left"></i> Previous
            </button>
            <div class="pagination-info">
                Showing 1-8 of 125,842 users
            </div>
            <button class="pagination-btn">
                Next <i class="fas fa-chevron-right"></i>
            </button>
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
            <form id="userForm">
                <div class="user-form-row">
                    <div class="user-form-col">
                        <div class="user-form-group">
                            <label class="user-form-label" for="firstName">First Name</label>
                            <input type="text" class="user-form-control" id="firstName" placeholder="Enter first name">
                        </div>
                    </div>
                    <div class="user-form-col">
                        <div class="user-form-group">
                            <label class="user-form-label" for="lastName">Last Name</label>
                            <input type="text" class="user-form-control" id="lastName" placeholder="Enter last name">
                        </div>
                    </div>
                </div>
                
                <div class="user-form-group">
                    <label class="user-form-label" for="email">Email Address</label>
                    <input type="email" class="user-form-control" id="email" placeholder="Enter email address">
                </div>
                
                <div class="user-form-row">
                    <div class="user-form-col">
                        <div class="user-form-group">
                            <label class="user-form-label" for="password">Password</label>
                            <input type="password" class="user-form-control" id="password" placeholder="Enter password">
                        </div>
                    </div>
                    <div class="user-form-col">
                        <div class="user-form-group">
                            <label class="user-form-label" for="confirmPassword">Confirm Password</label>
                            <input type="password" class="user-form-control" id="confirmPassword" placeholder="Confirm password">
                        </div>
                    </div>
                </div>
                
                <div class="user-form-row">
                    <div class="user-form-col">
                        <div class="user-form-group">
                            <label class="user-form-label" for="role">User Role</label>
                            <select class="user-form-control" id="role">
                                <option value="user">Regular User</option>
                                <option value="editor">Editor</option>
                                <option value="moderator">Moderator</option>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>
                    </div>
                    <div class="user-form-col">
                        <div class="user-form-group">
                            <label class="user-form-label" for="status">Account Status</label>
                            <select class="user-form-control" id="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="suspended">Suspended</option>
                                <option value="banned">Banned</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="user-form-group">
                    <label class="user-form-label" for="country">Country</label>
                    <select class="user-form-control" id="country">
                        <option value="">Select Country</option>
                        <option value="US">United States</option>
                        <option value="UK">United Kingdom</option>
                        <option value="CA">Canada</option>
                        <option value="AU">Australia</option>
                        <option value="BR">Brazil</option>
                        <option value="FR">France</option>
                        <option value="DE">Germany</option>
                        <option value="ES">Spain</option>
                        <option value="IT">Italy</option>
                        <option value="JP">Japan</option>
                    </select>
                </div>
                
                <div class="user-form-group">
                    <label class="user-form-label">Permissions</label>
                    <div class="permissions-list">
                        <div class="permission-item">
                            <input type="checkbox" class="permission-checkbox" id="perm_view_tickets">
                            <label class="permission-label" for="perm_view_tickets">View Tickets</label>
                        </div>
                        <div class="permission-item">
                            <input type="checkbox" class="permission-checkbox" id="perm_purchase_tickets">
                            <label class="permission-label" for="perm_purchase_tickets">Purchase Tickets</label>
                        </div>
                        <div class="permission-item">
                            <input type="checkbox" class="permission-checkbox" id="perm_view_matches">
                            <label class="permission-label" for="perm_view_matches">View Matches</label>
                        </div>
                        <div class="permission-item">
                            <input type="checkbox" class="permission-checkbox" id="perm_forum_access">
                            <label class="permission-label" for="perm_forum_access">Forum Access</label>
                        </div>
                        <div class="permission-item">
                            <input type="checkbox" class="permission-checkbox" id="perm_create_posts">
                            <label class="permission-label" for="perm_create_posts">Create Posts</label>
                        </div>
                        <div class="permission-item">
                            <input type="checkbox" class="permission-checkbox" id="perm_moderate_posts">
                            <label class="permission-label" for="perm_moderate_posts">Moderate Posts</label>
                        </div>
                        <div class="permission-item">
                            <input type="checkbox" class="permission-checkbox" id="perm_manage_users">
                            <label class="permission-label" for="perm_manage_users">Manage Users</label>
                        </div>
                        <div class="permission-item">
                            <input type="checkbox" class="permission-checkbox" id="perm_manage_content">
                            <label class="permission-label" for="perm_manage_content">Manage Content</label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" id="cancelUserBtn">Cancel</button>
            <button class="btn btn-primary" id="saveUserBtn">Save User</button>
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
                    <div class="user-avatar" id="viewUserAvatar" style="background-image: url('https://via.placeholder.com/60x60')"></div>
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
                            <div class="detail-label">Last Login</div>
                            <div class="detail-value" id="viewUserLastLogin">Today, 10:45 AM</div>
                        </div>
                        <div class="user-detail">
                            <div class="detail-label">Country</div>
                            <div class="detail-value" id="viewUserCountry">United States</div>
                        </div>
                        <div class="user-detail">
                            <div class="detail-label">Tickets Purchased</div>
                            <div class="detail-value" id="viewUserTickets">5</div>
                        </div>
                    </div>
                    
                    <h4 class="mt-4 mb-2">Recent Activity</h4>
                    <div class="user-activity-list" id="viewUserActivity">
                        <div class="activity-item">
                            <div class="activity-icon activity-icon-login">
                                <i class="fas fa-sign-in-alt"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-text">Logged in to the system</div>
                                <div class="activity-time">Today, 10:45 AM</div>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon activity-icon-purchase">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-text">Purchased 2 tickets for Brazil vs Germany</div>
                                <div class="activity-time">Yesterday, 3:20 PM</div>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon activity-icon-forum">
                                <i class="fas fa-comments"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-text">Posted a comment in "World Cup Predictions" forum</div>
                                <div class="activity-time">2 days ago</div>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon activity-icon-profile">
                                <i class="fas fa-user-edit"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-text">Updated profile information</div>
                                <div class="activity-time">1 week ago</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" id="closeViewUserBtn">Close</button>
            <button class="btn btn-primary edit-from-view-btn">Edit User</button>
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
        
        // View toggle
        const viewBtns = document.querySelectorAll('.view-btn');
        
        if (viewBtns.length) {
            viewBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    viewBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Here you would toggle between table and card view
                    // For now, we'll just keep the table view
                });
            });
        }
        
        // User Modal
        const userModal = document.getElementById('userModal');
        const addUserBtn = document.getElementById('addUserBtn');
        const closeUserModal = document.getElementById('closeUserModal');
        const cancelUserBtn = document.getElementById('cancelUserBtn');
        const editUserBtns = document.querySelectorAll('.edit-user-btn');
        
        if (addUserBtn && userModal) {
            addUserBtn.addEventListener('click', function() {
                document.getElementById('userModalTitle').textContent = 'Add New User';
                document.getElementById('userForm').reset();
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
                    
                    // Here you would fetch user data and populate the form
                    // For now, we'll just show the modal
                    userModal.classList.add('show');
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
                    
                    // Here you would fetch user data and populate the modal
                    // For now, we'll just show the modal
                    viewUserModal.classList.add('show');
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
        
        if (deleteUserBtns.length && deleteUserModal) {
            deleteUserBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const userId = this.getAttribute('data-id');
                    
                    // Here you would fetch user name and set it in the modal
                    // For now, we'll just show the modal
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
        
        if (confirmDeleteBtn && deleteUserModal) {
            confirmDeleteBtn.addEventListener('click', function() {
                // Here you would delete the user
                // For now, we'll just close the modal
                deleteUserModal.classList.remove('show');
            });
        }
        
        // Edit from view button
        const editFromViewBtn = document.querySelector('.edit-from-view-btn');
        if (editFromViewBtn && userModal && viewUserModal) {
            editFromViewBtn.addEventListener('click', function() {
                viewUserModal.classList.remove('show');
                
                document.getElementById('userModalTitle').textContent = 'Edit User';
                
                // Here you would populate the form with the user data
                // For now, we'll just show the modal
                userModal.classList.add('show');
            });
        }
        
        // User Registration Chart
        const userRegistrationCtx = document.getElementById('userRegistrationChart');
        if (userRegistrationCtx) {
            const userRegistrationChart = new Chart(userRegistrationCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [
                        {
                            label: 'New Users',
                            data: [1250, 1480, 1320, 1890, 2340, 2780, 3150, 3620, 4280, 4950, 5320, 5780],
                            borderColor: '#e63946',
                            backgroundColor: 'rgba(230, 57, 70, 0.1)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Active Users',
                            data: [980, 1120, 1050, 1420, 1780, 2150, 2480, 2850, 3320, 3780, 4150, 4520],
                            borderColor: '#3498db',
                            backgroundColor: 'rgba(52, 152, 219, 0.1)',
                            tension: 0.4,
                            fill: true
                        }
                    ]
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
    });
</script>
@endsection