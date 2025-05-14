<?php
namespace App\Policies;

use App\Models\User;

class PagoPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->rol === 'tesorero';
    }

    public function create(User $user): bool
    {
        return $user->rol === 'tesorero';
    }
}
