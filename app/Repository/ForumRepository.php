<?php

namespace App\Repository;

use App\Models\Comment;
use App\Models\Group;
use App\Models\Like;
use App\Models\Notification;
use App\Models\Post;
use App\Models\User;
use App\Repository\Impl\IForumRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ForumRepository implements IForumRepository
{
    public function getDashboardStats(): array
    {
        return [
            'totalGroups' => Group::count(),
            'totalPosts' => Post::count(),
            'totalComments' => Comment::count(),
            'totalLikes' => Like::count(),
            'activeUsers' => User::whereHas('posts', function ($query) {
                $query->where('created_at', '>=', Carbon::now()->subDays(30));
            })
                ->orWhereHas('comments', function ($query) {
                    $query->where('created_at', '>=', Carbon::now()->subDays(30));
                })
                ->count()
        ];
    }

    public function getTopGroups(int $limit = 10): Collection
    {
        $groups = Group::withCount('posts')
            ->with(['posts' => function ($query) {
                $query->withCount('comments');
            }])
            ->orderBy('posts_count', 'desc')
            ->take($limit)
            ->get();

        foreach ($groups as $group) {
            $group->comments_count = $group->posts->sum('comments_count');
        }

        return $groups;
    }

    public function getRecentPosts(int $limit = 10): Collection
    {
        return Post::with(['user', 'group'])
            ->withCount(['comments', 'likes'])
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }

    public function getRecentComments(int $limit = 10): Collection
    {
        return Comment::with(['user', 'post.group'])
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }

    public function getTopPosts(int $limit = 5): Collection
    {
        return Post::with(['user', 'group'])
            ->withCount(['comments', 'likes'])
            ->orderBy('likes_count', 'desc')
            ->orderBy('comments_count', 'desc')
            ->take($limit)
            ->get();
    }

    public function getMonthlyActivityData(string $model): array
    {
        $data = $model::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        $result = [];
        for ($i = 1; $i <= 12; $i++) {
            $result[$i] = $data[$i] ?? 0;
        }

        return array_values($result);
    }

    public function getAnnouncements(int $limit = 10): Collection
    {
        return Notification::orderBy('created_at', 'desc')
            ->get()
            ->unique('content')
            ->take($limit)
            ->values();
    }

    public function deletePost(int $id): bool
    {
        $post = Post::find($id);

        if (!$post) {
            return false;
        }

        $post->comments()->delete();
        $post->likes()->delete();

        return $post->delete();
    }

    public function deleteComment(int $id): bool
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return false;
        }

        return $comment->delete();
    }

    public function createAnnouncement(string $content, ?array $userIds = null): void
    {
        if ($userIds && !empty($userIds)) {
            foreach ($userIds as $userId) {
                Notification::create([
                    'content' => $content,
                    'status' => 'unread',
                    'user_id' => $userId,
                ]);
            }
        } else {
            $users = User::all();
            foreach ($users as $user) {
                Notification::create([
                    'content' => $content,
                    'status' => 'unread',
                    'user_id' => $user->id,
                ]);
            }
        }
    }

    public function deleteAnnouncement(int $id): bool
    {
        $announcement = Notification::find($id);

        if (!$announcement) {
            return false;
        }

        return $announcement->delete();
    }

    public function getGroupPosts(int $groupId, int $perPage = 10): LengthAwarePaginator
    {
        return Post::with(['user', 'comments' => function ($query) {
            $query->with('user')->latest();
        }])
            ->withCount(['comments', 'likes'])
            ->where('group_id', $groupId)
            ->latest()
            ->paginate($perPage);
    }

    public function getMostActiveUsers(int $limit = 10): Collection
    {
        return User::withCount(['posts', 'comments'])
            ->orderByRaw('posts_count + comments_count DESC')
            ->take($limit)
            ->get();
    }

    public function getAllGroups(): Collection
    {
        return Group::withCount(['posts', 'latestPosts'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getForumStats(): array
    {
        return [
            'total_posts' => Post::count(),
            'total_members' => User::count()
        ];
    }

    public function getPostWithComments(int $groupId, int $postId): array
    {
        $post = Post::where('id', $postId)
            ->where('group_id', $groupId)
            ->with(['user', 'group'])
            ->firstOrFail();

        $comments = Comment::where('post_id', $postId)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->paginate(20);

        $userLiked = false;
        if (auth()->check()) {
            $userLiked = Like::where('post_id', $postId)
                ->where('user_id', auth()->id())
                ->exists();
        }

        return [
            'post' => $post,
            'comments' => $comments,
            'userLiked' => $userLiked
        ];
    }

    public function createPost(array $data, int $userId, int $groupId): Post
    {
        $post = new Post();
        $post->title = $data['title'];
        $post->content = $data['content'];
        $post->user_id = $userId;
        $post->group_id = $groupId;
        $post->save();

        return $post;
    }

    public function createComment(string $content, int $userId, int $postId): Comment
    {
        $comment = new Comment();
        $comment->content = $content;
        $comment->user_id = $userId;
        $comment->post_id = $postId;
        $comment->save();

        return $comment;
    }

    public function toggleLike(int $postId, int $userId): string
    {
        $like = Like::where('post_id', $postId)
            ->where('user_id', $userId)
            ->first();

        if ($like) {
            $like->delete();
            return 'unliked';
        } else {
            $like = new Like();
            $like->post_id = $postId;
            $like->user_id = $userId;
            $like->save();
            return 'liked';
        }
    }
}
