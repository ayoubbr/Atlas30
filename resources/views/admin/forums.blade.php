@extends('admin.layout')

@section('title', 'Forum Management - World Cup 2030')

@section('css')
<style>
    /* Forum-specific styles */
    .forum-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .forum-card {
        background-color: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        transition: var(--transition);
    }
    
    .forum-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
    }
    
    .forum-card-header {
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        border-bottom: 1px solid var(--gray-200);
    }
    
    .forum-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        background-color: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    
    .forum-info {
        flex: 1;
    }
    
    .forum-name {
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 5px;
    }
    
    .forum-description {
        font-size: 0.85rem;
        color: var(--gray-600);
        line-height: 1.4;
    }
    
    .forum-card-body {
        padding: 20px;
    }
    
    .forum-details {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
    
    .forum-detail {
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
    
    .forum-card-footer {
        padding: 15px 20px;
        border-top: 1px solid var(--gray-200);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: var(--gray-50);
    }
    
    .forum-status {
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .status-active {
        color: var(--success);
    }
    
    .status-locked {
        color: var(--warning);
    }
    
    .status-archived {
        color: var(--gray-600);
    }
    
    .status-hidden {
        color: var(--danger);
    }
    
    .forum-actions {
        display: flex;
        gap: 10px;
    }
    
    .forum-table-container {
        background-color: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .forum-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .forum-table th,
    .forum-table td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid var(--gray-200);
    }
    
    .forum-table th {
        background-color: var(--gray-100);
        font-weight: 600;
        color: var(--gray-700);
    }
    
    .forum-table tbody tr:hover {
        background-color: var(--gray-50);
    }
    
    .forum-table tbody tr:last-child td {
        border-bottom: none;
    }
    
    .forum-table-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background-color: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-right: 10px;
    }
    
    .forum-table-name {
        display: flex;
        align-items: center;
        font-weight: 600;
    }
    
    .forum-table-actions {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }
    
    .category-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    .category-general {
        background-color: var(--primary-light);
        color: var(--primary);
    }
    
    .category-teams {
        background-color: var(--info-light);
        color: var(--info);
    }
    
    .category-matches {
        background-color: var(--success-light);
        color: var(--success);
    }
    
    .category-tickets {
        background-color: var(--warning-light);
        color: var(--warning);
    }
    
    .category-predictions {
        background-color: var(--secondary-light);
        color: var(--secondary);
    }
    
    .forum-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .filter-group {
        flex: 1;
        min-width: 200px;
    }
    
    .forum-stats-card {
        background-color: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        padding: 20px;
        display: flex;
        align-items: center;
        transition: var(--transition);
    }
    
    .forum-stats-card:hover {
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
    
    .stats-icon-categories {
        color: var(--primary);
    }
    
    .stats-icon-threads {
        color: var(--info);
    }
    
    .stats-icon-posts {
        color: var(--success);
    }
    
    .stats-icon-users {
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
    
    .forum-search {
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
    
    .forum-form-group {
        margin-bottom: 20px;
    }
    
    .forum-form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .forum-form-control {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid var(--gray-300);
        border-radius: var(--border-radius);
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
    }
    
    .forum-form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.1);
    }
    
    .forum-form-row {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }
    
    .forum-form-col {
        flex: 1;
    }
    
    .thread-list {
        max-height: 300px;
        overflow-y: auto;
    }
    
    .thread-item {
        display: flex;
        padding: 12px 0;
        border-bottom: 1px solid var(--gray-200);
    }
    
    .thread-item:last-child {
        border-bottom: none;
    }
    
    .thread-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background-color: var(--gray-100);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        flex-shrink: 0;
    }
    
    .thread-icon-sticky {
        color: var(--warning);
    }
    
    .thread-icon-normal {
        color: var(--info);
    }
    
    .thread-icon-locked {
        color: var(--gray-600);
    }
    
    .thread-icon-hot {
        color: var(--primary);
    }
    
    .thread-content {
        flex: 1;
    }
    
    .thread-title {
        margin-bottom: 5px;
        font-size: 0.95rem;
        font-weight: 600;
    }
    
    .thread-meta {
        font-size: 0.8rem;
        color: var(--gray-500);
        display: flex;
        gap: 15px;
    }
    
    .thread-author {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .thread-date {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .thread-replies {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .thread-views {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .post-list {
        max-height: 400px;
        overflow-y: auto;
    }
    
    .post-item {
        padding: 15px;
        border-bottom: 1px solid var(--gray-200);
    }
    
    .post-item:last-child {
        border-bottom: none;
    }
    
    .post-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    
    .post-author {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .post-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: var(--gray-200);
        overflow: hidden;
    }
    
    .post-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .post-author-info {
        display: flex;
        flex-direction: column;
    }
    
    .post-author-name {
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .post-date {
        font-size: 0.8rem;
        color: var(--gray-500);
    }
    
    .post-actions {
        display: flex;
        gap: 10px;
    }
    
    .post-content {
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 15px;
    }
    
    .post-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.8rem;
        color: var(--gray-500);
    }
    
    .post-meta {
        display: flex;
        gap: 15px;
    }
    
    .post-likes,
    .post-reports {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .post-moderation {
        display: flex;
        gap: 10px;
    }
    
    .report-list {
        max-height: 300px;
        overflow-y: auto;
    }
    
    .report-item {
        padding: 15px;
        border-bottom: 1px solid var(--gray-200);
    }
    
    .report-item:last-child {
        border-bottom: none;
    }
    
    .report-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    
    .report-type {
        font-weight: 600;
        color: var(--danger);
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .report-date {
        font-size: 0.8rem;
        color: var(--gray-500);
    }
    
    .report-content {
        background-color: var(--gray-100);
        padding: 10px;
        border-radius: var(--border-radius);
        margin-bottom: 10px;
        font-size: 0.9rem;
    }
    
    .report-reporter {
        font-size: 0.85rem;
        margin-bottom: 10px;
    }
    
    .report-actions {
        display: flex;
        gap: 10px;
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
    
    .forum-activity-chart {
        height: 300px;
        margin-top: 20px;
    }
    
    .tab-container {
        margin-bottom: 30px;
    }
    
    .tab-nav {
        display: flex;
        border-bottom: 1px solid var(--gray-300);
        margin-bottom: 20px;
    }
    
    .tab-btn {
        padding: 10px 20px;
        font-weight: 600;
        color: var(--gray-600);
        cursor: pointer;
        border-bottom: 3px solid transparent;
        transition: var(--transition);
    }
    
    .tab-btn:hover {
        color: var(--primary);
    }
    
    .tab-btn.active {
        color: var(--primary);
        border-bottom-color: var(--primary);
    }
    
    .tab-content {
        display: none;
    }
    
    .tab-content.active {
        display: block;
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
        <h1 class="page-title">Forum Management</h1>
    </div>
    
    <div class="header-right">
        <div class="header-search">
            <input type="text" class="search-input" placeholder="Search forums...">
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
                <img src="https://cdn-icons-png.flaticon.com/128/6024/6024190.png" alt="Admin Avatar">
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
            <h2 class="page-header-title">Forum Management</h2>
            <p class="page-header-description">Manage all forum categories, threads, and posts for the World Cup 2030 community</p>
        </div>
        <div class="page-header-actions">
            <button class="btn btn-outline" id="exportForumsBtn">
                <i class="fas fa-file-export"></i> Export Data
            </button>
            <button class="btn btn-primary" id="addCategoryBtn">
                <i class="fas fa-plus"></i> Add Category
            </button>
        </div>
    </div>
    
    <!-- Forum Stats -->
    <div class="forum-stats">
        <div class="forum-stats-card">
            <div class="stats-icon stats-icon-categories">
                <i class="fas fa-folder"></i>
            </div>
            <div class="stats-content">
                <div class="stats-value">12</div>
                <div class="stats-label">Categories</div>
            </div>
        </div>
        
        <div class="forum-stats-card">
            <div class="stats-icon stats-icon-threads">
                <i class="fas fa-comments"></i>
            </div>
            <div class="stats-content">
                <div class="stats-value">1,248</div>
                <div class="stats-label">Total Threads</div>
            </div>
        </div>
        
        <div class="forum-stats-card">
            <div class="stats-icon stats-icon-posts">
                <i class="fas fa-comment-alt"></i>
            </div>
            <div class="stats-content">
                <div class="stats-value">24,567</div>
                <div class="stats-label">Total Posts</div>
            </div>
        </div>
        
        <div class="forum-stats-card">
            <div class="stats-icon stats-icon-users">
                <i class="fas fa-users"></i>
            </div>
            <div class="stats-content">
                <div class="stats-value">8,742</div>
                <div class="stats-label">Active Users</div>
            </div>
        </div>
    </div>
    
    <!-- Forum Tabs -->
    <div class="tab-container">
        <div class="tab-nav">
            <div class="tab-btn active" data-tab="categories">Categories</div>
            <div class="tab-btn" data-tab="threads">Recent Threads</div>
            <div class="tab-btn" data-tab="posts">Recent Posts</div>
            <div class="tab-btn" data-tab="reports">Reports</div>
        </div>
        
        <!-- Categories Tab -->
        <div class="tab-content active" id="categories-tab">
            <!-- Forum Search & Filters -->
            <div class="forum-search">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search categories...">
            </div>
            
            <div class="forum-filters">
                <div class="filter-group">
                    <label for="status-filter">Status</label>
                    <select id="status-filter" class="filter-select">
                        <option value="">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="locked">Locked</option>
                        <option value="archived">Archived</option>
                        <option value="hidden">Hidden</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="sort-filter">Sort By</label>
                    <select id="sort-filter" class="filter-select">
                        <option value="name">Name</option>
                        <option value="threads">Thread Count</option>
                        <option value="posts">Post Count</option>
                        <option value="activity">Last Activity</option>
                    </select>
                </div>
                
                <div class="filter-group" style="display: flex; align-items: flex-end;">
                    <button class="btn btn-primary">
                        <i class="fas fa-filter"></i> Apply Filters
                    </button>
                </div>
            </div>
            
            <!-- Categories Table -->
            <div class="forum-table-container">
                <div class="table-responsive">
                    <table class="forum-table">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Threads</th>
                                <th>Posts</th>
                                <th>Last Activity</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="forum-table-name">
                                        <div class="forum-table-icon" style="background-color: var(--primary-light); color: var(--primary);">
                                            <i class="fas fa-bullhorn"></i>
                                        </div>
                                        <div>
                                            <div>Announcements</div>
                                            <div class="text-sm text-gray-500">Official World Cup 2030 announcements</div>
                                        </div>
                                    </div>
                                </td>
                                <td>24</td>
                                <td>156</td>
                                <td>Today, 10:45 AM</td>
                                <td><span class="status-badge status-scheduled">Active</span></td>
                                <td>
                                    <div class="forum-table-actions">
                                        <button class="btn btn-sm btn-outline view-category-btn" data-id="1">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline edit-category-btn" data-id="1">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline btn-danger delete-category-btn" data-id="1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="forum-table-name">
                                        <div class="forum-table-icon" style="background-color: var(--info-light); color: var(--info);">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <div>
                                            <div>Teams Discussion</div>
                                            <div class="text-sm text-gray-500">Discuss participating teams and players</div>
                                        </div>
                                    </div>
                                </td>
                                <td>342</td>
                                <td>5,678</td>
                                <td>Today, 11:30 AM</td>
                                <td><span class="status-badge status-scheduled">Active</span></td>
                                <td>
                                    <div class="forum-table-actions">
                                        <button class="btn btn-sm btn-outline view-category-btn" data-id="2">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline edit-category-btn" data-id="2">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline btn-danger delete-category-btn" data-id="2">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="forum-table-name">
                                        <div class="forum-table-icon" style="background-color: var(--success-light); color: var(--success);">
                                            <i class="fas fa-futbol"></i>
                                        </div>
                                        <div>
                                            <div>Match Discussions</div>
                                            <div class="text-sm text-gray-500">Discuss matches and results</div>
                                        </div>
                                    </div>
                                </td>
                                <td>287</td>
                                <td>4,321</td>
                                <td>Today, 9:15 AM</td>
                                <td><span class="status-badge status-scheduled">Active</span></td>
                                <td>
                                    <div class="forum-table-actions">
                                        <button class="btn btn-sm btn-outline view-category-btn" data-id="3">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline edit-category-btn" data-id="3">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline btn-danger delete-category-btn" data-id="3">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="forum-table-name">
                                        <div class="forum-table-icon" style="background-color: var(--warning-light); color: var(--warning);">
                                            <i class="fas fa-ticket-alt"></i>
                                        </div>
                                        <div>
                                            <div>Tickets & Travel</div>
                                            <div class="text-sm text-gray-500">Discuss tickets, travel, and accommodation</div>
                                        </div>
                                    </div>
                                </td>
                                <td>198</td>
                                <td>3,456</td>
                                <td>Yesterday, 3:20 PM</td>
                                <td><span class="status-badge status-scheduled">Active</span></td>
                                <td>
                                    <div class="forum-table-actions">
                                        <button class="btn btn-sm btn-outline view-category-btn" data-id="4">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline edit-category-btn" data-id="4">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline btn-danger delete-category-btn" data-id="4">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="forum-table-name">
                                        <div class="forum-table-icon" style="background-color: var(--secondary-light); color: var(--secondary);">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                        <div>
                                            <div>Predictions & Analysis</div>
                                            <div class="text-sm text-gray-500">Share your predictions and analysis</div>
                                        </div>
                                    </div>
                                </td>
                                <td>245</td>
                                <td>4,789</td>
                                <td>Today, 8:45 AM</td>
                                <td><span class="status-badge status-scheduled">Active</span></td>
                                <td>
                                    <div class="forum-table-actions">
                                        <button class="btn btn-sm btn-outline view-category-btn" data-id="5">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline edit-category-btn" data-id="5">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline btn-danger delete-category-btn" data-id="5">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="forum-table-name">
                                        <div class="forum-table-icon" style="background-color: var(--gray-200); color: var(--gray-700);">
                                            <i class="fas fa-globe"></i>
                                        </div>
                                        <div>
                                            <div>Fan Zone</div>
                                            <div class="text-sm text-gray-500">General discussions for fans</div>
                                        </div>
                                    </div>
                                </td>
                                <td>152</td>
                                <td>6,167</td>
                                <td>Today, 11:15 AM</td>
                                <td><span class="status-badge status-live">Locked</span></td>
                                <td>
                                    <div class="forum-table-actions">
                                        <button class="btn btn-sm btn-outline view-category-btn" data-id="6">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline edit-category-btn" data-id="6">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline btn-danger delete-category-btn" data-id="6">
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
                        Showing 1-6 of 12 categories
                    </div>
                    <button class="pagination-btn">
                        Next <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Threads Tab -->
        <div class="tab-content" id="threads-tab">
            <!-- Thread Search & Filters -->
            <div class="forum-search">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search threads...">
            </div>
            
            <div class="forum-filters">
                <div class="filter-group">
                    <label for="thread-category-filter">Category</label>
                    <select id="thread-category-filter" class="filter-select">
                        <option value="">All Categories</option>
                        <option value="announcements">Announcements</option>
                        <option value="teams">Teams Discussion</option>
                        <option value="matches">Match Discussions</option>
                        <option value="tickets">Tickets & Travel</option>
                        <option value="predictions">Predictions & Analysis</option>
                        <option value="fan">Fan Zone</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="thread-status-filter">Status</label>
                    <select id="thread-status-filter" class="filter-select">
                        <option value="">All Statuses</option>
                        <option value="open">Open</option>
                        <option value="sticky">Sticky</option>
                        <option value="locked">Locked</option>
                        <option value="hidden">Hidden</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="thread-sort-filter">Sort By</label>
                    <select id="thread-sort-filter" class="filter-select">
                        <option value="recent">Most Recent</option>
                        <option value="replies">Most Replies</option>
                        <option value="views">Most Views</option>
                        <option value="activity">Recent Activity</option>
                    </select>
                </div>
                
                <div class="filter-group" style="display: flex; align-items: flex-end;">
                    <button class="btn btn-primary">
                        <i class="fas fa-filter"></i> Apply Filters
                    </button>
                </div>
            </div>
            
            <!-- Threads List -->
            <div class="forum-card">
                <div class="forum-card-header">
                    <h3>Recent Threads</h3>
                </div>
                <div class="forum-card-body">
                    <div class="thread-list">
                        <div class="thread-item">
                            <div class="thread-icon thread-icon-sticky">
                                <i class="fas fa-thumbtack"></i>
                            </div>
                            <div class="thread-content">
                                <div class="thread-title">Official World Cup 2030 Schedule Announcement</div>
                                <div class="thread-meta">
                                    <div class="thread-author">
                                        <i class="fas fa-user"></i> Admin
                                    </div>
                                    <div class="thread-date">
                                        <i class="fas fa-calendar"></i> Today, 10:45 AM
                                    </div>
                                    <div class="thread-replies">
                                        <i class="fas fa-comment"></i> 24 Replies
                                    </div>
                                    <div class="thread-views">
                                        <i class="fas fa-eye"></i> 1,245 Views
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="thread-item">
                            <div class="thread-icon thread-icon-hot">
                                <i class="fas fa-fire"></i>
                            </div>
                            <div class="thread-content">
                                <div class="thread-title">Brazil vs Germany: The Rematch of the Century</div>
                                <div class="thread-meta">
                                    <div class="thread-author">
                                        <i class="fas fa-user"></i> SoccerFan123
                                    </div>
                                    <div class="thread-date">
                                        <i class="fas fa-calendar"></i> Yesterday, 3:20 PM
                                    </div>
                                    <div class="thread-replies">
                                        <i class="fas fa-comment"></i> 87 Replies
                                    </div>
                                    <div class="thread-views">
                                        <i class="fas fa-eye"></i> 3,456 Views
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="thread-item">
                            <div class="thread-icon thread-icon-normal">
                                <i class="fas fa-comment"></i>
                            </div>
                            <div class="thread-content">
                                <div class="thread-title">Best Accommodation Options Near Stadium A</div>
                                <div class="thread-meta">
                                    <div class="thread-author">
                                        <i class="fas fa-user"></i> TravelExpert
                                    </div>
                                    <div class="thread-date">
                                        <i class="fas fa-calendar"></i> 2 days ago
                                    </div>
                                    <div class="thread-replies">
                                        <i class="fas fa-comment"></i> 42 Replies
                                    </div>
                                    <div class="thread-views">
                                        <i class="fas fa-eye"></i> 1,890 Views
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="thread-item">
                            <div class="thread-icon thread-icon-locked">
                                <i class="fas fa-lock"></i>
                            </div>
                            <div class="thread-content">
                                <div class="thread-title">Ticket Exchange Thread [CLOSED]</div>
                                <div class="thread-meta">
                                    <div class="thread-author">
                                        <i class="fas fa-user"></i> Moderator
                                    </div>
                                    <div class="thread-date">
                                        <i class="fas fa-calendar"></i> 1 week ago
                                    </div>
                                    <div class="thread-replies">
                                        <i class="fas fa-comment"></i> 156 Replies
                                    </div>
                                    <div class="thread-views">
                                        <i class="fas fa-eye"></i> 5,678 Views
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="thread-item">
                            <div class="thread-icon thread-icon-normal">
                                <i class="fas fa-comment"></i>
                            </div>
                            <div class="thread-content">
                                <div class="thread-title">Who Will Win the Golden Boot?</div>
                                <div class="thread-meta">
                                    <div class="thread-author">
                                        <i class="fas fa-user"></i> FootballAnalyst
                                    </div>
                                    <div class="thread-date">
                                        <i class="fas fa-calendar"></i> 3 days ago
                                    </div>
                                    <div class="thread-replies">
                                        <i class="fas fa-comment"></i> 78 Replies
                                    </div>
                                    <div class="thread-views">
                                        <i class="fas fa-eye"></i> 2,345 Views
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="forum-card-footer">
                    <button class="btn btn-outline">
                        <i class="fas fa-eye"></i> View All Threads
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Posts Tab -->
        <div class="tab-content" id="posts-tab">
            <!-- Post Search & Filters -->
            <div class="forum-search">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search posts...">
            </div>
            
            <div class="forum-filters">
                <div class="filter-group">
                    <label for="post-category-filter">Category</label>
                    <select id="post-category-filter" class="filter-select">
                        <option value="">All Categories</option>
                        <option value="announcements">Announcements</option>
                        <option value="teams">Teams Discussion</option>
                        <option value="matches">Match Discussions</option>
                        <option value="tickets">Tickets & Travel</option>
                        <option value="predictions">Predictions & Analysis</option>
                        <option value="fan">Fan Zone</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="post-user-filter">User</label>
                    <input type="text" id="post-user-filter" class="filter-select" placeholder="Filter by username">
                </div>
                
                <div class="filter-group">
                    <label for="post-date-filter">Date Range</label>
                    <select id="post-date-filter" class="filter-select">
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                        <option value="all">All Time</option>
                    </select>
                </div>
                
                <div class="filter-group" style="display: flex; align-items: flex-end;">
                    <button class="btn btn-primary">
                        <i class="fas fa-filter"></i> Apply Filters
                    </button>
                </div>
            </div>
            
            <!-- Posts List -->
            <div class="forum-card">
                <div class="forum-card-header">
                    <h3>Recent Posts</h3>
                </div>
                <div class="forum-card-body">
                    <div class="post-list">
                        <div class="post-item">
                            <div class="post-header">
                                <div class="post-author">
                                    <div class="post-avatar">
                                        <img src="https://via.placeholder.com/40x40" alt="User Avatar">
                                    </div>
                                    <div class="post-author-info">
                                        <div class="post-author-name">SoccerFan123</div>
                                        <div class="post-date">Today, 10:45 AM</div>
                                    </div>
                                </div>
                                <div class="post-actions">
                                    <button class="btn btn-sm btn-outline">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="post-content">
                                I think Brazil has a strong chance of winning this time. Their squad depth is incredible, and with the new coach's tactics, they look unstoppable!
                            </div>
                            <div class="post-footer">
                                <div class="post-meta">
                                    <div class="post-likes">
                                        <i class="fas fa-thumbs-up"></i> 24 Likes
                                    </div>
                                    <div class="post-reports">
                                        <i class="fas fa-flag"></i> 0 Reports
                                    </div>
                                </div>
                                <div class="post-moderation">
                                    <button class="btn btn-sm btn-outline">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                    <button class="btn btn-sm btn-outline">
                                        <i class="fas fa-ban"></i> Hide
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="post-item">
                            <div class="post-header">
                                <div class="post-author">
                                    <div class="post-avatar">
                                        <img src="https://via.placeholder.com/40x40" alt="User Avatar">
                                    </div>
                                    <div class="post-author-info">
                                        <div class="post-author-name">FootballAnalyst</div>
                                        <div class="post-date">Yesterday, 3:20 PM</div>
                                    </div>
                                </div>
                                <div class="post-actions">
                                    <button class="btn btn-sm btn-outline">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="post-content">
                                Looking at the historical data, Germany tends to perform exceptionally well in tournaments held in this region. Their tactical discipline and tournament experience give them an edge over other teams.
                            </div>
                            <div class="post-footer">
                                <div class="post-meta">
                                    <div class="post-likes">
                                        <i class="fas fa-thumbs-up"></i> 18 Likes
                                    </div>
                                    <div class="post-reports">
                                        <i class="fas fa-flag"></i> 0 Reports
                                    </div>
                                </div>
                                <div class="post-moderation">
                                    <button class="btn btn-sm btn-outline">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                    <button class="btn btn-sm btn-outline">
                                        <i class="fas fa-ban"></i> Hide
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="post-item">
                            <div class="post-header">
                                <div class="post-author">
                                    <div class="post-avatar">
                                        <img src="https://via.placeholder.com/40x40" alt="User Avatar">
                                    </div>
                                    <div class="post-author-info">
                                        <div class="post-author-name">TravelExpert</div>
                                        <div class="post-date">2 days ago</div>
                                    </div>
                                </div>
                                <div class="post-actions">
                                    <button class="btn btn-sm btn-outline">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="post-content">
                                For those looking for accommodation near Stadium A, I highly recommend checking out the hotels in District X. They're offering special rates for World Cup attendees and are just a 10-minute walk from the stadium.
                            </div>
                            <div class="post-footer">
                                <div class="post-meta">
                                    <div class="post-likes">
                                        <i class="fas fa-thumbs-up"></i> 42 Likes
                                    </div>
                                    <div class="post-reports">
                                        <i class="fas fa-flag"></i> 1 Report
                                    </div>
                                </div>
                                <div class="post-moderation">
                                    <button class="btn btn-sm btn-outline">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                    <button class="btn btn-sm btn-outline">
                                        <i class="fas fa-ban"></i> Hide
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="forum-card-footer">
                    <button class="btn btn-outline">
                        <i class="fas fa-eye"></i> View All Posts
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Reports Tab -->
        <div class="tab-content" id="reports-tab">
            <!-- Reports Search & Filters -->
            <div class="forum-search">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search reports...">
            </div>
            
            <div class="forum-filters">
                <div class="filter-group">
                    <label for="report-type-filter">Report Type</label>
                    <select id="report-type-filter" class="filter-select">
                        <option value="">All Types</option>
                        <option value="spam">Spam</option>
                        <option value="inappropriate">Inappropriate Content</option>
                        <option value="harassment">Harassment</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="report-status-filter">Status</label>
                    <select id="report-status-filter" class="filter-select">
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="resolved">Resolved</option>
                        <option value="dismissed">Dismissed</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="report-date-filter">Date Range</label>
                    <select id="report-date-filter" class="filter-select">
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                        <option value="all">All Time</option>
                    </select>
                </div>
                
                <div class="filter-group" style="display: flex; align-items: flex-end;">
                    <button class="btn btn-primary">
                        <i class="fas fa-filter"></i> Apply Filters
                    </button>
                </div>
            </div>
            
            <!-- Reports List -->
            <div class="forum-card">
                <div class="forum-card-header">
                    <h3>Recent Reports</h3>
                </div>
                <div class="forum-card-body">
                    <div class="report-list">
                        <div class="report-item">
                            <div class="report-header">
                                <div class="report-type">
                                    <i class="fas fa-exclamation-triangle"></i> Inappropriate Content
                                </div>
                                <div class="report-date">Today, 10:45 AM</div>
                            </div>
                            <div class="report-content">
                                This post contains offensive language and should be removed.
                            </div>
                            <div class="report-reporter">
                                <strong>Reported by:</strong> User123 | <strong>Post by:</strong> TravelExpert
                            </div>
                            <div class="report-actions">
                                <button class="btn btn-sm btn-outline">
                                    <i class="fas fa-eye"></i> View Post
                                </button>
                                <button class="btn btn-sm btn-outline btn-success">
                                    <i class="fas fa-check"></i> Resolve
                                </button>
                                <button class="btn btn-sm btn-outline">
                                    <i class="fas fa-times"></i> Dismiss
                                </button>
                                <button class="btn btn-sm btn-outline btn-danger">
                                    <i class="fas fa-trash"></i> Delete Post
                                </button>
                            </div>
                        </div>
                        <div class="report-item">
                            <div class="report-header">
                                <div class="report-type">
                                    <i class="fas fa-exclamation-triangle"></i> Spam
                                </div>
                                <div class="report-date">Yesterday, 3:20 PM</div>
                            </div>
                            <div class="report-content">
                                This user is posting the same advertisement in multiple threads.
                            </div>
                            <div class="report-reporter">
                                <strong>Reported by:</strong> Moderator1 | <strong>Post by:</strong> NewUser456
                            </div>
                            <div class="report-actions">
                                <button class="btn btn-sm btn-outline">
                                    <i class="fas fa-eye"></i> View Post
                                </button>
                                <button class="btn btn-sm btn-outline btn-success">
                                    <i class="fas fa-check"></i> Resolve
                                </button>
                                <button class="btn btn-sm btn-outline">
                                    <i class="fas fa-times"></i> Dismiss
                                </button>
                                <button class="btn btn-sm btn-outline btn-danger">
                                    <i class="fas fa-trash"></i> Delete Post
                                </button>
                            </div>
                        </div>
                        <div class="report-item">
                            <div class="report-header">
                                <div class="report-type">
                                    <i class="fas fa-exclamation-triangle"></i> Harassment
                                </div>
                                <div class="report-date">3 days ago</div>
                            </div>
                            <div class="report-content">
                                This user is targeting me with negative comments across multiple threads.
                            </div>
                            <div class="report-reporter">
                                <strong>Reported by:</strong> FootballFan789 | <strong>Post by:</strong> SoccerCritic
                            </div>
                            <div class="report-actions">
                                <button class="btn btn-sm btn-outline">
                                    <i class="fas fa-eye"></i> View Post
                                </button>
                                <button class="btn btn-sm btn-outline btn-success">
                                    <i class="fas fa-check"></i> Resolve
                                </button>
                                <button class="btn btn-sm btn-outline">
                                    <i class="fas fa-times"></i> Dismiss
                                </button>
                                <button class="btn btn-sm btn-outline btn-danger">
                                    <i class="fas fa-trash"></i> Delete Post
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="forum-card-footer">
                    <button class="btn btn-outline">
                        <i class="fas fa-eye"></i> View All Reports
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Forum Activity Chart -->
    <div class="forum-card">
        <div class="forum-card-header">
            <h3>Forum Activity Trend</h3>
        </div>
        <div class="forum-card-body">
            <div class="forum-activity-chart">
                <canvas id="forumActivityChart"></canvas>
            </div>
        </div>
    </div>
</main>
@endsection

@section('modal')
<!-- Add/Edit Category Modal -->
<div class="modal" id="categoryModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="categoryModalTitle">Add New Category</h3>
            <button class="modal-close" id="closeCategoryModal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="categoryForm">
                <div class="forum-form-group">
                    <label class="forum-form-label" for="categoryName">Category Name</label>
                    <input type="text" class="forum-form-control" id="categoryName" placeholder="Enter category name">
                </div>
                
                <div class="forum-form-group">
                    <label class="forum-form-label" for="categoryDescription">Description</label>
                    <textarea class="forum-form-control" id="categoryDescription" rows="3" placeholder="Enter category description"></textarea>
                </div>
                
                <div class="forum-form-row">
                    <div class="forum-form-col">
                        <div class="forum-form-group">
                            <label class="forum-form-label" for="categoryIcon">Icon</label>
                            <select class="forum-form-control" id="categoryIcon">
                                <option value="bullhorn">Announcement (Bullhorn)</option>
                                <option value="users">Teams (Users)</option>
                                <option value="futbol">Matches (Football)</option>
                                <option value="ticket-alt">Tickets (Ticket)</option>
                                <option value="chart-line">Predictions (Chart)</option>
                                <option value="globe">General (Globe)</option>
                                <option value="comments">Discussion (Comments)</option>
                                <option value="question">Help (Question)</option>
                            </select>
                        </div>
                    </div>
                    <div class="forum-form-col">
                        <div class="forum-form-group">
                            <label class="forum-form-label" for="categoryColor">Color</label>
                            <select class="forum-form-control" id="categoryColor">
                                <option value="primary">Red (Primary)</option>
                                <option value="secondary">Blue (Secondary)</option>
                                <option value="info">Light Blue (Info)</option>
                                <option value="success">Green (Success)</option>
                                <option value="warning">Yellow (Warning)</option>
                                <option value="danger">Dark Red (Danger)</option>
                                <option value="gray">Gray</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="forum-form-row">
                    <div class="forum-form-col">
                        <div class="forum-form-group">
                            <label class="forum-form-label" for="categoryStatus">Status</label>
                            <select class="forum-form-control" id="categoryStatus">
                                <option value="active">Active</option>
                                <option value="locked">Locked</option>
                                <option value="archived">Archived</option>
                                <option value="hidden">Hidden</option>
                            </select>
                        </div>
                    </div>
                    <div class="forum-form-col">
                        <div class="forum-form-group">
                            <label class="forum-form-label" for="categoryOrder">Display Order</label>
                            <input type="number" class="forum-form-control" id="categoryOrder" placeholder="Enter display order">
                        </div>
                    </div>
                </div>
                
                <div class="forum-form-group">
                    <label class="forum-form-label">Permissions</label>
                    <div class="permissions-list">
                        <div class="permission-item">
                            <input type="checkbox" class="permission-checkbox" id="perm_view_all">
                            <label class="permission-label" for="perm_view_all">All Users Can View</label>
                        </div>
                        <div class="permission-item">
                            <input type="checkbox" class="permission-checkbox" id="perm_create_all">
                            <label class="permission-label" for="perm_create_all">All Users Can Create Threads</label>
                        </div>
                        <div class="permission-item">
                            <input type="checkbox" class="permission-checkbox" id="perm_reply_all">
                            <label class="permission-label" for="perm_reply_all">All Users Can Reply</label>
                        </div>
                        <div class="permission-item">
                            <input type="checkbox" class="permission-checkbox" id="perm_mod_only">
                            <label class="permission-label" for="perm_mod_only">Moderator Only</label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" id="cancelCategoryBtn">Cancel</button>
            <button class="btn btn-primary" id="saveCategoryBtn">Save Category</button>
        </div>
    </div>
</div>

<!-- View Category Modal -->
<div class="modal" id="viewCategoryModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="viewCategoryModalTitle">Category Details</h3>
            <button class="modal-close  id="viewCategoryModalTitle">Category Details</h3>
            <button class="modal-close" id="closeViewCategoryModal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="forum-card">
                <div class="forum-card-header">
                    <div class="forum-icon" id="viewCategoryIcon" style="background-color: var(--primary-light); color: var(--primary);">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <div class="forum-info">
                        <div class="forum-name" id="viewCategoryName">Announcements</div>
                        <div class="forum-description" id="viewCategoryDescription">Official World Cup 2030 announcements</div>
                    </div>
                </div>
                <div class="forum-card-body">
                    <div class="forum-details">
                        <div class="forum-detail">
                            <div class="detail-label">Status</div>
                            <div class="detail-value" id="viewCategoryStatus">Active</div>
                        </div>
                        <div class="forum-detail">
                            <div class="detail-label">Threads</div>
                            <div class="detail-value" id="viewCategoryThreads">24</div>
                        </div>
                        <div class="forum-detail">
                            <div class="detail-label">Posts</div>
                            <div class="detail-value" id="viewCategoryPosts">156</div>
                        </div>
                        <div class="forum-detail">
                            <div class="detail-label">Last Activity</div>
                            <div class="detail-value" id="viewCategoryActivity">Today, 10:45 AM</div>
                        </div>
                    </div>
                    
                    <h4 class="mt-4 mb-2">Recent Threads</h4>
                    <div class="thread-list" id="viewCategoryThreads">
                        <div class="thread-item">
                            <div class="thread-icon thread-icon-sticky">
                                <i class="fas fa-thumbtack"></i>
                            </div>
                            <div class="thread-content">
                                <div class="thread-title">Official World Cup 2030 Schedule Announcement</div>
                                <div class="thread-meta">
                                    <div class="thread-author">
                                        <i class="fas fa-user"></i> Admin
                                    </div>
                                    <div class="thread-date">
                                        <i class="fas fa-calendar"></i> Today, 10:45 AM
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="thread-item">
                            <div class="thread-icon thread-icon-normal">
                                <i class="fas fa-comment"></i>
                            </div>
                            <div class="thread-content">
                                <div class="thread-title">Ticket Sales Information</div>
                                <div class="thread-meta">
                                    <div class="thread-author">
                                        <i class="fas fa-user"></i> Moderator
                                    </div>
                                    <div class="thread-date">
                                        <i class="fas fa-calendar"></i> Yesterday, 3:20 PM
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" id="closeViewCategoryBtn">Close</button>
            <button class="btn btn-primary edit-from-view-btn">Edit Category</button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal" id="deleteCategoryModal">
    <div class="modal-content modal-sm">
        <div class="modal-header">
            <h3 class="modal-title">Confirm Delete</h3>
            <button class="modal-close" id="closeDeleteModal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this category? This action cannot be undone.</p>
            <p><strong>Category: </strong><span id="deleteCategoryName">Announcements</span></p>
            <p class="text-danger"><strong>Warning:</strong> Deleting this category will also delete all threads and posts within it.</p>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" id="cancelDeleteBtn">Cancel</button>
            <button class="btn btn-danger" id="confirmDeleteBtn">Delete Category</button>
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
        
        // Tab Navigation
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');
        
        if (tabBtns.length) {
            tabBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const tabId = this.getAttribute('data-tab');
                    
                    // Remove active class from all tabs
                    tabBtns.forEach(b => b.classList.remove('active'));
                    tabContents.forEach(c => c.classList.remove('active'));
                    
                    // Add active class to current tab
                    this.classList.add('active');
                    document.getElementById(`${tabId}-tab`).classList.add('active');
                });
            });
        }
        
        // Category Modal
        const categoryModal = document.getElementById('categoryModal');
        const addCategoryBtn = document.getElementById('addCategoryBtn');
        const closeCategoryModal = document.getElementById('closeCategoryModal');
        const cancelCategoryBtn = document.getElementById('cancelCategoryBtn');
        const editCategoryBtns = document.querySelectorAll('.edit-category-btn');
        
        if (addCategoryBtn && categoryModal) {
            addCategoryBtn.addEventListener('click', function() {
                document.getElementById('categoryModalTitle').textContent = 'Add New Category';
                document.getElementById('categoryForm').reset();
                categoryModal.classList.add('show');
            });
        }
        
        if (closeCategoryModal && categoryModal) {
            closeCategoryModal.addEventListener('click', function() {
                categoryModal.classList.remove('show');
            });
        }
        
        if (cancelCategoryBtn && categoryModal) {
            cancelCategoryBtn.addEventListener('click', function() {
                categoryModal.classList.remove('show');
            });
        }
        
        if (editCategoryBtns.length && categoryModal) {
            editCategoryBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const categoryId = this.getAttribute('data-id');
                    document.getElementById('categoryModalTitle').textContent = 'Edit Category';
                    
                    // Here you would fetch category data and populate the form
                    // For now, we'll just show the modal
                    categoryModal.classList.add('show');
                });
            });
        }
        
        // View Category Modal
        const viewCategoryModal = document.getElementById('viewCategoryModal');
        const viewCategoryBtns = document.querySelectorAll('.view-category-btn');
        const closeViewCategoryModal = document.getElementById('closeViewCategoryModal');
        const closeViewCategoryBtn = document.getElementById('closeViewCategoryBtn');
        
        if (viewCategoryBtns.length && viewCategoryModal) {
            viewCategoryBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const categoryId = this.getAttribute('data-id');
                    
                    // Here you would fetch category data and populate the modal
                    // For now, we'll just show the modal
                    viewCategoryModal.classList.add('show');
                });
            });
        }
        
        if (closeViewCategoryModal && viewCategoryModal) {
            closeViewCategoryModal.addEventListener('click', function() {
                viewCategoryModal.classList.remove('show');
            });
        }
        
        if (closeViewCategoryBtn && viewCategoryModal) {
            closeViewCategoryBtn.addEventListener('click', function() {
                viewCategoryModal.classList.remove('show');
            });
        }
        
        // Delete Category Modal
        const deleteCategoryModal = document.getElementById('deleteCategoryModal');
        const deleteCategoryBtns = document.querySelectorAll('.delete-category-btn');
        const closeDeleteModal = document.getElementById('closeDeleteModal');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        
        if (deleteCategoryBtns.length && deleteCategoryModal) {
            deleteCategoryBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const categoryId = this.getAttribute('data-id');
                    
                    // Here you would fetch category name and set it in the modal
                    // For now, we'll just show the modal
                    deleteCategoryModal.classList.add('show');
                });
            });
        }
        
        if (closeDeleteModal && deleteCategoryModal) {
            closeDeleteModal.addEventListener('click', function() {
                deleteCategoryModal.classList.remove('show');
            });
        }
        
        if (cancelDeleteBtn && deleteCategoryModal) {
            cancelDeleteBtn.addEventListener('click', function() {
                deleteCategoryModal.classList.remove('show');
            });
        }
        
        if (confirmDeleteBtn && deleteCategoryModal) {
            confirmDeleteBtn.addEventListener('click', function() {
                // Here you would delete the category
                // For now, we'll just close the modal
                deleteCategoryModal.classList.remove('show');
            });
        }
        
        // Edit from view button
        const editFromViewBtn = document.querySelector('.edit-from-view-btn');
        if (editFromViewBtn && categoryModal && viewCategoryModal) {
            editFromViewBtn.addEventListener('click', function() {
                viewCategoryModal.classList.remove('show');
                
                document.getElementById('categoryModalTitle').textContent = 'Edit Category';
                
                // Here you would populate the form with the category data
                // For now, we'll just show the modal
                categoryModal.classList.add('show');
            });
        }
        
        // Forum Activity Chart
        const forumActivityCtx = document.getElementById('forumActivityChart');
        if (forumActivityCtx) {
            const forumActivityChart = new Chart(forumActivityCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [
                        {
                            label: 'New Threads',
                            data: [45, 59, 80, 81, 56, 55, 40, 65, 78, 92, 108, 120],
                            borderColor: '#e63946',
                            backgroundColor: 'rgba(230, 57, 70, 0.1)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'New Posts',
                            data: [280, 480, 770, 890, 1100, 1200, 1380, 1500, 1780, 1950, 2100, 2350],
                            borderColor: '#3498db',
                            backgroundColor: 'rgba(52, 152, 219, 0.1)',
                            tension: 0.4,
                            fill: true,
                            yAxisID: 'y1'
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
                                text: 'Threads'
                            }
                        },
                        y1: {
                            position: 'right',
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Posts'
                            },
                            grid: {
                                drawOnChartArea: false
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endsection