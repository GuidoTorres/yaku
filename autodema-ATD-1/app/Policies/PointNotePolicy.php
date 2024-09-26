<?php

namespace App\Policies;

use App\PointNote;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PointNotePolicy
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
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\PointNote  $pointNote
     * @return mixed
     */
    public function view(User $user, PointNote $pointNote)
    {
        //
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
     * @param  \App\PointNote  $pointNote
     * @return mixed
     */
    public function update(User $user, PointNote $pointNote)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\PointNote  $pointNote
     * @return mixed
     */
    public function delete(User $user, PointNote $pointNote)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\PointNote  $pointNote
     * @return mixed
     */
    public function restore(User $user, PointNote $pointNote)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\PointNote  $pointNote
     * @return mixed
     */
    public function forceDelete(User $user, PointNote $pointNote)
    {
        //
    }
}
