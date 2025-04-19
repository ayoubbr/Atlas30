<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::all();
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

        $role = new Role();
        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully.');
    }


    public function show(Role $role)
    {
        return view('admin.roles', compact('role'));
    }


    public function edit(Role $role)
    {
        return view('admin.roles', compact('role'));
    }


    public function update(Request $request, $roleId)
    {
        $role = Role::find($roleId);

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'description' => 'nullable|string|max:255',
        ]);

        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully.');
    }


    public function destroy($roleId)
    {
        $role = Role::find($roleId);

        if ($role->users()->count() > 0) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Cannot delete role with associated users.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}
