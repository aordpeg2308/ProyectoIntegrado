<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Juego extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'min_jugadores',
        'max_jugadores',
    ];

    public function partidas()
    {
        return $this->hasMany(Partida::class);
    }
}
