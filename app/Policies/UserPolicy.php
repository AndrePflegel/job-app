<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $authUser): bool
    {
        return $authUser->isAdmin();
    }

    public function create(User $authUser): bool
    {
        return $authUser->isAdmin();
    }

    public function update(User $authUser, User $targetUser): bool
    {
        return $authUser->isAdmin();
    }

    public function delete(User $authUser, User $targetUser): bool
    {
        if (! $authUser->isAdmin()) {
            return false;
        }

        if ($authUser->id === $targetUser->id) {
            return false;
        }

        return true;
    }
}
