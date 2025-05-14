@extends('layout.app')

@section('content')
    <div class="flex items-center justify-center py-12">
        <div class="bg-[#f6d6ba]/80 shadow-lg rounded-xl p-8 w-full max-w-lg">
            <h2 class="text-2xl font-bold text-center text-[#2e2d55] mb-6">Crear nuevo juego</h2>

            <form action="{{ route('juegos.store') }}" method="POST" novalidate>
                @csrf

              
                <div class="mb-4">
                    <label for="nombre" class="block text-[#2e2d55] font-semibold mb-2">Nombre del juego</label>
                    <input type="text" name="nombre" id="nombre"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f49d6e]"
                        value="{{ old('nombre') }}" placeholder="Introduce el nombre del juego">
                    @error('nombre')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                
                <div class="mb-4">
                    <label for="min_jugadores" class="block text-[#2e2d55] font-semibold mb-2">Mínimo de jugadores</label>
                    <input type="number" name="min_jugadores" id="min_jugadores" min="1"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f49d6e]"
                        value="{{ old('min_jugadores') }}" placeholder="Ej: 2">
                    @error('min_jugadores')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                
                <div class="mb-4">
                    <label for="max_jugadores" class="block text-[#2e2d55] font-semibold mb-2">Máximo de jugadores</label>
                    <input type="number" name="max_jugadores" id="max_jugadores" min="1"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f49d6e]"
                        value="{{ old('max_jugadores') }}" placeholder="Ej: 6">
                    @error('max_jugadores')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

              
                <div class="mb-6">
                    <label for="user_id" class="block text-[#2e2d55] font-semibold mb-2">Responsable del juego</label>
                    <select name="user_id" id="user_id"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f49d6e]">
                        <option value="">Selecciona un usuario</option>
                        @foreach ($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('user_id') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->nombre }} {{ $usuario->apellidos }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" id="submit-btn"
                    class="w-full bg-[#2e2d55] text-white py-2 rounded-lg font-semibold hover:bg-[#1f1e3d] transition">
                    Crear juego
                </button>
            </form>
        </div>
    </div>
@endsection
