<?php

namespace App\Policies;

use App\Models\Training;
use App\Models\User;

class TrainingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_training');
    }

    public function view(User $user, Training $training): bool
    {
        return $user->hasPermissionTo('view_training');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_training');
    }

    public function update(User $user, Training $training): bool
    {
        return $user->hasPermissionTo('update_training');
    }

    public function delete(User $user, Training $training): bool
    {
        return $user->hasPermissionTo('delete_training');
    }

    public function restore(User $user, Training $training): bool
    {
        return $user->hasPermissionTo('restore_training');
    }

    public function forceDelete(User $user, Training $training): bool
    {
        return $user->hasPermissionTo('force_delete_training');
    }
}
