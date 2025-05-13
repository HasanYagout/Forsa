<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_user');
    }

    public function view(User $user, User $model): bool
    {
        return $user->hasPermissionTo('view_user') || $user->id === $model->id;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_user');
    }

    public function update(User $user, User $model): bool
    {
        return $user->hasPermissionTo('update_user');
    }

    public function delete(User $user, User $model): bool
    {
        return $user->hasPermissionTo('delete_user') && $user->id !== $model->id;
    }

    public function restore(User $user, User $model): bool
    {
        return $user->hasPermissionTo('restore_user');
    }

    public function forceDelete(User $user, User $model): bool
    {
        return $user->hasPermissionTo('force_delete_user');
    }
}
