<?php

namespace App\Repository\Impl;

use App\Models\User;
use Illuminate\Support\Collection;

interface IUserRepository
{
    public function getAuthenticatedUser(): ?User;
    public function findById(int $id): ?User;
    public function updateProfile(User $user, array $data, $image = null): User;
    public function checkCurrentPassword(User $user, string $currentPassword): bool;
    public function updatePassword(User $user, string $newPassword): User;
    public function getUsersList(): Collection;
}
