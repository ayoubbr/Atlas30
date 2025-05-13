<?php

namespace App\Repository\Impl;

use Illuminate\Database\Eloquent\Collection;

interface ILikeRepository
{
    public function toggleLike(int $postId, int $userId): string;
    public function getLikeCount(int $postId): int;
    public function checkUserLiked(int $postId, int $userId): bool;
    public function getTotalLikes(): int;
}
