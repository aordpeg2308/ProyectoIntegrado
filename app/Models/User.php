<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nombre',
        'apellidos',
        'email',
        'password',
        'rol',
        'tipo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relaciones
    public function partidasCreadas()
    {
        return $this->hasMany(Partida::class, 'creador_id');
    }

    public function partidas()
    {
        return $this->belongsToMany(Partida::class)->withTimestamps();
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
