<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Profile_Service_provider;
use App\Models\User;

class ProfileServiceProviderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Profile_Service_provider $profileServiceProvider): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Profile_Service_provider $profileServiceProvider): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Profile_Service_provider $profileServiceProvider): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Profile_Service_provider $profileServiceProvider): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Profile_Service_provider $profileServiceProvider): bool
    {
        //
    }
}
