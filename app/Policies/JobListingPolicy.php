<?php

namespace App\Policies;

use App\Models\JobListing;
use App\Models\User;

class JobListingPolicy
{
    /**
     * Öffentliche Liste ist für alle sichtbar.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Öffentliche Detailansicht ist für alle sichtbar.
     */
    public function view(?User $user, JobListing $job): bool
    {
        return true;
    }

    /**
     * Nur User und Admin dürfen Jobs anlegen.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, ['user', 'admin']);
    }

    /**
     * Interne User und Admins dürfen Jobs bearbeiten
     */
    public function update(User $user, JobListing $job): bool
    {
        return in_array($user->role, ['user', 'admin']);
    }

    /**
     * Interne User und Admins dürfen Jobs löschen
     */
    public function delete(User $user, JobListing $job): bool
    {
        return in_array($user->role, ['user', 'admin']);
    }
}
