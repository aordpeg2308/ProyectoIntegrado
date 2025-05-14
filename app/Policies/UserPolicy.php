<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{

      public function create(User $user): bool
    {
        return $user->rol === 'admin'; 
    }


    public function viewAny(User $user): bool
    {
        return $user->rol === 'admin';
    }
      
    public function update(User $user, User $target): bool
    {
        return $user->id === $target->id || $user->rol === 'admin';
    }

    public function delete(User $user, User $target): bool
    {
        return $user->rol === 'admin';
    }
}
