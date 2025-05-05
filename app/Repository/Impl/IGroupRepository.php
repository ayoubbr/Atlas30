<?php

namespace App\Repository\Impl;

use App\Models\Group;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface IGroupRepository
{
    public function findById(int $id): ?Group;
    public function getGroupWithPosts(int $id): ?Group;
    public function createGroup(array $data, int $userId): Group;
    public function updateGroup(int $id, array $data): bool;
    public function deleteGroup(int $id): bool;
    public function getGroupWithDetails(int $id): array;
}
