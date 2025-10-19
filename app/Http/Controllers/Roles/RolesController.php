<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Http\Services\RoleServices;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function __construct(
        private RoleServices $roleServices
    )
    {
    }

    public function index()
    {
        $roles = $this->roleServices->getAllRoles();
        return view('pages.users.roles', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|string|max:255',
        ]);

        try {
            $this->roleServices->store(
                roleName: $request->input('role')
            );

            return redirect()->back()->with('success', 'Role created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, Role $user_role)
    {
        $request->validate([
            'role' => 'required|string|max:255',
        ]);

        try {
            $role = $this->roleServices->update(
                roleId: $user_role->id,
                roleName: $request->input('role')
            );

            return redirect()->back()->with('success', 'Role updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}