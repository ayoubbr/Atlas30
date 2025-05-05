<?php

namespace App\Repository\Impl;

use App\Models\Group;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface IGroupRepository
{

    public function getAllGroups(): Collection;
    public function findById(int $id): ?Group;
    public function getGroupWithPosts(int $id): ?Group;
    public function createGroup(array $data, int $userId): Group;
    public function updateGroup(int $id, array $data): bool;
    public function deleteGroup(int $id): bool;
    public function getGroupWithDetails(int $id): array;
    public function getTopGroups(int $limit = 10): Collection;
    public function getGroupCount(): int;
    public function getGroupsWithStats(): Collection;
}
