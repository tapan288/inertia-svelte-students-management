<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;

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
        return Inertia::render('Roles/Create');
    }

    public function store(StoreRoleRequest $request)
    {
        Role::create($request->validated());

        return redirect()->route('roles.index')
            ->with('message', 'Role created successfully');
    }

    public function edit(Role $role)
    {
        return Inertia::render('Roles/Edit', [
            'role' => RoleResource::make($role),
        ]);
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->validated());

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
