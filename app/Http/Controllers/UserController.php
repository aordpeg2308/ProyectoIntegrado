<?php

namespace App\Http\Controllers;

use App\Mail\GenericMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function create()
    {
        if (!Gate::allows('create', User::class)) {
            return redirect()->route('acceso.denegado');
        }

        return view('users.create');
    }

    public function store(Request $request)
    {
        if (!Gate::allows('create', User::class)) {
            return redirect()->route('acceso.denegado');
        }

        $validated = $request->validate([
            'nombre' => ['required'],
            'apellidos' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'rol' => ['required', 'in:admin,tesorero,normal'],
            'tipo' => ['required', 'in:entero,semi'],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no tiene un formato válido.',
            'email.unique' => 'Ya existe un usuario con ese correo electrónico.',
            'rol.required' => 'El rol del usuario es obligatorio.',
            'rol.in' => 'El rol debe ser admin, tesorero o normal.',
            'tipo.required' => 'El tipo de usuario es obligatorio.',
            'tipo.in' => 'El tipo debe ser entero o semi.',
        ]);

        $validated['nombre'] = Str::title($validated['nombre']);
        $validated['apellidos'] = Str::title($validated['apellidos']);

        $password = Str::random(10);

        $user = User::create([
            ...$validated,
            'activo' => true,
            'password' => Hash::make($password)
        ]);

        $mensaje = "¡Bienvenido a Ludus Alea!\n\nTu correo de acceso es: {$user->email}\nTu contraseña temporal es: $password\n\nPor favor, inicia sesión y cámbiala cuanto antes desde la sección de perfil.";

        Mail::to($user->email)->send(new GenericMail('Bienvenido a Ludus Alea', $mensaje));

        return redirect()->route('home');
    }

    public function edit(User $user)
    {
        if (!Gate::allows('update', $user)) {
            return redirect()->route('acceso.denegado');
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (!Gate::allows('update', $user)) {
            return redirect()->route('acceso.denegado');
        }

        $isAdmin = auth()->user()->rol === 'admin';

        $validated = $request->validate(
            $isAdmin
                ? [
                    'nombre' => ['required'],
                    'apellidos' => ['required'],
                    'email' => ['required', 'email', 'unique:users,email,' . $user->id],
                    'rol' => ['required', 'in:admin,tesorero,normal'],
                    'tipo' => ['required', 'in:entero,semi'],
                    'password' => ['nullable', 'confirmed', 'min:6'],
                ]
                : [
                    'email' => ['required', 'email', 'unique:users,email,' . $user->id],
                    'password' => ['nullable', 'confirmed', 'min:6'],
                ],
            [
                'nombre.required' => 'El nombre es obligatorio.',
                'apellidos.required' => 'Los apellidos son obligatorios.',
                'email.required' => 'El correo electrónico es obligatorio.',
                'email.email' => 'El correo electrónico no tiene un formato válido.',
                'email.unique' => 'Ya existe otro usuario con ese correo.',
                'rol.required' => 'El rol del usuario es obligatorio.',
                'rol.in' => 'El rol debe ser admin, tesorero o normal.',
                'tipo.required' => 'El tipo de usuario es obligatorio.',
                'tipo.in' => 'El tipo debe ser entero o semi.',
                'password.confirmed' => 'Las contraseñas no coinciden.',
                'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            ]
        );

        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if ($isAdmin) {
            $user->nombre = Str::title($validated['nombre']);
            $user->apellidos = Str::title($validated['apellidos']);
            $user->rol = $validated['rol'];
            $user->tipo = $validated['tipo'];

            if (auth()->id() !== $user->id) {
                $user->activo = $request->boolean('activo');
            }
        }

        $user->save();

        return redirect()->route('home');
    }

    public function destroy(User $user)
    {
        if (!Gate::allows('delete', $user)) {
            return redirect()->route('acceso.denegado');
        }

        $user->delete();

        return redirect()->route('home')->with('success', 'Usuario eliminado correctamente.');
    }
}
