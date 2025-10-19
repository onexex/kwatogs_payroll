<?php

namespace App\Http\Services;

use Spatie\Permission\Models\Role;

class RoleServices
{
    
    public function getAllRoles()
    {
        return Role::all();
    }
    
    public function store(
        string $roleName
    ): Role
    {
        if (Role::where('name', $roleName)->exists()) {
            throw new \Exception("Role already exists.");
        }
        return Role::create(['name' => $roleName]);
    }

    public function update(
        int $roleId,
        string $roleName
    ): Role
    {
        $role = Role::findById($roleId);
        if (!$role) {
            throw new \Exception("Role not found.");
        }
        if (Role::where('name', $roleName)->where('id', '!=', $roleId)->exists()) {
            throw new \Exception("Role name already in use.");
        }
        $role->name = $roleName;
        $role->save();
        return $role;
    }
}