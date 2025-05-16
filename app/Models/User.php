<?php

namespace App\Models;

use Carbon\Carbon;
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
        'activo',
        'quiere_correos',
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

    
    public function juegos()
    {   
    return $this->hasMany(Juego::class);
    }

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

     public function proximoPago()
    {
        $multiplo = $this->tipo === 'semi' ? 10 : 25;
        $totalCantidad = $this->pagos->sum('cantidad');
        $totalMeses = $totalCantidad / $multiplo;

        $fechaBase = $this->pagos->sortBy('fecha')->first()?->fecha;

        if (!$fechaBase) return null;

        return Carbon::parse($fechaBase)->addMonths($totalMeses);
    }
}
