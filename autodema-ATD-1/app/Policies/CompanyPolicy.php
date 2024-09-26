<?php

namespace App\Policies;

use App\Company;
use App\Role;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
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
        return $user->role_id === Role::SUPER_ADMIN || $user->role_id === Role::ADMIN || $user->role_id === Role::SUPERVISOR || $user->role_id === Role::ANALYST;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->role_id === Role::SUPER_ADMIN || $user->role_id === Role::ADMIN || $user->role_id === Role::SUPERVISOR || $user->role_id === Role::ANALYST;
    }
    public function viewOpportunities(User $user, Company $model)
    {
        //IF IS ADMIN OR SUPERVISOR
        $canUpdateAll = $user->role_id === Role::SUPER_ADMIN || $user->role_id === Role::ADMIN || $user->role_id === Role::SUPERVISOR;
        //IF IS ANALYST AND IS HIS CAMPAIGN
        $canUpdateThis = $user->role_id === Role::ANALYST && ($model->user_id === $user->id);

        return  ($canUpdateAll || $canUpdateThis);
    }
    public function viewContacts(User $user, Company $model)
    {
        //IF IS ADMIN OR SUPERVISOR
        $canUpdateAll = $user->role_id === Role::SUPER_ADMIN || $user->role_id === Role::ADMIN || $user->role_id === Role::SUPERVISOR;
        //IF IS ANALYST AND IS HIS CAMPAIGN
        $canUpdateThis = $user->role_id === Role::ANALYST && ($model->user_id === $user->id);

        return  ($canUpdateAll || $canUpdateThis);
    }
    public function createContacts(User $user, Company $model)
    {
        //IF IS ADMIN OR SUPERVISOR
        $canUpdateAll = $user->role_id === Role::SUPER_ADMIN || $user->role_id === Role::ADMIN || $user->role_id === Role::SUPERVISOR;
        //IF IS ANALYST AND IS HIS CAMPAIGN
        $canUpdateThis = $user->role_id === Role::ANALYST && ($model->user_id === $user->id);

        return  ($canUpdateAll || $canUpdateThis);
    }
    public function updateContacts(User $user, Company $model)
    {
        //IF IS ADMIN OR SUPERVISOR
        $canUpdateAll = $user->role_id === Role::SUPER_ADMIN || $user->role_id === Role::ADMIN || $user->role_id === Role::SUPERVISOR;
        //IF IS ANALYST AND IS HIS CAMPAIGN
        $canUpdateThis = $user->role_id === Role::ANALYST && ($model->user_id === $user->id);

        return  ($canUpdateAll || $canUpdateThis);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role_id === Role::SUPER_ADMIN || $user->role_id === Role::ADMIN || $user->role_id === Role::SUPERVISOR || $user->role_id === Role::ANALYST;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function update(User $user, Company $model)
    {
        //IF IS ADMIN OR SUPERVISOR
        $canUpdateAll = $user->role_id === Role::SUPER_ADMIN || $user->role_id === Role::ADMIN || $user->role_id === Role::SUPERVISOR;
        //IF IS ANALYST AND IS HIS CAMPAIGN
        $canUpdateThis = $user->role_id === Role::ANALYST && ($model->user_id === $user->id);

        return  ($canUpdateAll || $canUpdateThis);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function delete(User $user, Company $company)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function restore(User $user, Company $company)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function forceDelete(User $user, Company $company)
    {
        //
    }
}
