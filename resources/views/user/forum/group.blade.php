@extends('user.layout')

@section('title', $group->name . ' - Forum - World Cup 2030')

@section('css')
    <style>
        /* Forum Layout */
        .forum-layout {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 60px;
        }

        .forum-main {
            flex: 3;
            min-width: 300px;
        }

        .forum-sidebar {
            flex: 1;
            min-width: 250px;
        }

        /* Forum Header */
        .forum-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .forum-title {
            font-size: 1.5rem;
        }

        .forum-actions {
            display: flex;
            gap: 10px;
        }

        /* Forum Search */
        .forum-search {
            margin-bottom: 30px;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 1px solid var(--gray-300);
            border-radius: 4px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            transition: all 0.3s ease;
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
        }

        /* Forum Categories */
        .forum-categories {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            overflow: hidden;
        }

        .category-header {
            background-color: var(--secondary);
            color: white;
            padding: 15px 20px;
            font-size: 1.1rem;
        }

        .category-list {
            list-style: none;
        }

        .category-item {
            border-bottom: 1px solid var(--gray-200);
        }

        .category-item:last-child {
            border-bottom: none;
        }

        .category-link {
            display: flex;
            padding: 15px 20px;
            color: var(--gray-800);
            transition: all 0.3s ease;
            align-items: center
        }

        .category-link:hover {
            background-color: var(--gray-100);
            color: var(--primary);
        }

        .category-link.active {
            background-color: var(--light);
            color: var(--primary);
            border-left: 3px solid var(--primary);
        }

        .category-icon {
            margin-right: 10px;
            color: var(--primary);
            width: 20px;
            text-align: center;
        }

        .category-count {
            margin-left: auto;
            background-color: var(--gray-200);
            color: var(--gray-700);
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* Forum Stats */
        .forum-stats {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-bottom: 30px;
        }

        .stats-title {
            font-size: 1.1rem;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--gray-200);
        }

        .stats-list {
            list-style: none;
        }

        .stats-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }

        .stats-label {
            color: var(--gray-700);
        }

        .stats-value {
            font-weight: 600;
            color: var(--primary);
        }

        /* Online Users */
        .online-users {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 20px;
        }

        .online-title {
            font-size: 1.1rem;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--gray-200);
        }

        .user-avatars {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--gray-300);
            overflow: hidden;
            position: relative;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-status {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: var(--success);
            border: 2px solid white;
        }

        .online-count {
            margin-top: 15px;
            font-size: 0.9rem;
            color: var(--gray-700);
        }

        .online-count strong {
            color: var(--primary);
        }

        /* Thread Filters */
        .thread-filters {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            background-color: white;
            border-radius: 8px;
            padding: 15px 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            flex-wrap: wrap;
            gap: 15px;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-label {
            font-size: 0.9rem;
            color: var(--gray-700);
        }

        .filter-select {
            padding: 8px 12px;
            border: 1px solid var(--gray-300);
            border-radius: 4px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            color: var(--gray-800);
            background-color: white;
            cursor: pointer;
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--primary);
        }

        .view-options {
            display: flex;
            gap: 5px;
        }

        .view-option {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--gray-100);
            border: 1px solid var(--gray-300);
            border-radius: 4px;
            color: var(--gray-600);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .view-option:hover {
            background-color: var(--gray-200);
            color: var(--gray-800);
        }

        .view-option.active {
            background-color: var(--light);
            color: var(--primary);
            border-color: var(--primary);
        }

        /* Thread List */
        .thread-list {
            margin-bottom: 30px;
        }

        .thread-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 15px;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .thread-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .thread-card.pinned {
            border-left: 3px solid var(--primary);
        }

        .thread-header {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid var(--gray-200);
        }

        .thread-status {
            margin-right: 15px;
            font-size: 1.2rem;
        }

        .thread-status.unread {
            color: var(--primary);
        }

        .thread-status.read {
            color: var(--gray-400);
        }

        .thread-title-link {
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--gray-800);
            margin-right: 10px;
        }

        .thread-title-link:hover {
            color: var(--primary);
        }

        .thread-badges {
            display: flex;
            gap: 5px;
            margin-left: 10px;
        }

        .thread-badge {
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-pinned {
            background-color: var(--primary);
            color: white;
        }

        .badge-hot {
            background-color: var(--danger);
            color: white;
        }

        .badge-official {
            background-color: var(--secondary);
            color: white;
        }

        .badge-solved {
            background-color: var(--success);
            color: white;
        }

        .thread-content {
            display: flex;
            padding: 15px 20px;
        }

        .thread-author {
            flex: 0 0 180px;
            padding-right: 20px;
            border-right: 1px solid var(--gray-200);
        }

        .author-info {
            display: flex;
            align-items: center;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--gray-300);
            overflow: hidden;
            margin-right: 10px;
        }

        .author-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .author-details {
            flex: 1;
        }

        .author-name {
            font-weight: 600;
            color: var(--secondary);
            margin-bottom: 3px;
        }

        .author-role {
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        .author-badges {
            display: flex;
            gap: 5px;
            margin-top: 5px;
        }

        .author-badge {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            color: white;
        }

        .badge-admin {
            background-color: var(--danger);
        }

        .badge-mod {
            background-color: var(--warning);
        }

        .badge-vip {
            background-color: var(--accent);
        }

        .thread-preview {
            flex: 1;
            padding-left: 20px;
        }

        .thread-excerpt {
            font-size: 0.9rem;
            color: var(--gray-700);
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .thread-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        .thread-stats {
            display: flex;
            gap: 15px;
        }

        .thread-stat {
            display: flex;
            align-items: center;
        }

        .thread-stat i {
            margin-right: 5px;
        }

        .thread-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .thread-tag {
            padding: 3px 8px;
            background-color: var(--gray-200);
            color: var(--gray-700);
            border-radius: 4px;
            font-size: 0.7rem;
            transition: all 0.3s ease;
        }

        .thread-tag:hover {
            background-color: var(--gray-300);
            color: var(--gray-800);
        }

        .thread-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: var(--gray-100);
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        .last-reply {
            display: flex;
            align-items: center;
        }

        .reply-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: var(--gray-300);
            overflow: hidden;
            margin-right: 8px;
        }

        .reply-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .reply-info a {
            font-weight: 600;
            color: var(--secondary);
        }

        .reply-info a:hover {
            color: var(--primary);
        }

        .thread-actions {
            display: flex;
            gap: 10px;
        }

        .thread-action {
            color: var(--gray-600);
            transition: all 0.3s ease;
        }

        .thread-action:hover {
            color: var(--primary);
        }

        /* Compact Thread List */
        .thread-list.compact .thread-card {
            margin-bottom: 10px;
        }

        .thread-list.compact .thread-content {
            display: none;
        }

        .thread-list.compact .thread-header {
            border-bottom: none;
        }

        .thread-list.compact .thread-footer {
            border-top: 1px solid var(--gray-200);
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .pagination-list {
            display: flex;
            list-style: none;
            gap: 5px;
        }

        .pagination-item a,
        .pagination-item span {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 4px;
            background-color: white;
            color: var(--gray-700);
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .pagination-item a:hover {
            background-color: var(--gray-100);
            color: var(--primary);
        }

        .pagination-item.active a {
            background-color: var(--primary);
            color: white;
        }

        .pagination-item.disabled span {
            background-color: var(--gray-100);
            color: var(--gray-400);
            cursor: not-allowed;
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .forum-layout {
                flex-direction: column;
            }

            .thread-author {
                flex: 0 0 120px;
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .mobile-menu {
                display: block;
            }

            .page-header h1 {
                font-size: 2rem;
            }

            .thread-content {
                flex-direction: column;
            }

            .thread-author {
                flex: none;
                width: 100%;
                border-right: none;
                border-bottom: 1px solid var(--gray-200);
                padding-right: 0;
                padding-bottom: 15px;
                margin-bottom: 15px;
            }

            .thread-preview {
                padding-left: 0;
            }

            .thread-filters {
                flex-direction: column;
                align-items: flex-start;
            }

            .filter-group {
                width: 100%;
                justify-content: space-between;
            }
        }

        @media (max-width: 576px) {
            .thread-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .thread-badges {
                margin-left: 0;
            }

            .thread-footer {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }

            .thread-actions {
                width: 100%;
                justify-content: flex-end;
            }
        }
    </style>
@endsection

@section('content')
    <section class="page-header">
        <div class="container">
            <h1>{{ $group->name }}</h1>
            <p>{{ $group->description }}</p>
            <ul class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ route('forum.index') }}">Forum</a></li>
                <li><a href="">{{ $group->name }}</a></li>
            </ul>
        </div>
    </section>


    <main class="container">
        <div class="forum-layout">

            <div class="forum-main">

                <div class="forum-header">
                    <h2 class="forum-title">Discussions</h2>
                    <div class="forum-actions">
                        @auth
                            <a href="{{ route('forum.create-post', $group->id) }}" class="btn btn-primary btn-icon">
                                <i class="fas fa-plus"></i> New Post
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-icon">
                                <i class="fas fa-sign-in-alt"></i> Login to Post
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="thread-list" id="thread-list">
                    @if ($posts->count() > 0)
                        @foreach ($posts as $post)
                            <div class="thread-card">
                                <div class="thread-header">
                                    <div class="thread-status {{ $post->comments->count() > 0 ? 'read' : 'unread' }}">
                                        <i class="fas fa-circle"></i>
                                    </div>
                                    <a href="{{ route('forum.post', ['groupId' => $group->id, 'postId' => $post->id]) }}"
                                        class="thread-title-link">
                                        {{ $post->title }}
                                    </a>
                                </div>
                                <div class="thread-content">
                                    <div class="thread-author">
                                        <div class="author-info">
                                            <div class="author-avatar">
                                                <img src="{{ asset($post->user->image) ?? 'https://via.placeholder.com/50x50' }}"
                                                    alt="{{ $post->user->firstname }} {{ $post->user->lastname }}">
                                            </div>
                                            <div class="author-details">
                                                <div class="author-name">{{ $post->user->firstname }}
                                                    {{ $post->user->lastname }}</div>
                                                <div class="author-role">
                                                    @if ($post->user->isAdmin())
                                                        Administrator
                                                    @else
                                                        Member
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="thread-preview">
                                        <div class="thread-excerpt">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 200) }}
                                        </div>
                                        <div class="thread-meta">
                                            <div class="thread-stats">
                                                <div class="thread-stat">
                                                    <i class="far fa-comment"></i> {{ $post->comments_count }} replies
                                                </div>
                                                <div class="thread-stat">
                                                    <i class="far fa-heart"></i> {{ $post->likes_count }} likes
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="thread-footer">
                                    <div class="last-reply">
                                        @if ($post->comments->count() > 0)
                                            <div class="reply-avatar">
                                                <img src="{{ $post->comments->last()->user->image ?? 'https://via.placeholder.com/24x24' }}"
                                                    alt="User Avatar">
                                            </div>
                                            <div class="reply-info">
                                                Last reply by <a
                                                    href="#">{{ $post->comments->last()->user->firstname }}
                                                    {{ $post->comments->last()->user->lastname }}</a>
                                                •
                                                {{ $post->comments->last()->created_at->diffForHumans() }}
                                            </div>
                                        @else
                                            <div class="reply-info">
                                                No replies yet
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        No posts yet in this group!
                    @endif
                </div>
            </div>

            <div class="forum-sidebar">
                <div class="forum-stats">
                    <h3 class="stats-title">Group Information</h3>
                    <ul class="stats-list">
                        <li class="stats-item">
                            <div class="stats-label">Created By:</div>
                            <div class="stats-value">{{ $group->createdBy->firstname }} {{ $group->createdBy->lastname }}
                            </div>
                        </li>
                        <li class="stats-item">
                            <div class="stats-label">Created On:</div>
                            <div class="stats-value">{{ $group->created_at->format('M d, Y') }}</div>
                        </li>
                        <li class="stats-item">
                            <div class="stats-label">Total Posts:</div>
                            <div class="stats-value">{{ $posts->count() }}</div>
                        </li>
                    </ul>
                </div>

                <!-- Back to Forum -->
                <div class="forum-categories">
                    <div class="category-header">
                        Actions
                    </div>
                    <ul class="category-list">
                        <li class="category-item">
                            <a href="{{ route('forum.index') }}" class="category-link">
                                <i class="fas fa-arrow-left category-icon"></i>
                                Back to Forum
                            </a>
                        </li>
                        @auth
                            <li class="category-item">
                                <a href="{{ route('forum.create-post', $group->id) }}" class="category-link">
                                    <i class="fas fa-plus category-icon"></i>
                                    Create New Thread
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>

        </div>
    </main>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // View options toggle
            const viewOptions = document.querySelectorAll('.view-option');
            const threadList = document.getElementById('thread-list');

            viewOptions.forEach(option => {
                option.addEventListener('click', function() {
                    viewOptions.forEach(opt => opt.classList.remove('active'));
                    this.classList.add('active');

                    if (this.title === 'Compact View') {
                        threadList.classList.add('compact');
                    } else {
                        threadList.classList.remove('compact');
                    }
                });
            });

            // Thread hover effect
            const threadCards = document.querySelectorAll('.thread-card');

            threadCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px)';
                    this.style.boxShadow = '0 8px 20px rgba(0, 0, 0, 0.1)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = '';
                    this.style.boxShadow = '';
                });
            });
        });
    </script>
@endsection
