<?php

namespace App\Repository\Impl;

use App\Models\Role;
use Illuminate\Support\Collection;

interface IRoleRepository
{
    public function getAllRoles(): Collection;
    public function findById(int $id): ?Role;
    public function createRole(array $data): Role;
    public function updateRole(int $id, array $data): ?Role;
    public function deleteRole(int $id): bool;
    public function hasUsers(int $id): bool;
}
