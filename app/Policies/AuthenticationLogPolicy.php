<?php

namespace App\Policies;

use App\Models\User;
use Rappasoft\LaravelAuthenticationLog\Models\AuthenticationLog;
use Illuminate\Auth\Access\HandlesAuthorization;

class AuthenticationLogPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AuthenticationLog $authenticationLog): bool
    {
        return $user->can('view_authentication::log');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_authentication::log');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AuthenticationLog $authenticationLog): bool
    {
        return $user->can('update_authentication::log');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AuthenticationLog $authenticationLog): bool
    {
        return $user->can('delete_authentication::log');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_authentication::log');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, AuthenticationLog $authenticationLog): bool
    {
        return $user->can('force_delete_authentication::log');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_authentication::log');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, AuthenticationLog $authenticationLog): bool
    {
        return $user->can('restore_authentication::log');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_authentication::log');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, AuthenticationLog $authenticationLog): bool
    {
        return $user->can('replicate_authentication::log');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_authentication::log');
    }
}
