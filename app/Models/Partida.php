<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'juego_id',
        'creador_id',
        'fecha',
    ];

    public function juego()
    {
        return $this->belongsTo(Juego::class);
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'creador_id');
    }

    public function jugadores()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
