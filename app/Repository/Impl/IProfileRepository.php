<?php

namespace App\Repository\Impl;

use App\Models\User;
use Illuminate\Support\Collection;

interface IProfileRepository
{
    public function getUserById(int $id): ?User;
    public function getUserWithTickets(int $id): ?User;
    public function updateUserProfile(int $id, array $data): bool;
    public function updateUserPassword(int $id, string $newPassword): bool;
    public function getUserActivity(int $id): Collection;
    public function getUserPostCount(int $id): int;
}
