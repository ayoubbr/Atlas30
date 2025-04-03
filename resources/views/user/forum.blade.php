@extends('user.layout')

@section('title', 'Forum - World Cup 2030')

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
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Fan Community Forum</h1>
            <p>Join the conversation with football fans from around the world. Discuss matches, share your experiences, and
                connect with the global football community.</p>
            <ul class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">Community</a></li>
                <li><a href="#">Forum</a></li>
            </ul>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container">
        <!-- Forum Layout -->
        <div class="forum-layout">
            <!-- Forum Main Content -->
            <div class="forum-main">
                <!-- Forum Header -->
                <div class="forum-header">
                    <h2 class="forum-title">All Discussions</h2>
                    <div class="forum-actions">
                        <a href="#" class="btn btn-primary btn-icon">
                            <i class="fas fa-plus"></i> New Thread
                        </a>
                    </div>
                </div>

                <!-- Forum Search -->
                <div class="forum-search">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Search threads...">
                </div>

                <!-- Thread Filters -->
                <div class="thread-filters">
                    <div class="filter-group">
                        <span class="filter-label">Sort by:</span>
                        <select class="filter-select">
                            <option value="recent">Most Recent</option>
                            <option value="popular">Most Popular</option>
                            <option value="replies">Most Replies</option>
                            <option value="views">Most Views</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <span class="filter-label">Show:</span>
                        <select class="filter-select">
                            <option value="all">All Threads</option>
                            <option value="pinned">Pinned Only</option>
                            <option value="official">Official Only</option>
                            <option value="unanswered">Unanswered</option>
                        </select>
                    </div>
                    <div class="view-options">
                        <button class="view-option active" title="Detailed View">
                            <i class="fas fa-th-list"></i>
                        </button>
                        <button class="view-option" title="Compact View">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>

                <!-- Thread List -->
                <div class="thread-list" id="thread-list">
                    <!-- Pinned Thread -->
                    <div class="thread-card pinned">
                        <div class="thread-header">
                            <div class="thread-status unread">
                                <i class="fas fa-circle"></i>
                            </div>
                            <a href="#" class="thread-title-link">Official World Cup 2030 Announcement - Host Cities
                                and Venues</a>
                            <div class="thread-badges">
                                <span class="thread-badge badge-pinned">Pinned</span>
                                <span class="thread-badge badge-official">Official</span>
                            </div>
                        </div>
                        <div class="thread-content">
                            <div class="thread-author">
                                <div class="author-info">
                                    <div class="author-avatar">
                                        <img src="https://via.placeholder.com/50x50" alt="Admin Avatar">
                                    </div>
                                    <div class="author-details">
                                        <div class="author-name">WorldCupAdmin</div>
                                        <div class="author-role">Administrator</div>
                                        <div class="author-badges">
                                            <div class="author-badge badge-admin" title="Administrator">
                                                <i class="fas fa-shield-alt"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="thread-preview">
                                <div class="thread-excerpt">
                                    We are excited to announce the official host cities and venues for the 2030 FIFA World
                                    Cup. After careful consideration and evaluation, the following cities have been selected
                                    to host matches during the tournament...
                                </div>
                                <div class="thread-meta">
                                    <div class="thread-stats">
                                        <div class="thread-stat">
                                            <i class="far fa-eye"></i> 15.2K views
                                        </div>
                                        <div class="thread-stat">
                                            <i class="far fa-comment"></i> 342 replies
                                        </div>
                                    </div>
                                    <div class="thread-tags">
                                        <a href="#" class="thread-tag">Announcement</a>
                                        <a href="#" class="thread-tag">Venues</a>
                                        <a href="#" class="thread-tag">Official</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="thread-footer">
                            <div class="last-reply">
                                <div class="reply-avatar">
                                    <img src="https://via.placeholder.com/24x24" alt="User Avatar">
                                </div>
                                <div class="reply-info">
                                    Last reply by <a href="#">FootballFan92</a> • 2 hours ago
                                </div>
                            </div>
                            <div class="thread-actions">
                                <a href="#" class="thread-action" title="Bookmark">
                                    <i class="far fa-bookmark"></i>
                                </a>
                                <a href="#" class="thread-action" title="Share">
                                    <i class="fas fa-share-alt"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Regular Thread 1 -->
                    <div class="thread-card">
                        <div class="thread-header">
                            <div class="thread-status unread">
                                <i class="fas fa-circle"></i>
                            </div>
                            <a href="#" class="thread-title-link">Brazil vs France - Match Predictions and
                                Discussion</a>
                            <div class="thread-badges">
                                <span class="thread-badge badge-hot">Hot</span>
                            </div>
                        </div>
                        <div class="thread-content">
                            <div class="thread-author">
                                <div class="author-info">
                                    <div class="author-avatar">
                                        <img src="https://via.placeholder.com/50x50" alt="User Avatar">
                                    </div>
                                    <div class="author-details">
                                        <div class="author-name">SoccerExpert</div>
                                        <div class="author-role">Football Analyst</div>
                                        <div class="author-badges">
                                            <div class="author-badge badge-vip" title="VIP Member">
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="thread-preview">
                                <div class="thread-excerpt">
                                    The upcoming match between Brazil and France is going to be one of the highlights of the
                                    tournament. Both teams have incredible talent and depth. Let's discuss potential
                                    lineups, tactics, and predictions for this exciting clash...
                                </div>
                                <div class="thread-meta">
                                    <div class="thread-stats">
                                        <div class="thread-stat">
                                            <i class="far fa-eye"></i> 8.7K views
                                        </div>
                                        <div class="thread-stat">
                                            <i class="far fa-comment"></i> 156 replies
                                        </div>
                                    </div>
                                    <div class="thread-tags">
                                        <a href="#" class="thread-tag">Brazil</a>
                                        <a href="#" class="thread-tag">France</a>
                                        <a href="#" class="thread-tag">Predictions</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="thread-footer">
                            <div class="last-reply">
                                <div class="reply-avatar">
                                    <img src="https://via.placeholder.com/24x24" alt="User Avatar">
                                </div>
                                <div class="reply-info">
                                    Last reply by <a href="#">FootballFanatic</a> • 15 minutes ago
                                </div>
                            </div>
                            <div class="thread-actions">
                                <a href="#" class="thread-action" title="Bookmark">
                                    <i class="far fa-bookmark"></i>
                                </a>
                                <a href="#" class="thread-action" title="Share">
                                    <i class="fas fa-share-alt"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Regular Thread 2 -->
                    <div class="thread-card">
                        <div class="thread-header">
                            <div class="thread-status read">
                                <i class="fas fa-circle"></i>
                            </div>
                            <a href="#" class="thread-title-link">Best places to stay in Rio during the World
                                Cup?</a>
                            <div class="thread-badges">
                                <span class="thread-badge badge-solved">Solved</span>
                            </div>
                        </div>
                        <div class="thread-content">
                            <div class="thread-author">
                                <div class="author-info">
                                    <div class="author-avatar">
                                        <img src="https://via.placeholder.com/50x50" alt="User Avatar">
                                    </div>
                                    <div class="author-details">
                                        <div class="author-name">TravelBug</div>
                                        <div class="author-role">Member</div>
                                    </div>
                                </div>
                            </div>
                            <div class="thread-preview">
                                <div class="thread-excerpt">
                                    I'm planning to attend several matches in Rio during the World Cup and I'm looking for
                                    recommendations on where to stay. I'm considering areas like Copacabana, Ipanema, and
                                    Leblon, but I'm open to other suggestions. Budget is around $150-200 per night...
                                </div>
                                <div class="thread-meta">
                                    <div class="thread-stats">
                                        <div class="thread-stat">
                                            <i class="far fa-eye"></i> 3.2K views
                                        </div>
                                        <div class="thread-stat">
                                            <i class="far fa-comment"></i> 47 replies
                                        </div>
                                    </div>
                                    <div class="thread-tags">
                                        <a href="#" class="thread-tag">Travel</a>
                                        <a href="#" class="thread-tag">Accommodation</a>
                                        <a href="#" class="thread-tag">Rio</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="thread-footer">
                            <div class="last-reply">
                                <div class="reply-avatar">
                                    <img src="https://via.placeholder.com/24x24" alt="User Avatar">
                                </div>
                                <div class="reply-info">
                                    Last reply by <a href="#">RioLocal</a> • 2 days ago
                                </div>
                            </div>
                            <div class="thread-actions">
                                <a href="#" class="thread-action" title="Bookmark">
                                    <i class="far fa-bookmark"></i>
                                </a>
                                <a href="#" class="thread-action" title="Share">
                                    <i class="fas fa-share-alt"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Regular Thread 3 -->
                    <div class="thread-card">
                        <div class="thread-header">
                            <div class="thread-status read">
                                <i class="fas fa-circle"></i>
                            </div>
                            <a href="#" class="thread-title-link">Ticket exchange thread - Buy, sell, or trade World
                                Cup tickets</a>
                        </div>
                        <div class="thread-content">
                            <div class="thread-author">
                                <div class="author-info">
                                    <div class="author-avatar">
                                        <img src="https://via.placeholder.com/50x50" alt="User Avatar">
                                    </div>
                                    <div class="author-details">
                                        <div class="author-name">TicketMaster</div>
                                        <div class="author-role">Moderator</div>
                                        <div class="author-badges">
                                            <div class="author-badge badge-mod" title="Moderator">
                                                <i class="fas fa-wrench"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="thread-preview">
                                <div class="thread-excerpt">
                                    This is the official ticket exchange thread for the 2030 World Cup. Please follow the
                                    guidelines when posting: 1) Clearly state which match tickets you're selling/buying, 2)
                                    Include the category and price, 3) No scalping - tickets must be sold at face value or
                                    less...
                                </div>
                                <div class="thread-meta">
                                    <div class="thread-stats">
                                        <div class="thread-stat">
                                            <i class="far fa-eye"></i> 12.5K views
                                        </div>
                                        <div class="thread-stat">
                                            <i class="far fa-comment"></i> 289 replies
                                        </div>
                                    </div>
                                    <div class="thread-tags">
                                        <a href="#" class="thread-tag">Tickets</a>
                                        <a href="#" class="thread-tag">Exchange</a>
                                        <a href="#" class="thread-tag">Buy/Sell</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="thread-footer">
                            <div class="last-reply">
                                <div class="reply-avatar">
                                    <img src="https://via.placeholder.com/24x24" alt="User Avatar">
                                </div>
                                <div class="reply-info">
                                    Last reply by <a href="#">FootballFan2023</a> • 5 hours ago
                                </div>
                            </div>
                            <div class="thread-actions">
                                <a href="#" class="thread-action" title="Bookmark">
                                    <i class="far fa-bookmark"></i>
                                </a>
                                <a href="#" class="thread-action" title="Share">
                                    <i class="fas fa-share-alt"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Regular Thread 4 -->
                    <div class="thread-card">
                        <div class="thread-header">
                            <div class="thread-status unread">
                                <i class="fas fa-circle"></i>
                            </div>
                            <a href="#" class="thread-title-link">Fan meetups during the tournament - Let's
                                organize!</a>
                        </div>
                        <div class="thread-content">
                            <div class="thread-author">
                                <div class="author-info">
                                    <div class="author-avatar">
                                        <img src="https://via.placeholder.com/50x50" alt="User Avatar">
                                    </div>
                                    <div class="author-details">
                                        <div class="author-name">FanClubOrganizer</div>
                                        <div class="author-role">Member</div>
                                    </div>
                                </div>
                            </div>
                            <div class="thread-preview">
                                <div class="thread-excerpt">
                                    I think it would be great to organize some fan meetups during the World Cup. We could
                                    gather at local bars or fan zones before matches to socialize and enjoy the games
                                    together. If you're interested, please comment with which city/matches you'll be
                                    attending...
                                </div>
                                <div class="thread-meta">
                                    <div class="thread-stats">
                                        <div class="thread-stat">
                                            <i class="far fa-eye"></i> 2.8K views
                                        </div>
                                        <div class="thread-stat">
                                            <i class="far fa-comment"></i> 73 replies
                                        </div>
                                    </div>
                                    <div class="thread-tags">
                                        <a href="#" class="thread-tag">Meetups</a>
                                        <a href="#" class="thread-tag">Fan Events</a>
                                        <a href="#" class="thread-tag">Social</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="thread-footer">
                            <div class="last-reply">
                                <div class="reply-avatar">
                                    <img src="https://via.placeholder.com/24x24" alt="User Avatar">
                                </div>
                                <div class="reply-info">
                                    Last reply by <a href="#">SoccerFan123</a> • 1 day ago
                                </div>
                            </div>
                            <div class="thread-actions">
                                <a href="#" class="thread-action" title="Bookmark">
                                    <i class="far fa-bookmark"></i>
                                </a>
                                <a href="#" class="thread-action" title="Share">
                                    <i class="fas fa-share-alt"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <ul class="pagination-list">
                        <li class="pagination-item disabled">
                            <span><i class="fas fa-chevron-left"></i></span>
                        </li>
                        <li class="pagination-item active">
                            <a href="#">1</a>
                        </li>
                        <li class="pagination-item">
                            <a href="#">2</a>
                        </li>
                        <li class="pagination-item">
                            <a href="#">3</a>
                        </li>
                        <li class="pagination-item">
                            <a href="#">4</a>
                        </li>
                        <li class="pagination-item">
                            <a href="#">5</a>
                        </li>
                        <li class="pagination-item">
                            <a href="#"><i class="fas fa-chevron-right"></i></a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Forum Sidebar -->
            <div class="forum-sidebar">
                <!-- Forum Categories -->
                <div class="forum-categories">
                    <div class="category-header">
                        Forum Categories
                    </div>
                    <ul class="category-list">
                        <li class="category-item">
                            <a href="#" class="category-link active">
                                <i class="fas fa-globe category-icon"></i>
                                All Discussions
                                <span class="category-count">1.2K</span>
                            </a>
                        </li>
                        <li class="category-item">
                            <a href="#" class="category-link">
                                <i class="fas fa-bullhorn category-icon"></i>
                                Announcements
                                <span class="category-count">24</span>
                            </a>
                        </li>
                        <li class="category-item">
                            <a href="#" class="category-link">
                                <i class="fas fa-futbol category-icon"></i>
                                Match Discussions
                                <span class="category-count">356</span>
                            </a>
                        </li>
                        <li class="category-item">
                            <a href="#" class="category-link">
                                <i class="fas fa-ticket-alt category-icon"></i>
                                Tickets & Travel
                                <span class="category-count">189</span>
                            </a>
                        </li>
                        <li class="category-item">
                            <a href="#" class="category-link">
                                <i class="fas fa-users category-icon"></i>
                                Fan Zone
                                <span class="category-count">245</span>
                            </a>
                        </li>
                        <li class="category-item">
                            <a href="#" class="category-link">
                                <i class="fas fa-question-circle category-icon"></i>
                                Help & Support
                                <span class="category-count">87</span>
                            </a>
                        </li>
                        <li class="category-item">
                            <a href="#" class="category-link">
                                <i class="fas fa-comments category-icon"></i>
                                Off-Topic
                                <span class="category-count">132</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Forum Stats -->
                <div class="forum-stats">
                    <h3 class="stats-title">Forum Statistics</h3>
                    <ul class="stats-list">
                        <li class="stats-item">
                            <div class="stats-label">Total Threads:</div>
                            <div class="stats-value">1,245</div>
                        </li>
                        <li class="stats-item">
                            <div class="stats-label">Total Posts:</div>
                            <div class="stats-value">15,789</div>
                        </li>
                        <li class="stats-item">
                            <div class="stats-label">Total Members:</div>
                            <div class="stats-value">8,432</div>
                        </li>
                        <li class="stats-item">
                            <div class="stats-label">Newest Member:</div>
                            <div class="stats-value">FootballFan2030</div>
                        </li>
                    </ul>
                </div>

                <!-- Online Users -->
                <div class="online-users">
                    <h3 class="online-title">Who's Online</h3>
                    <div class="user-avatars">
                        <div class="user-avatar">
                            <img src="https://via.placeholder.com/40x40" alt="User Avatar">
                            <div class="user-status"></div>
                        </div>
                        <div class="user-avatar">
                            <img src="https://via.placeholder.com/40x40" alt="User Avatar">
                            <div class="user-status"></div>
                        </div>
                        <div class="user-avatar">
                            <img src="https://via.placeholder.com/40x40" alt="User Avatar">
                            <div class="user-status"></div>
                        </div>
                        <div class="user-avatar">
                            <img src="https://via.placeholder.com/40x40" alt="User Avatar">
                            <div class="user-status"></div>
                        </div>
                        <div class="user-avatar">
                            <img src="https://via.placeholder.com/40x40" alt="User Avatar">
                            <div class="user-status"></div>
                        </div>
                        <div class="user-avatar">
                            <img src="https://via.placeholder.com/40x40" alt="User Avatar">
                            <div class="user-status"></div>
                        </div>
                    </div>
                    <div class="online-count">
                        <strong>127 users</strong> currently online (24 members, 103 guests)
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('js')
    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuBtn = document.querySelector('.mobile-menu');
            const navLinks = document.querySelector('.nav-links');

            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function() {
                    navLinks.classList.toggle('active');
                });
            }

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
