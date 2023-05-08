<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;

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

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')
            ->with('message', 'Role deleted successfully');
    }
}
