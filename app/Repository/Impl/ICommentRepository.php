<?php

namespace App\Repository\Impl;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ICommentRepository
{
    public function getCommentsByPostId(int $postId, int $perPage = 20): LengthAwarePaginator;
    public function createComment(string $content, int $userId, int $postId): Comment;
    public function updateComment(int $id, string $content): bool;
    public function deleteComment(int $id): bool;
    public function getRecentComments(int $limit = 10): Collection;
    public function getMonthlyCommentData(): array;
    public function getCommentCount(): int;
    public function getCommentCountByPostId(int $postId): int;
}
