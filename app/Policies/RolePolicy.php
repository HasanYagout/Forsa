<?php

namespace App\Policies;


use App\Models\User;
use Illuminate\Auth\Access\Response;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_role');
    }

    public function view(User $user, Role $role): bool
    {
        return $user->hasPermissionTo('view_role');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_role');
    }

    public function update(User $user, Role $role): bool
    {
        return $user->hasPermissionTo('update_role');
    }

    public function delete(User $user, Role $role): bool
    {
        return $user->hasPermissionTo('delete_role');
    }

    public function restore(User $user, Role $role): bool
    {
        return $user->hasPermissionTo('restore_role');
    }

    public function forceDelete(User $user, Role $role): bool
    {
        return $user->hasPermissionTo('force_delete_role');
    }
}
