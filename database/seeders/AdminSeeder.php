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
            'nombre' => 'Admin',
            'apellidos' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'rol' => 'admin',
            'tipo' => 'entero',
            'activo' => true,
            'quiere_correos' => true,
        ]);
    }
}
