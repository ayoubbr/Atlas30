@extends('user.layout')

@section('title', 'Create New Post - ' . $group->name . ' - Forum - World Cup 2030')

@section('css')
    <style>
        .form-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 30px;
            margin-bottom: 40px;
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 20px
        }

        .form-title {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: var(--secondary);
            padding-bottom: 15px;
            border-bottom: 1px solid var(--gray-200);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--gray-700);
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--gray-300);
            border-radius: 4px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.1);
        }

        .form-text {
            display: block;
            margin-top: 5px;
            font-size: 0.85rem;
            color: var(--gray-600);
        }

        textarea.form-control {
            min-height: 250px;
            resize: vertical;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            font-weight: 600;
            text-align: center;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: #c1121f;
        }

        .btn-secondary {
            background-color: var(--gray-200);
            color: var(--gray-700);
        }

        .btn-secondary:hover {
            background-color: var(--gray-300);
        }

        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 5px;
            font-size: 0.85rem;
            color: var(--danger);
        }

        /* Group Info Box */
        .group-info-box {
            background-color: var(--light);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .group-info-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .group-info-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background-color: var(--secondary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.2rem;
        }

        .group-info-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--secondary);
        }

        .group-info-description {
            font-size: 0.9rem;
            color: var(--gray-700);
            margin-bottom: 0;
        }


        .guidelines-box {
            background-color: var(--light);
            border-left: 4px solid var(--secondary);
            padding: 20px;
            border-radius: 4px;
            margin-bottom: 30px;
        }

        .guidelines-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--secondary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .guidelines-list {
            list-style-type: none;
            padding-left: 0;
            margin-bottom: 0;
        }

        .guidelines-list li {
            position: relative;
            padding-left: 20px;
            margin-bottom: 8px;
            font-size: 0.9rem;
            color: var(--gray-700);
        }

        .guidelines-list li:before {
            content: "•";
            position: absolute;
            left: 0;
            color: var(--secondary);
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .form-actions {
                flex-direction: column;
                gap: 15px;
            }

            .form-actions .btn {
                width: 100%;
            }
        }

        .forum-sidebar {
            flex: 1;
            min-width: 250px;
        }

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
    </style>
@endsection

@section('content')
    <section class="page-header">
        <div class="container">
            <h1>Create New Post</h1>
            <ul class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ route('forum.index') }}">Forum</a></li>
                <li><a href="{{ route('forum.group', $group->id) }}">{{ $group->name }}</a></li>
                <li><a href="">New Post</a></li>
            </ul>
        </div>
    </section>

    <main class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="form-container">
                    <h2 class="form-title">Create a New Post</h2>

                    <div class="group-info-box">
                        <div class="group-info-header">
                            <div class="group-info-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="group-info-title">{{ $group->name }}</div>
                        </div>
                        <p class="group-info-description">{{ \Illuminate\Support\Str::limit($group->description, 150) }}</p>
                    </div>

                    <div class="guidelines-box">
                        <div class="guidelines-title">
                            <i class="fas fa-info-circle"></i> Posting Guidelines
                        </div>
                        <ul class="guidelines-list">
                            <li>Use a clear, descriptive title for your post</li>
                            <li>Be respectful and constructive in your posts</li>
                            <li>Stay on topic and relevant to the group's purpose</li>
                            <li>Check if a similar post already exists before posting</li>
                            <li>Format your post for readability (paragraphs, bullet points, etc.)</li>
                        </ul>
                    </div>

                    <!-- Create Post Form -->
                    <form action="{{ route('forum.store-post', $group->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title" class="form-label">Post Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title') }}" required>
                            <small class="form-text">Be clear and specific about your topic (max 255 characters)</small>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content" class="form-label">Post Content</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10"
                                required>{{ old('content') }}</textarea>
                            <small class="form-text">Provide details, ask questions, or share information related to your
                                title</small>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-actions">
                            <a href="{{ route('forum.group', $group->id) }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Post</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="forum-sidebar">
                    <div class="forum-categories">
                        <div class="category-header">
                            Actions
                        </div>
                        <ul class="category-list">
                            <li class="category-item">
                                <a href="{{ route('forum.group', $group->id) }}" class="category-link">
                                    <i class="fas fa-arrow-left category-icon"></i>
                                    Back to {{ $group->name }}
                                </a>
                            </li>
                            <li class="category-item">
                                <a href="{{ route('forum.index') }}" class="category-link">
                                    <i class="fas fa-home category-icon"></i>
                                    Forum Home
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
