<?php

namespace App\Repository;

use App\Models\Comment;
use App\Repository\Impl\ICommentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CommentRepository implements ICommentRepository
{
    public function getCommentsByPostId(int $postId, int $perPage = 20): LengthAwarePaginator
    {
        return Comment::where('post_id', $postId)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->paginate($perPage);
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

    public function updateComment(int $id, string $content): bool
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return false;
        }

        $comment->content = $content;
        return $comment->save();
    }

    public function deleteComment(int $id): bool
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return false;
        }

        return $comment->delete();
    }

    public function getRecentComments(int $limit = 10): Collection
    {
        return Comment::with(['user', 'post.group'])
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }

    public function getMonthlyCommentData(): array
    {
        $data = Comment::select(
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

    public function getCommentCount(): int
    {
        return Comment::count();
    }

    public function getCommentCountByPostId(int $postId): int
    {
        return Comment::where('post_id', $postId)->count();
    }
}
