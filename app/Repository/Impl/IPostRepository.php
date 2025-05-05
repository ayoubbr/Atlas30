<?php

namespace App\Repository\Impl;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface IPostRepository
{
    public function getAllPosts(): Collection;
    public function getPostById(int $id): ?Post;
    public function getPostWithComments(int $groupId, int $postId): array;
    public function createPost(array $data, int $userId, int $groupId): Post;
    public function updatePost(int $id, array $data): bool;
    public function deletePost(int $id): bool;
    public function getTopPosts(int $limit = 5): Collection;
    public function getRecentPosts(int $limit = 10): Collection;
    public function getMonthlyPostData(): array;
    public function getPostCount(): int;
    public function getPostsByGroupId(int $groupId, int $perPage = 10): LengthAwarePaginator;
}
