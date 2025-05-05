<?php

namespace App\Repository;

use App\Models\Like;
use App\Repository\Impl\ILikeRepository;
use Illuminate\Database\Eloquent\Collection;

class LikeRepository implements ILikeRepository
{
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

    public function getLikeCount(int $postId): int
    {
        return Like::where('post_id', $postId)->count();
    }

    public function getUserLikes(int $userId): Collection
    {
        return Like::where('user_id', $userId)
            ->with('post.group')
            ->get();
    }

    public function checkUserLiked(int $postId, int $userId): bool
    {
        return Like::where('post_id', $postId)
            ->where('user_id', $userId)
            ->exists();
    }

    public function getTotalLikes(): int
    {
        return Like::count();
    }
}
