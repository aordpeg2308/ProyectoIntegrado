@extends('layout.app')

@section('content')
<div class="flex items-center justify-center py-12">
    <div class="bg-[#f6d6ba]/80 shadow-lg rounded-xl p-8 w-full max-w-lg">
        <h2 class="text-2xl font-bold text-center text-[#2e2d55] mb-6">Añadir nuevo juego</h2>

        <form action="{{ route('juegos.store') }}" method="POST" novalidate>
            @csrf

            <div class="mb-4">
                <label for="nombre" class="block text-[#2e2d55] font-semibold mb-2">Nombre del juego</label>
                <input type="text" name="nombre" id="nombre"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f49d6e]"
                    value="{{ old('nombre') }}" placeholder="Ej: Catan">
                @error('nombre')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="tipo" class="block text-[#2e2d55] font-semibold mb-2">Tipo</label>
                <select name="tipo" id="tipo"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f49d6e]">
                    <option value="">Selecciona un tipo</option>
                    <option value="Juego de mesa" {{ old('tipo') == 'Juego de mesa' ? 'selected' : '' }}>Juego de mesa</option>
                    <option value="Manual de rol" {{ old('tipo') == 'Manual de rol' ? 'selected' : '' }}>Manual de rol</option>
                </select>
                @error('tipo')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="genero" class="block text-[#2e2d55] font-semibold mb-2">Género</label>
                <input type="text" name="genero" id="genero"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f49d6e]"
                    value="{{ old('genero') }}" placeholder="Ej: Fantasía, Estrategia...">
                @error('genero')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="edad" class="block text-[#2e2d55] font-semibold mb-2">Edad recomendada</label>
                <input type="number" name="edad" id="edad" min="0"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f49d6e]"
                    value="{{ old('edad') }}">
                @error('edad')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="user_id" class="block text-[#2e2d55] font-semibold mb-2">Dueño del juego</label>
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

            <button type="submit"
                class="w-full bg-[#2e2d55] text-white py-2 rounded-lg font-semibold hover:bg-[#1f1e3d] transition">
                Crear juego
            </button>
        </form>
    </div>
</div>
@endsection
