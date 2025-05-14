<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Juego;

class JuegoPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->rol === 'admin';
    }

    public function update(User $user, Juego $juego): bool
    {
        return $user->rol === 'admin';
    }

    public function delete(User $user, Juego $juego): bool
    {
        return $user->rol === 'admin';
    }
}
