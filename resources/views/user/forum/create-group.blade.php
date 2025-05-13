@extends('user.layout')

@section('title', 'Create Discussion Group - Forum - World Cup 2030')

@section('css')
    <style>
        .form-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 30px;
            margin-bottom: 40px;
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
            min-height: 150px;
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

        /* Guidelines Box */
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

        /* Guidelines Box */
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
    </style>
@endsection

@section('content')
    <section class="page-header">
        <div class="container">
            <h1>Create Discussion Group</h1>
            <ul class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ route('forum.index') }}">Forum</a></li>
                <li><a href="">Create Group</a></li>
            </ul>
        </div>
    </section>

    <main class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="form-container">
                    <h2 class="form-title">Create a New Discussion Group</h2>
                    <div class="guidelines-box">
                        <div class="guidelines-title">
                            <i class="fas fa-info-circle"></i> Group Creation Guidelines
                        </div>
                        <ul class="guidelines-list">
                            <li>Choose a clear, descriptive name for your group</li>
                            <li>Provide a detailed description of the group's purpose</li>
                            <li>Ensure your group follows the community guidelines</li>
                            <li>Avoid creating duplicate groups for the same topic</li>
                            <li>As the creator, you will be responsible for moderating your group</li>
                        </ul>
                    </div>

                    <form action="{{ route('forum.store-group') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="form-label">Group Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required>
                            <small class="form-text">Choose a clear, descriptive name (max 255 characters)</small>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-label">Group Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="6" required>{{ old('description') }}</textarea>
                            <small class="form-text">Describe what this group is about, its purpose, and what kind of
                                discussions are welcome</small>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-actions">
                            <a href="{{ route('forum.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Group</button>
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
                                <a href="{{ route('forum.index') }}" class="category-link">
                                    <i class="fas fa-arrow-left category-icon"></i>
                                    Back to Forum
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
