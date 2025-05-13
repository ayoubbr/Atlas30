@extends('user.layout')

@section('title', $post->title . ' - Forum - World Cup 2030')

@section('css')
    <style>
        /* Post Specific Styles */
        .post-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            overflow: hidden;
        }



        .post-header {
            background-color: var(--secondary);
            padding: 15px 20px;
        }

        .post-title {
            color: white !important;
            font-size: 1.5rem;
            margin: 0;
        }

        .post-meta {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .post-content {
            display: flex;
        }

        .post-author {
            flex: 0 0 385px;
            padding: 20px;
            border-right: 1px solid var(--gray-200);
            background-color: var(--gray-100);
            display: flex;
            justify-content: start;
            align-items: center;
        }

        .post-author .author-info {
            gap: 20px
        }

        .author-info {
            display: flex;
            flex-direction: row;
            align-items: center;
            text-align: center;
        }

        .author-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--gray-300);
            overflow: hidden;
            margin-bottom: 15px;
        }


        .author-info-stats {
            display: flex;
            align-items: center;
            gap: 10px
        }

        .author-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .author-name {
            font-weight: 600;
            color: var(--secondary);
            margin-bottom: 5px;
        }

        .author-role {
            font-size: 0.8rem;
            color: var(--gray-600);
            margin-bottom: 10px;
        }

        .author-stats {
            font-size: 0.8rem;
            color: var(--gray-600);
            margin-bottom: 15px;
        }

        .author-body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-left: 10px
        }

        .author-badges {
            display: flex;
            gap: 5px;
            justify-content: center;
            margin-top: 10px;
        }

        .post-body {
            flex: 1;
            padding: 20px;
        }

        .post-text {
            font-size: 1rem;
            line-height: 1.6;
            color: var(--gray-800);
            margin-bottom: 20px;
        }

        .post-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: var(--gray-100);
            border-top: 1px solid var(--gray-200);
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .action-button {
            display: flex;
            align-items: center;
            gap: 5px;
            color: var(--gray-600);
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border: none;
            background: transparent;
            cursor: pointer;
        }

        .action-button:hover {
            color: var(--primary);
        }

        .action-button.liked {
            color: var(--danger);
        }

        .post-date {
            font-size: 0.9rem;
            color: var(--gray-600);
        }

        /* Comments */
        .comments-container {
            margin-bottom: 30px;
        }

        .comments-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .comments-title {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .comment-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 15px;
            overflow: hidden;
        }

        .comment-content {
            display: flex;
        }

        .comment-author {
            flex: 0 0 220px;
            padding: 15px;
            border-right: 1px solid var(--gray-200);
            background-color: var(--gray-50);
        }

        .comment-body {
            flex: 1;
            padding: 15px;
            align-items: center;
            justify-content: start;
            display: flex;
        }

        .comment-text {
            font-size: 0.95rem;
            line-height: 1.5;
            color: var(--gray-800);
            margin-bottom: 10px;
        }

        .comment-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            background-color: var(--gray-50);
            border-top: 1px solid var(--gray-200);
            font-size: 0.85rem;
        }

        /* Reply Form */
        .reply-form {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 20px;
        }

        .reply-form-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 20px;
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

        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {

            .post-content,
            .comment-content {
                flex-direction: column;
            }

            .post-author,
            .comment-author {
                flex: none;
                width: 100%;
                border-right: none;
                border-bottom: 1px solid var(--gray-200);
                padding-bottom: 15px;
            }

            .author-info {
                flex-direction: row;
                text-align: left;
                align-items: flex-start;
            }

            .author-avatar {
                margin-bottom: 0;
                margin-right: 15px;
                width: 60px;
                height: 60px;
            }

            .post-actions,
            .comment-actions {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }

            .action-buttons {
                width: 100%;
                justify-content: flex-end;
            }
        }
    </style>
@endsection

@section('content')
    <section class="page-header">
        <div class="container">
            <h1>{{ $post->title }}</h1>
            <ul class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ route('forum.index') }}">Forum</a></li>
                <li><a href="{{ route('forum.group', $post->group_id) }}">{{ $post->group->name }}</a></li>
                <li><a href="">Post</a></li>
            </ul>
        </div>
    </section>

    <main class="container">
        <div class="post-container">
            <div class="post-header">
                <h2 class="post-title">{{ $post->title }}</h2>
                <div class="post-meta">
                    <div>Posted by {{ $post->user->firstname }} {{ $post->user->lastname }}</div>
                    <div>{{ $post->created_at->format('M d, Y h:i A') }}</div>
                </div>
            </div>
            <div class="post-content">
                <div class="post-author">
                    <div class="author-info">
                        <div class="author-avatar">
                            <img src="{{ asset($post->user->image) ?? 'https://via.placeholder.com/80x80' }}"
                                alt="{{ $post->user->name }}">
                        </div>
                        <div class="author-info-stats">
                            <div class="author-name">{{ $post->user->firstname }} {{ $post->user->lastname }}

                                <div class="author-role">
                                    @if ($post->user->isAdmin())
                                        Administrator
                                    @else
                                        Member
                                    @endif
                                </div>
                            </div>

                            <div class="author-stats">
                                Posts: {{ $post->user->posts->count() }}<br>
                                Joined: {{ $post->user->created_at->format('M Y') }}
                            </div>
                            <div class="author-badges">
                                @if ($post->user->isAdmin())
                                    <div class="author-badge badge-admin" title="Administrator">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="post-body">
                    <div class="post-text">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                </div>
            </div>
            <div class="post-actions">
                <div class="action-buttons">
                    @auth
                        <form action="{{ route('forum.toggle-like', ['groupId' => $post->group_id, 'postId' => $post->id]) }}"
                            method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="action-button {{ $userLiked ? 'liked' : '' }}">
                                <i class="fas fa-heart"></i> {{ $userLiked ? 'Liked' : 'Like' }} ({{ $post->likes->count() }})
                            </button>
                        </form>
                    @else
                        <span class="action-button">
                            <i class="far fa-heart"></i> Likes ({{ $post->likes->count() }})
                        </span>
                    @endauth
                    <a href="#reply-form" class="action-button">
                        <i class="fas fa-reply"></i> Reply
                    </a>
                </div>
                <div class="post-date">
                    Posted {{ $post->created_at->diffForHumans() }}
                </div>
            </div>
        </div>

        <!-- Comments -->
        <div class="comments-container">
            <div class="comments-header">
                <h3 class="comments-title">{{ $comments->count() }}
                    {{ \Illuminate\Support\Str::plural('Reply', $comments->count()) }}</h3>
            </div>

            @foreach ($comments as $comment)
                <div class="comment-card">
                    <div class="comment-content">
                        <div class="comment-author">
                            <div class="author-info">
                                <div class="author-avatar">
                                    <img src="{{ $comment->user->image ?? 'https://via.placeholder.com/50x50' }}"
                                        alt="{{ $comment->user->firstname }}">
                                </div>
                                <div class="author-body">
                                    <div class="author-name">{{ $comment->user->firstname }}
                                        {{ $comment->user->lastname }}
                                    </div>
                                    <div class="author-role">
                                        @if ($comment->user->isAdmin())
                                            Administrator
                                        @else
                                            Member
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="comment-body">
                            <div class="comment-text">
                                {!! nl2br(e($comment->content)) !!}
                            </div>
                        </div>
                    </div>
                    <div class="comment-actions">
                        <div class="action-buttons">
                            <a href="#reply-form" class="action-button">
                                <i class="fas fa-reply"></i> Reply
                            </a>
                        </div>
                        <div class="post-date">
                            Posted {{ $comment->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @endforeach

            @if ($comments->count() == 0)
                <div class="comment-card">
                    <div class="comment-body">
                        <div class="comment-text text-center py-4">
                            No replies yet. Be the first to reply!
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Reply Form -->
        @auth
            <div class="reply-form" id="reply-form">
                <h3 class="reply-form-title">Post a Reply</h3>
                <form action="{{ route('forum.store-comment', ['groupId' => $post->group_id, 'postId' => $post->id]) }}"
                    method="POST">
                    @csrf
                    <div class="form-group">
                        <textarea name="content" class="form-control" placeholder="Write your reply here..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Post Reply</button>
                </form>
            </div>
        @else
            <div class="reply-form">
                <h3 class="reply-form-title">Post a Reply</h3>
                <p>You need to <a href="{{ route('login') }}">login</a> to post a reply.</p>
            </div>
        @endauth
    </main>
@endsection
