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
     * Aktive Jobs sind öffentlich sichtbar.
     * Inaktive Jobs nur für interne User und Admins.
     */
    public function view(?User $user, JobListing $job): bool
    {
        if ($job->is_active) {
            return true;
        }

        return $user && in_array($user->role, ['user', 'admin']);
    }

    /**
     * Nur interne User und Admins dürfen Jobs erstellen.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, ['user', 'admin']);
    }

    /**
     * Interne User und Admins dürfen alle Jobs bearbeiten.
     */
    public function update(User $user, JobListing $job): bool
    {
        return in_array($user->role, ['user', 'admin']);
    }

    /**
     * Interne User und Admins dürfen alle Jobs löschen.
     */
    public function delete(User $user, JobListing $job): bool
    {
        return in_array($user->role, ['user', 'admin']);
    }

    /**
     * Zusätzliche interne Felder nur für interne User und Admins.
     */
    public function viewInternalFields(User $user, JobListing $job): bool
    {
        return in_array($user->role, ['user', 'admin']);
    }
}
