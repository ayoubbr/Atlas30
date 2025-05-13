<?php

namespace App\Repository\Impl;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface IAdminRepository
{

    public function getPaginatedUsers(int $perPage = 8): LengthAwarePaginator;
    public function getAllRoles(): Collection;
    public function deleteUser(int $id): bool;
    public function getTotalUsersCount(): int;
    public function findById(int $id): ?User;
    public function hasTickets(int $id): bool;
    public function hasComments(int $id): bool;
    public function hasLikes(int $id): bool;
    public function hasNotifications(int $id): bool;
    public function getActiveUsersCount(): int;
    public function getNewUsersCount(int $days = 7): int;
    public function getMonthlyRegistrations(): array;
    public function createUser(array $userData): User;
    public function findUserById(int $id, array $relations = []): ?User;
    public function updateUser(int $id, array $userData): ?User;
    public function getAuthenticatedUser(): ?User;
}
