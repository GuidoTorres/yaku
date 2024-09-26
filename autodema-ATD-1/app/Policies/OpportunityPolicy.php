<?php

namespace App\Policies;

use App\Opportunity;
use App\Role;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OpportunityPolicy
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
        //IF IS ADMIN OR SUPERVISOR
        $canUpdateAll = $user->role_id === Role::SUPER_ADMIN || $user->role_id === Role::ADMIN || $user->role_id === Role::SUPERVISOR || $user->role_id === Role::COMMERCIAL;

        return  $canUpdateAll;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Opportunity  $opportunity
     * @return mixed
     */
    public function viewOnlyHis(User $user)
    {
        return $user->role_id === Role::COMMERCIAL;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Opportunity  $opportunity
     * @return mixed
     */
    public function view(User $user, Opportunity $model)
    {
        //IF IS ADMIN OR SUPERVISOR
        $canViewAll = $user->role_id === Role::SUPER_ADMIN || $user->role_id === Role::ADMIN || $user->role_id === Role::SUPERVISOR;
        //IF IS COMMERCIAL AND IS HIS CAMPAIGN
        $canViewThis = $user->role_id === Role::COMMERCIAL && ($model->user_owner_id === $user->id);

        return  ($canViewAll || $canViewThis);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Opportunity  $opportunity
     * @return mixed
     */
    public function update(User $user, Opportunity $opportunity)
    {
        //IF IS ADMIN OR SUPERVISOR
        $canViewAll = $user->role_id === Role::SUPER_ADMIN || $user->role_id === Role::ADMIN || $user->role_id === Role::SUPERVISOR;
        //IF IS COMMERCIAL AND IS HIS CAMPAIGN
        $canViewThis = $user->role_id === Role::COMMERCIAL && ($opportunity->user_owner_id === $user->id);

        return  ($canViewAll || $canViewThis);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Opportunity  $opportunity
     * @return mixed
     */
    public function delete(User $user, Opportunity $opportunity)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Opportunity  $opportunity
     * @return mixed
     */
    public function restore(User $user, Opportunity $opportunity)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Opportunity  $opportunity
     * @return mixed
     */
    public function forceDelete(User $user, Opportunity $opportunity)
    {
        //
    }
}
