<?php

namespace App\Repository;

use App\Models\Post;
use App\Repository\Impl\IPostRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PostRepository implements IPostRepository
{
    public function getAllPosts(): Collection
    {
        return Post::with(['user', 'group'])
            ->withCount(['comments', 'likes'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getPostById(int $id): ?Post
    {
        return Post::with(['user', 'group'])
            ->withCount(['comments', 'likes'])
            ->find($id);
    }

    public function getPostWithComments(int $groupId, int $postId): array
    {
        $post = Post::where('id', $postId)
            ->where('group_id', $groupId)
            ->with(['user', 'group'])
            ->firstOrFail();

        $comments = $post->comments()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->paginate(20);

        $userLiked = false;
        if (auth()->check()) {
            $userLiked = $post->likes()
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

    public function updatePost(int $id, array $data): bool
    {
        $post = $this->getPostById($id);

        if (!$post) {
            return false;
        }

        $post->title = $data['title'];
        $post->content = $data['content'];

        return $post->save();
    }

    public function deletePost(int $id): bool
    {
        $post = $this->getPostById($id);

        if (!$post) {
            return false;
        }

        $post->comments()->delete();
        $post->likes()->delete();

        return $post->delete();
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

    public function getRecentPosts(int $limit = 10): Collection
    {
        return Post::with(['user', 'group'])
            ->withCount(['comments', 'likes'])
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }

    public function getMonthlyPostData(): array
    {
        $data = Post::select(
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

    public function getPostCount(): int
    {
        return Post::count();
    }

    public function getPostsByGroupId(int $groupId, int $perPage = 10): LengthAwarePaginator
    {
        return Post::where('group_id', $groupId)
            ->with(['user', 'comments', 'likes'])
            ->withCount(['comments', 'likes'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
}
