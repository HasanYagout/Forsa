<?php

namespace App\Policies;

use App\Models\Tender;
use App\Models\User;

class TenderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_tender');
    }

    public function view(User $user, Tender $tender): bool
    {
        return $user->hasPermissionTo('view_tender');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_tender');
    }

    public function update(User $user, Tender $tender): bool
    {
        return $user->hasPermissionTo('update_tender');
    }

    public function delete(User $user, Tender $tender): bool
    {
        return $user->hasPermissionTo('delete_tender');
    }

    public function restore(User $user, Tender $tender): bool
    {
        return $user->hasPermissionTo('restore_tender');
    }

    public function forceDelete(User $user, Tender $tender): bool
    {
        return $user->hasPermissionTo('force_delete_tender');
    }
}
