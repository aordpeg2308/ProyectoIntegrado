<?php

namespace App\Policies;

use App\Models\Partida;
use App\Models\User;

class PartidaPolicy
{
     public function create(User $user): bool
    {
        return true; 
    }
    public function update(User $user, Partida $partida): bool
    {
        return $user->id === $partida->creador_id;
    }

   
    public function delete(User $user, Partida $partida): bool
    {
        return $user->id === $partida->creador_id;
    }

    
    public function join(User $user, Partida $partida): bool
    {
        $jugadoresActuales = $partida->jugadores->count() + 1;
        return !$partida->jugadores->contains($user) &&
               $jugadoresActuales < $partida->juego->max_jugadores &&
               $partida->fecha > now();
    }

    
    public function leave(User $user, Partida $partida): bool
    {
        return $partida->jugadores->contains($user);
    }

    
    public function viewAvailable(User $user): bool
    {
        return true;
    }
}
