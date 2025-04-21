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

        .top-posts-card {
            margin-top: 30px;
        }
    </style>
@endsection

@section('content')
    <!-- Main Content -->
    @section('header-title', 'Forum Management')
    <main class="admin-main">
        <div class="page-header">
            <div>
                <h2 class="page-header-title">Forum Management</h2>
                <p class="page-header-description">Manage all forum groups, posts, and comments for the World Cup 2030
                    community</p>
            </div>
            <div class="page-header-actions">
                <button class="btn btn-outline" id="createAnnouncementBtn">
                    <i class="fas fa-bullhorn"></i> Create Announcement
                </button>
                <button class="btn btn-primary" id="addGroupBtn">
                    <i class="fas fa-plus"></i> Add Group
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
                    <div class="stats-value">{{ number_format($totalGroups) }}</div>
                    <div class="stats-label">Groups</div>
                </div>
            </div>

            <div class="forum-stats-card">
                <div class="stats-icon stats-icon-threads">
                    <i class="fas fa-comments"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-value">{{ number_format($totalPosts) }}</div>
                    <div class="stats-label">Total Posts</div>
                </div>
            </div>

            <div class="forum-stats-card">
                <div class="stats-icon stats-icon-posts">
                    <i class="fas fa-comment-alt"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-value">{{ number_format($totalComments) }}</div>
                    <div class="stats-label">Total Comments</div>
                </div>
            </div>

            <div class="forum-stats-card">
                <div class="stats-icon stats-icon-users">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-value">{{ number_format($activeUsers) }}</div>
                    <div class="stats-label">Active Users</div>
                </div>
            </div>
        </div>

        <!-- Forum Tabs -->
        <div class="tab-container">
            <div class="tab-nav">
                <div class="tab-btn active" data-tab="groups">Groups</div>
                <div class="tab-btn" data-tab="posts">Recent Posts</div>
                <div class="tab-btn" data-tab="comments">Recent Comments</div>
                <div class="tab-btn" data-tab="top-posts">Top Posts</div>
            </div>

            <!-- Groups Tab -->
            <div class="tab-content active" id="groups-tab">
                <!-- Forum Search & Filters -->
                <div class="forum-search">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" id="group-search" placeholder="Search groups...">
                </div>

                <!-- Groups Table -->
                <div class="forum-table-container">
                    <div class="table-responsive">
                        <table class="forum-table">
                            <thead>
                                <tr>
                                    <th>Group</th>
                                    <th>Created By</th>
                                    <th>Posts</th>
                                    <th>Comments</th>
                                    <th>Last Activity</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topGroups as $group)
                                    <tr>
                                        <td>
                                            <div class="forum-table-name">
                                                <div class="forum-table-icon"
                                                    style="background-color: var(--primary-light); color: var(--primary);">
                                                    <i class="fas fa-users"></i>
                                                </div>
                                                <div>
                                                    <div>{{ $group->name }}</div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ Str::limit($group->description, 50) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $group->createdBy->firstname }} {{ $group->createdBy->lastname }}</td>
                                        <td>{{ $group->posts_count }}</td>
                                        <td>{{ $group->comments_count ?? 0 }}</td>
                                        <td>{{ $group->updated_at->diffForHumans() }}</td>
                                        <td>
                                            <div class="forum-table-actions">
                                                <button class="btn btn-sm btn-outline view-group-btn"
                                                    data-id="{{ $group->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline edit-group-btn"
                                                    data-id="{{ $group->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline btn-danger delete-group-btn"
                                                    data-id="{{ $group->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">No groups found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Posts Tab -->
            <div class="tab-content" id="posts-tab">
                <!-- Post Search & Filters -->
                <div class="forum-search">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" id="post-search" placeholder="Search posts...">
                </div>

                <!-- Posts List -->
                <div class="forum-card">
                    <div class="forum-card-header">
                        <h3>Recent Posts</h3>
                    </div>
                    <div class="forum-card-body">
                        <div class="post-list">
                            @forelse($recentPosts as $post)
                                <div class="post-item">
                                    <div class="post-header">
                                        <div class="post-author">
                                            <div class="post-avatar">
                                                <img src="{{ $post->user->image ?? 'https://via.placeholder.com/40x40' }}"
                                                    alt="User Avatar">
                                            </div>
                                            <div class="post-author-info">
                                                <div class="post-author-name">{{ $post->user->firstname }}
                                                    {{ $post->user->lastname }}</div>
                                                <div class="post-date">{{ $post->created_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                        <div class="post-actions">
                                            <button class="btn btn-sm btn-outline btn-danger delete-post-btn"
                                                data-id="{{ $post->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="post-content">
                                        {{ $post->content }}
                                    </div>
                                    <div class="post-footer">
                                        <div class="post-meta">
                                            <div class="post-likes">
                                                <i class="fas fa-thumbs-up"></i> {{ $post->likes_count }} Likes
                                            </div>
                                            <div class="post-comments">
                                                <i class="fas fa-comment"></i> {{ $post->comments_count }} Comments
                                            </div>
                                            <div class="post-group">
                                                <i class="fas fa-folder"></i> {{ $post->group->name }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">No posts found</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comments Tab -->
            <div class="tab-content" id="comments-tab">
                <!-- Comment Search & Filters -->
                <div class="forum-search">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" id="comment-search" placeholder="Search comments...">
                </div>

                <!-- Comments List -->
                <div class="forum-card">
                    <div class="forum-card-header">
                        <h3>Recent Comments</h3>
                    </div>
                    <div class="forum-card-body">
                        <div class="post-list">
                            @forelse($recentComments as $comment)
                                <div class="post-item">
                                    <div class="post-header">
                                        <div class="post-author">
                                            <div class="post-avatar">
                                                <img src="{{ $comment->user->image ?? 'https://via.placeholder.com/40x40' }}"
                                                    alt="User Avatar">
                                            </div>
                                            <div class="post-author-info">
                                                <div class="post-author-name">{{ $comment->user->firstname }}
                                                    {{ $comment->user->lastname }}</div>
                                                <div class="post-date">{{ $comment->created_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                        <div class="post-actions">
                                            <button class="btn btn-sm btn-outline btn-danger delete-comment-btn"
                                                data-id="{{ $comment->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="post-content">
                                        {{ $comment->content }}
                                    </div>
                                    <div class="post-footer">
                                        <div class="post-meta">
                                            <div class="post-on">
                                                <i class="fas fa-reply"></i> Comment on:
                                                {{ Str::limit($comment->post->content, 50) }}
                                            </div>
                                            <div class="post-group">
                                                <i class="fas fa-folder"></i> {{ $comment->post->group->name }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">No comments found</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Posts Tab -->
            <div class="tab-content" id="top-posts-tab">
                <!-- Top Posts List -->
                <div class="forum-card">
                    <div class="forum-card-header">
                        <h3>Top Posts by Engagement</h3>
                    </div>
                    <div class="forum-card-body">
                        <div class="post-list">
                            @forelse($topPosts as $post)
                                <div class="post-item">
                                    <div class="post-header">
                                        <div class="post-author">
                                            <div class="post-avatar">
                                                <img src="{{ $post->user->image ?? 'https://via.placeholder.com/40x40' }}"
                                                    alt="User Avatar">
                                            </div>
                                            <div class="post-author-info">
                                                <div class="post-author-name">{{ $post->user->firstname }}
                                                    {{ $post->user->lastname }}</div>
                                                <div class="post-date">{{ $post->created_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                        <div class="post-actions">
                                            <button class="btn btn-sm btn-outline btn-danger delete-post-btn"
                                                data-id="{{ $post->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="post-content">
                                        {{ $post->content }}
                                    </div>
                                    <div class="post-footer">
                                        <div class="post-meta">
                                            <div class="post-likes">
                                                <i class="fas fa-thumbs-up"></i> {{ $post->likes_count }} Likes
                                            </div>
                                            <div class="post-comments">
                                                <i class="fas fa-comment"></i> {{ $post->comments_count }} Comments
                                            </div>
                                            <div class="post-group">
                                                <i class="fas fa-folder"></i> {{ $post->group->name }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">No top posts found</div>
                            @endforelse
                        </div>
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
    <!-- Add/Edit Group Modal -->
    <div class="modal" id="groupModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="groupModalTitle">Add New Group</h3>
                <button class="modal-close" id="closeGroupModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="groupForm" method="POST" action="{{ route('admin.forum.store-group') }}">
                    @csrf
                    <input type="hidden" name="_method" id="form-method" value="POST">
                    <input type="hidden" name="group_id" id="group_id" value="">

                    <div class="forum-form-group">
                        <label class="forum-form-label" for="name">Group Name</label>
                        <input type="text" class="forum-form-control" id="name" name="name"
                            placeholder="Enter group name" required>
                    </div>

                    <div class="forum-form-group">
                        <label class="forum-form-label" for="description">Description</label>
                        <textarea class="forum-form-control" id="description" name="description" rows="3"
                            placeholder="Enter group description" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" id="cancelGroupBtn">Cancel</button>
                <button class="btn btn-primary" id="saveGroupBtn">Save Group</button>
            </div>
        </div>
    </div>

    <!-- View Group Modal -->
    <div class="modal" id="viewGroupModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="viewGroupModalTitle">Group Details</h3>
                <button class="modal-close" id="closeViewGroupModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="forum-card">
                    <div class="forum-card-header">
                        <div class="forum-icon" id="viewGroupIcon"
                            style="background-color: var(--primary-light); color: var(--primary);">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="forum-info">
                            <div class="forum-name" id="viewGroupName"></div>
                            <div class="forum-description" id="viewGroupDescription"></div>
                        </div>
                    </div>
                    <div class="forum-card-body">
                        <div class="forum-details">
                            <div class="forum-detail">
                                <div class="detail-label">Created By</div>
                                <div class="detail-value" id="viewGroupCreator"></div>
                            </div>
                            <div class="forum-detail">
                                <div class="detail-label">Posts</div>
                                <div class="detail-value" id="viewGroupPosts"></div>
                            </div>
                            <div class="forum-detail">
                                <div class="detail-label">Comments</div>
                                <div class="detail-value" id="viewGroupComments"></div>
                            </div>
                            <div class="forum-detail">
                                <div class="detail-label">Last Activity</div>
                                <div class="detail-value" id="viewGroupActivity"></div>
                            </div>
                        </div>

                        <h4 class="mt-4 mb-2">Recent Posts</h4>
                        <div class="thread-list" id="viewGroupPostsList">
                            <!-- Posts will be loaded dynamically -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" id="closeViewGroupBtn">Close</button>
                <button class="btn btn-primary edit-from-view-btn">Edit Group</button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal" id="deleteGroupModal">
        <div class="modal-content modal-sm">
            <div class="modal-header">
                <h3 class="modal-title">Confirm Delete</h3>
                <button class="modal-close" id="closeDeleteModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this group? This action cannot be undone.</p>
                <p><strong>Group: </strong><span id="deleteGroupName"></span></p>
                <p class="text-danger"><strong>Warning:</strong> Deleting this group will also delete all posts and
                    comments within it.</p>
                <form id="delete-group-form" method="POST" action="">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" id="cancelDeleteBtn">Cancel</button>
                <button class="btn btn-danger" id="confirmDeleteBtn">Delete Group</button>
            </div>
        </div>
    </div>

    <!-- Create Announcement Modal -->
    <div class="modal" id="announcementModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Create Announcement</h3>
                <button class="modal-close" id="closeAnnouncementModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="announcementForm" method="POST" action="{{ route('admin.forum.create-announcement') }}">
                    @csrf
                    <div class="forum-form-group">
                        <label class="forum-form-label" for="announcement_content">Announcement Content</label>
                        <textarea class="forum-form-control" id="announcement_content" name="content" rows="4"
                            placeholder="Enter announcement content" required></textarea>
                    </div>

                    <div class="forum-form-group">
                        <label class="forum-form-label">Send To</label>
                        <div class="radio-group">
                            <div class="radio-item">
                                <input type="radio" id="send_all" name="send_to" value="all" checked>
                                <label for="send_all">All Users</label>
                            </div>
                            {{-- <div class="radio-item">
                                <input type="radio" id="send_specific" name="send_to" value="specific">
                                <label for="send_specific">Specific Users</label>
                            </div> --}}
                        </div>
                    </div>

                    {{-- <div class="forum-form-group" id="specific_users_container" style="display: none;">
                        <label class="forum-form-label" for="user_ids">Select Users</label>
                        <select class="forum-form-control" id="user_ids" name="user_ids[]" multiple>
                            <!-- Users will be loaded dynamically -->
                        </select>
                    </div> --}}
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" id="cancelAnnouncementBtn">Cancel</button>
                <button class="btn btn-primary" id="saveAnnouncementBtn">Send Announcement</button>
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

            // Group Modal
            const groupModal = document.getElementById('groupModal');
            const addGroupBtn = document.getElementById('addGroupBtn');
            const closeGroupModal = document.getElementById('closeGroupModal');
            const cancelGroupBtn = document.getElementById('cancelGroupBtn');
            const saveGroupBtn = document.getElementById('saveGroupBtn');
            const editGroupBtns = document.querySelectorAll('.edit-group-btn');
            const groupForm = document.getElementById('groupForm');

            if (addGroupBtn && groupModal) {
                addGroupBtn.addEventListener('click', function() {
                    document.getElementById('groupModalTitle').textContent = 'Add New Group';
                    document.getElementById('form-method').value = 'POST';
                    document.getElementById('group_id').value = '';
                    groupForm.action = "{{ route('admin.forum.store-group') }}";
                    groupForm.reset();
                    groupModal.classList.add('show');
                });
            }

            if (closeGroupModal && groupModal) {
                closeGroupModal.addEventListener('click', function() {
                    groupModal.classList.remove('show');
                });
            }

            if (cancelGroupBtn && groupModal) {
                cancelGroupBtn.addEventListener('click', function() {
                    groupModal.classList.remove('show');
                });
            }

            if (saveGroupBtn && groupForm) {
                saveGroupBtn.addEventListener('click', function() {
                    groupForm.submit();
                });
            }

            if (editGroupBtns.length && groupModal) {
                editGroupBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const groupId = this.getAttribute('data-id');
                        document.getElementById('groupModalTitle').textContent = 'Edit Group';
                        document.getElementById('form-method').value = 'PUT';
                        document.getElementById('group_id').value = groupId;
                        groupForm.action = "{{ url('admin/forum/groups') }}/" + groupId;

                        // Fetch group data and populate the form
                        fetch("{{ url('admin/forum/groups') }}/" + groupId)
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('name').value = data.group.name;
                                document.getElementById('description').value = data.group
                                    .description;

                                groupModal.classList.add('show');
                            })
                            .catch(error => {
                                console.error('Error fetching group data:', error);
                            });
                    });
                });
            }

            // View Group Modal
            const viewGroupModal = document.getElementById('viewGroupModal');
            const viewGroupBtns = document.querySelectorAll('.view-group-btn');
            const closeViewGroupModal = document.getElementById('closeViewGroupModal');
            const closeViewGroupBtn = document.getElementById('closeViewGroupBtn');

            if (viewGroupBtns.length && viewGroupModal) {
                viewGroupBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const groupId = this.getAttribute('data-id');

                        // Fetch group data and populate the modal
                        fetch("{{ url('admin/forum/groups') }}/" + groupId)
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('viewGroupName').textContent = data
                                    .group.name;
                                document.getElementById('viewGroupDescription').textContent =
                                    data.group.description;
                                document.getElementById('viewGroupCreator').textContent =
                                    `${data.group.created_by.firstname} ${data.group.created_by.lastname}`;
                                document.getElementById('viewGroupPosts').textContent = data
                                    .group.posts_count;
                                document.getElementById('viewGroupComments').textContent = data
                                    .commentCount;
                                document.getElementById('viewGroupActivity').textContent = data
                                    .lastActivity;

                                // Populate recent posts
                                const postsList = document.getElementById('viewGroupPostsList');
                                postsList.innerHTML = '';

                                if (data.group.posts && data.group.posts.length > 0) {
                                    data.group.posts.forEach(post => {
                                        const postItem = document.createElement('div');
                                        postItem.className = 'thread-item';
                                        postItem.innerHTML = `
                                        <div class="thread-icon thread-icon-normal">
                                            <i class="fas fa-comment"></i>
                                        </div>
                                        <div class="thread-content">
                                            <div class="thread-title">${post.content.substring(0, 50)}${post.content.length > 50 ? '...' : ''}</div>
                                            <div class="thread-meta">
                                                <div class="thread-author">
                                                    <i class="fas fa-user"></i> ${post.user.firstname} ${post.user.lastname}
                                                </div>
                                                <div class="thread-date">
                                                    <i class="fas fa-calendar"></i> ${new Date(post.created_at).toLocaleString()}
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                        postsList.appendChild(postItem);
                                    });
                                } else {
                                    postsList.innerHTML =
                                        '<div class="text-center py-4">No posts found in this group</div>';
                                }

                                viewGroupModal.classList.add('show');
                            })
                            .catch(error => {
                                console.error('Error fetching group data:', error);
                            });
                    });
                });
            }

            if (closeViewGroupModal && viewGroupModal) {
                closeViewGroupModal.addEventListener('click', function() {
                    viewGroupModal.classList.remove('show');
                });
            }

            if (closeViewGroupBtn && viewGroupModal) {
                closeViewGroupBtn.addEventListener('click', function() {
                    viewGroupModal.classList.remove('show');
                });
            }

            // Delete Group Modal
            const deleteGroupModal = document.getElementById('deleteGroupModal');
            const deleteGroupBtns = document.querySelectorAll('.delete-group-btn');
            const closeDeleteModal = document.getElementById('closeDeleteModal');
            const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            const deleteGroupForm = document.getElementById('delete-group-form');

            if (deleteGroupBtns.length && deleteGroupModal) {
                deleteGroupBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const groupId = this.getAttribute('data-id');
                        const groupName = this.closest('tr').querySelector(
                            '.forum-table-name div:first-child').textContent.trim();

                        document.getElementById('deleteGroupName').textContent = groupName;
                        deleteGroupForm.action = "{{ url('admin/forum/groups') }}/" + groupId;

                        deleteGroupModal.classList.add('show');
                    });
                });
            }

            if (closeDeleteModal && deleteGroupModal) {
                closeDeleteModal.addEventListener('click', function() {
                    deleteGroupModal.classList.remove('show');
                });
            }

            if (cancelDeleteBtn && deleteGroupModal) {
                cancelDeleteBtn.addEventListener('click', function() {
                    deleteGroupModal.classList.remove('show');
                });
            }

            if (confirmDeleteBtn && deleteGroupForm) {
                confirmDeleteBtn.addEventListener('click', function() {
                    deleteGroupForm.submit();
                });
            }

            // Edit from view button
            const editFromViewBtn = document.querySelector('.edit-from-view-btn');
            if (editFromViewBtn && groupModal && viewGroupModal) {
                editFromViewBtn.addEventListener('click', function() {
                    const groupName = document.getElementById('viewGroupName').textContent;
                    const groupDescription = document.getElementById('viewGroupDescription').textContent;
                    const groupId = document.querySelector('.view-group-btn[data-id]').getAttribute(
                        'data-id');

                    viewGroupModal.classList.remove('show');

                    document.getElementById('groupModalTitle').textContent = 'Edit Group';
                    document.getElementById('form-method').value = 'PUT';
                    document.getElementById('group_id').value = groupId;
                    groupForm.action = "{{ url('admin/forum/groups') }}/" + groupId;

                    document.getElementById('name').value = groupName;
                    document.getElementById('description').value = groupDescription;

                    groupModal.classList.add('show');
                });
            }

            // Announcement Modal
            const announcementModal = document.getElementById('announcementModal');
            const createAnnouncementBtn = document.getElementById('createAnnouncementBtn');
            const closeAnnouncementModal = document.getElementById('closeAnnouncementModal');
            const cancelAnnouncementBtn = document.getElementById('cancelAnnouncementBtn');
            const saveAnnouncementBtn = document.getElementById('saveAnnouncementBtn');
            const announcementForm = document.getElementById('announcementForm');
            const sendAllRadio = document.getElementById('send_all');
            const sendSpecificRadio = document.getElementById('send_specific');
            const specificUsersContainer = document.getElementById('specific_users_container');

            if (createAnnouncementBtn && announcementModal) {
                createAnnouncementBtn.addEventListener('click', function() {
                    announcementForm.reset();
                    announcementModal.classList.add('show');
                });
            }

            if (closeAnnouncementModal && announcementModal) {
                closeAnnouncementModal.addEventListener('click', function() {
                    announcementModal.classList.remove('show');
                });
            }

            if (cancelAnnouncementBtn && announcementModal) {
                cancelAnnouncementBtn.addEventListener('click', function() {
                    announcementModal.classList.remove('show');
                });
            }

            if (saveAnnouncementBtn && announcementForm) {
                saveAnnouncementBtn.addEventListener('click', function() {
                    announcementForm.submit();
                });
            }

            if (sendAllRadio && sendSpecificRadio && specificUsersContainer) {
                sendAllRadio.addEventListener('change', function() {
                    if (this.checked) {
                        specificUsersContainer.style.display = 'none';
                    }
                });

                sendSpecificRadio.addEventListener('change', function() {
                    if (this.checked) {
                        specificUsersContainer.style.display = 'block';

                        // Load users if not already loaded
                        const userSelect = document.getElementById('user_ids');
                        if (userSelect && userSelect.options.length <= 1) {
                            fetch("{{ route('admin.users.list') }}")
                                .then(response => response.json())
                                .then(data => {
                                    userSelect.innerHTML = '';
                                    data.forEach(user => {
                                        const option = document.createElement('option');
                                        option.value = user.id;
                                        option.textContent =
                                            `${user.firstname} ${user.lastname} (${user.email})`;
                                        userSelect.appendChild(option);
                                    });
                                })
                                .catch(error => {
                                    console.error('Error fetching users:', error);
                                });
                        }
                    }
                });
            }

            // Delete Post and Comment buttons
            const deletePostBtns = document.querySelectorAll('.delete-post-btn');
            const deleteCommentBtns = document.querySelectorAll('.delete-comment-btn');

            if (deletePostBtns.length) {
                deletePostBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        if (confirm(
                                'Are you sure you want to delete this post? This will also delete all comments on this post.'
                            )) {
                            const postId = this.getAttribute('data-id');

                            // Create and submit a form to delete the post
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = "{{ url('admin/forum/posts') }}/" + postId;

                            const csrfToken = document.createElement('input');
                            csrfToken.type = 'hidden';
                            csrfToken.name = '_token';
                            csrfToken.value = "{{ csrf_token() }}";
                            form.appendChild(csrfToken);

                            const method = document.createElement('input');
                            method.type = 'hidden';
                            method.name = '_method';
                            method.value = 'DELETE';
                            form.appendChild(method);

                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            }

            if (deleteCommentBtns.length) {
                deleteCommentBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        if (confirm('Are you sure you want to delete this comment?')) {
                            const commentId = this.getAttribute('data-id');

                            // Create and submit a form to delete the comment
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = "{{ url('admin/forum/comments') }}/" + commentId;

                            const csrfToken = document.createElement('input');
                            csrfToken.type = 'hidden';
                            csrfToken.name = '_token';
                            csrfToken.value = "{{ csrf_token() }}";
                            form.appendChild(csrfToken);

                            const method = document.createElement('input');
                            method.type = 'hidden';
                            method.name = '_method';
                            method.value = 'DELETE';
                            form.appendChild(method);

                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            }

            // Search functionality
            const groupSearch = document.getElementById('group-search');
            const postSearch = document.getElementById('post-search');
            const commentSearch = document.getElementById('comment-search');

            if (groupSearch) {
                groupSearch.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();
                    const rows = document.querySelectorAll('.forum-table tbody tr');

                    rows.forEach(row => {
                        const groupName = row.querySelector('.forum-table-name div:first-child')
                            ?.textContent.toLowerCase() || '';
                        const groupDesc = row.querySelector('.forum-table-name .text-sm')
                            ?.textContent.toLowerCase() || '';

                        if (groupName.includes(searchTerm) || groupDesc.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }

            if (postSearch) {
                postSearch.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();
                    const postItems = document.querySelectorAll('#posts-tab .post-item');

                    postItems.forEach(item => {
                        const postContent = item.querySelector('.post-content')?.textContent
                            .toLowerCase() || '';
                        const authorName = item.querySelector('.post-author-name')?.textContent
                            .toLowerCase() || '';

                        if (postContent.includes(searchTerm) || authorName.includes(searchTerm)) {
                            item.style.display = '';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            }

            if (commentSearch) {
                commentSearch.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();
                    const commentItems = document.querySelectorAll('#comments-tab .post-item');

                    commentItems.forEach(item => {
                        const commentContent = item.querySelector('.post-content')?.textContent
                            .toLowerCase() || '';
                        const authorName = item.querySelector('.post-author-name')?.textContent
                            .toLowerCase() || '';

                        if (commentContent.includes(searchTerm) || authorName.includes(
                                searchTerm)) {
                            item.style.display = '';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            }

            // Forum Activity Chart
            const forumActivityCtx = document.getElementById('forumActivityChart');
            if (forumActivityCtx) {
                const monthlyPosts = @json($monthlyPosts);
                const monthlyComments = @json($monthlyComments);
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

                const forumActivityChart = new Chart(forumActivityCtx, {
                    type: 'line',
                    data: {
                        labels: months,
                        datasets: [{
                                label: 'New Posts',
                                data: monthlyPosts,
                                borderColor: '#e63946',
                                backgroundColor: 'rgba(230, 57, 70, 0.1)',
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'New Comments',
                                data: monthlyComments,
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
                                    text: 'Posts'
                                }
                            },
                            y1: {
                                position: 'right',
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Comments'
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
