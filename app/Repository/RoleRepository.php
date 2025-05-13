<?php

namespace App\Repository;

use App\Models\Role;
use App\Repository\Impl\IRoleRepository;
use Illuminate\Support\Collection;

class RoleRepository implements IRoleRepository
{

    public function getAllRoles(): Collection
    {
        return Role::all();
    }

    public function findById(int $id): ?Role
    {
        return Role::find($id);
    }

    public function createRole(array $data): Role
    {
        $role = new Role();
        $role->name = $data['name'];
        $role->description = $data['description'] ?? null;
        $role->save();

        return $role;
    }

    public function updateRole(int $id, array $data): ?Role
    {
        $role = $this->findById($id);

        if (!$role) {
            return null;
        }

        $role->name = $data['name'];
        $role->description = $data['description'] ?? null;
        $role->save();

        return $role;
    }

    public function deleteRole(int $id): bool
    {
        $role = $this->findById($id);

        if (!$role) {
            return false;
        }

        return $role->delete();
    }

    public function hasUsers(int $id): bool
    {
        $role = $this->findById($id);

        if (!$role) {
            return false;
        }

        return $role->users()->count() > 0;
    }
}
