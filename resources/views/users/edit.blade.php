@extends('layout.app')

@section('content')
    <div class="flex items-center justify-center py-12">
        <div class="bg-[#f6d6ba]/80 shadow-lg rounded-xl p-8 w-full max-w-lg">
            <h2 class="text-2xl font-bold text-center text-[#2e2d55] mb-6">Editar usuario</h2>

            <form action="{{ route('users.update', $user) }}" method="POST" novalidate>
                @csrf
                @method('PATCH')

                @can('update', $user)
                    @if(auth()->user()->rol === 'admin')
                        <div class="mb-4">
                            <label for="nombre" class="block text-[#2e2d55] font-semibold mb-2">Nombre</label>
                            <input type="text" name="nombre" id="nombre"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f49d6e]"
                                value="{{ old('nombre', $user->nombre) }}" placeholder="Introduce el nombre">
                            @error('nombre')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="apellidos" class="block text-[#2e2d55] font-semibold mb-2">Apellidos</label>
                            <input type="text" name="apellidos" id="apellidos"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f49d6e]"
                                value="{{ old('apellidos', $user->apellidos) }}" placeholder="Introduce los apellidos">
                            @error('apellidos')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="rol" class="block text-[#2e2d55] font-semibold mb-2">Rol</label>
                            <select name="rol" id="rol"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f49d6e]">
                                <option value="">Selecciona un rol</option>
                                <option value="admin" {{ old('rol', $user->rol) === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="tesorero" {{ old('rol', $user->rol) === 'tesorero' ? 'selected' : '' }}>Tesorero</option>
                                <option value="normal" {{ old('rol', $user->rol) === 'normal' ? 'selected' : '' }}>Normal</option>
                            </select>
                            @error('rol')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="tipo" class="block text-[#2e2d55] font-semibold mb-2">Tipo de socio</label>
                            <select name="tipo" id="tipo"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f49d6e]">
                                <option value="">Selecciona tipo</option>
                                <option value="entero" {{ old('tipo', $user->tipo) === 'entero' ? 'selected' : '' }}>Entero</option>
                                <option value="semi" {{ old('tipo', $user->tipo) === 'semi' ? 'selected' : '' }}>Semi</option>
                            </select>
                            @error('tipo')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                             @if(auth()->id() !== $user->id)
                                <div class="mb-4">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="activo" {{ $user->activo ? 'checked' : '' }}>
                                        <span class="ml-2">Usuario activo</span>
                                    </label>
                                </div>
                            @endif

                    @endif
                @endcan

                <div class="mb-4">
                    <label for="email" class="block text-[#2e2d55] font-semibold mb-2">Email</label>
                    <input type="email" name="email" id="email"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f49d6e]"
                        value="{{ old('email', $user->email) }}" placeholder="Introduce el email">
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-[#2e2d55] font-semibold mb-2">Nueva contraseña (opcional)</label>
                    <input type="password" name="password" id="password"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f49d6e]"
                        placeholder="Introduce una nueva contraseña si quieres cambiarla">
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-[#2e2d55] font-semibold mb-2">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f49d6e]"
                        placeholder="Confirma la nueva contraseña">
                </div>
                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="quiere_correos" {{ $user->quiere_correos ? 'checked' : '' }}>
                        <span class="ml-2">Desea recibir correos</span>
                    </label>
                </div>

                <button type="submit" id="submit-btn"
                    class="w-full bg-[#2e2d55] text-white py-2 rounded-lg font-semibold hover:bg-[#1f1e3d] transition">
                    Actualizar usuario
                </button>
            </form>
        </div>
    </div>
@endsection
