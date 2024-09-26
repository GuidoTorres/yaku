<?php

namespace App\Policies;

use App\Campaign;
use App\Role;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignPolicy
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
        return $user->role_id === Role::SUPER_ADMIN || $user->role_id === Role::ADMIN || $user->role_id === Role::SUPERVISOR || $user->role_id === Role::COMMERCIAL;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Campaign  $campaign
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->role_id === Role::SUPER_ADMIN || $user->role_id === Role::ADMIN || $user->role_id === Role::SUPERVISOR || $user->role_id === Role::COMMERCIAL;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role_id === Role::SUPER_ADMIN || $user->role_id === Role::ADMIN || $user->role_id === Role::SUPERVISOR || $user->role_id === Role::COMMERCIAL;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Campaign  $campaign
     * @return mixed
     */
    public function update(User $user, Campaign $model)
    {
        //IF IS ADMIN OR SUPERVISOR
        $canUpdateAll = $user->role_id === Role::SUPER_ADMIN || $user->role_id === Role::ADMIN || $user->role_id === Role::SUPERVISOR;
        //IF IS COMMERCIAL AND IS HIS CAMPAIGN
        $canUpdateThis = $user->role_id === Role::COMMERCIAL && ($model->user_id === $user->id);

        return  ($canUpdateAll || $canUpdateThis);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Campaign  $campaign
     * @return mixed
     */
    public function delete(User $user, Campaign $campaign)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Campaign  $campaign
     * @return mixed
     */
    public function restore(User $user, Campaign $campaign)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Campaign  $campaign
     * @return mixed
     */
    public function forceDelete(User $user, Campaign $campaign)
    {
        //
    }
}
