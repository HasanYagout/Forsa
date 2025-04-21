<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JobPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_job');
    }

    public function view(User $user, Job $job): bool
    {
        return $user->hasPermissionTo('view_job');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_job');
    }

    public function update(User $user, Job $job): bool
    {
        return $user->hasPermissionTo('update_job');
    }

    public function delete(User $user, Job $job): bool
    {
        return $user->hasPermissionTo('delete_job');
    }

    public function restore(User $user, Job $job): bool
    {
        return $user->hasPermissionTo('restore_job');
    }

    public function forceDelete(User $user, Job $job): bool
    {
        return $user->hasPermissionTo('force_delete_job');
    }
}
