<?php

namespace App\Policies;

use App\Role;
use App\ServiceType;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        $canViewAnyServiceType = $user->role_id === Role::SUPER_ADMIN || $user->role_id === Role::ADMIN || $user->role_id === Role::SUPERVISOR;
        return $canViewAnyServiceType;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\ServiceType  $serviceType
     * @return mixed
     */
    public function view(User $user)
    {
        $canViewAnyServiceType = $user->role_id === Role::SUPER_ADMIN || $user->role_id === Role::ADMIN || $user->role_id === Role::SUPERVISOR;
        return $canViewAnyServiceType;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $canViewAnyServiceType = $user->role_id === Role::SUPER_ADMIN || $user->role_id === Role::ADMIN || $user->role_id === Role::SUPERVISOR;
        return $canViewAnyServiceType;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\ServiceType  $serviceType
     * @return mixed
     */
    public function update(User $user)
    {
        $canViewAnyServiceType = $user->role_id === Role::SUPER_ADMIN || $user->role_id === Role::ADMIN || $user->role_id === Role::SUPERVISOR;
        return $canViewAnyServiceType;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\ServiceType  $serviceType
     * @return mixed
     */
    public function delete(User $user, ServiceType $serviceType)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\ServiceType  $serviceType
     * @return mixed
     */
    public function restore(User $user, ServiceType $serviceType)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\ServiceType  $serviceType
     * @return mixed
     */
    public function forceDelete(User $user, ServiceType $serviceType)
    {
        //
    }
}
