<?php

namespace App\Policies;

use App\Models\user\User;

class RolePolicy
{
    public function access(User $user, string $subject, string $requiredLevel): bool
    {
        return $user->hasAccess($subject, $requiredLevel);
    }
}
