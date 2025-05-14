<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nombre' => 'Alejandro',
            'apellidos' => 'Ordóñez Pegalajar',
            'email' => 'alejandroordonezp@gmail.com',
            'password' => Hash::make('23081997a-'),
            'rol' => 'admin',
            'tipo' => 'entero',
            'activo'=> true,
        ]);
    }
}
