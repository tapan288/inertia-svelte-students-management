<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\PermissionResource;

class RoleController extends Controller
{
    public function index()
    {
        return Inertia::render('Roles/Index', [
            'roles' => RoleResource::collection(
                \App\Models\Role::paginate()
            ),
        ]);
    }

    public function create()
    {
        return Inertia::render('Roles/Create', [
            'permissions' => PermissionResource::collection(\App\Models\Permission::all()),
        ]);
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->validated());

        $permissions = collect($request->permissions)->map(function ($permission) {
            return $permission['value'];
        });

        $role->permissions()->sync($permissions);

        return redirect()->route('roles.index')
            ->with('message', 'Role created successfully');
    }

    public function edit(Role $role)
    {
        return Inertia::render('Roles/Edit', [
            'role' => RoleResource::make($role),
            'permissions' => PermissionResource::collection(\App\Models\Permission::all()),
        ]);
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $permissions = collect($request->permissions)->map(function ($permission) {
            return $permission['value'];
        });

        $role->update($request->validated());

        $role->permissions()->sync($permissions);

        return redirect()->route('roles.index')
            ->with('message', 'Role updated successfully');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')
            ->with('message', 'Role deleted successfully');
    }
}
