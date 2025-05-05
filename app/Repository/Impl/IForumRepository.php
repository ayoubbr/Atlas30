<?php

namespace App\Repository\Impl;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface IForumRepository
{
    public function getDashboardStats(): array;
    public function getTopGroups(int $limit = 10): Collection;
    public function getRecentPosts(int $limit = 10): Collection;
    public function getRecentComments(int $limit = 10): Collection;
    public function getTopPosts(int $limit = 5): Collection;
    public function getMonthlyActivityData(string $model): array;
    public function getAnnouncements(int $limit = 10): Collection;
    public function deletePost(int $id): bool;
    public function deleteComment(int $id): bool;
    public function createAnnouncement(string $content, ?array $userIds = null): void;
    public function deleteAnnouncement(int $id): bool;
    public function getGroupPosts(int $groupId, int $perPage = 10): LengthAwarePaginator;
    public function getMostActiveUsers(int $limit = 10): Collection;
    public function getAllGroups(): Collection;
    public function getForumStats(): array;
    public function getPostWithComments(int $groupId, int $postId): array;
    public function createPost(array $data, int $userId, int $groupId): Post;
    public function createComment(string $content, int $userId, int $postId): Comment;
    public function toggleLike(int $postId, int $userId): string;
}