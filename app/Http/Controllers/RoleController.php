<?php

namespace App\Http\Controllers;

use App\Repository\Impl\IRoleRepository;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $roleRepository;

    public function __construct(IRoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $roles = $this->roleRepository->getAllRoles();
        return view('admin.roles', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'description' => 'nullable|string|max:255',
        ]);

        $this->roleRepository->createRole($request->all());

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully.');
    }

    public function show(int $id)
    {
        $role = $this->roleRepository->findById($id);
        return view('admin.roles', compact('role'));
    }

    public function edit(int $id)
    {
        $role = $this->roleRepository->findById($id);
        return view('admin.roles', compact('role'));
    }

    public function update(Request $request, $roleId)
    {
        $role = $this->roleRepository->findById($roleId);

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $roleId,
            'description' => 'nullable|string|max:255',
        ]);

        $this->roleRepository->updateRole($roleId, $request->all());

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    public function destroy($roleId)
    {
        if ($this->roleRepository->hasUsers($roleId)) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Cannot delete role with associated users.');
        }

        $this->roleRepository->deleteRole($roleId);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}
