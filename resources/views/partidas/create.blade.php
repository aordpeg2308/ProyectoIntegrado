@extends('layout.app')

@section('content')
<div class="flex items-center justify-center py-12">
    <div class="bg-[#f6d6ba]/80 shadow-lg rounded-xl p-8 w-full max-w-lg">
        <h2 class="text-2xl font-bold text-center text-[#2e2d55] mb-6">Crear nueva partida</h2>

        <form action="{{ route('partidas.store') }}" method="POST" novalidate>
            @csrf

          
            <div class="mb-4">
                <label for="nombre" class="block text-[#2e2d55] font-semibold mb-2">Nombre de la partida</label>
                <input type="text" name="nombre" id="nombre"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f49d6e]"
                    value="{{ old('nombre') }}" placeholder="Introduce el nombre de la partida">
                @error('nombre')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            
            <div class="mb-4">
                <label for="juego_id" class="block text-[#2e2d55] font-semibold mb-2">Juego</label>
                <select name="juego_id" id="juego_id"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f49d6e]">
                    <option value="">Selecciona un juego</option>
                    @foreach ($juegos as $juego)
                        <option value="{{ $juego->id }}" {{ old('juego_id') == $juego->id ? 'selected' : '' }}>
                            {{ $juego->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('juego_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

           
            <div class="mb-6">
                <label for="fecha" class="block text-[#2e2d55] font-semibold mb-2">Fecha</label>
                <input type="datetime-local" name="fecha" id="fecha"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f49d6e]"
                    value="{{ old('fecha') }}">
                @error('fecha')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" id="submit-btn"
                class="w-full bg-[#2e2d55] text-white py-2 rounded-lg font-semibold hover:bg-[#1f1e3d] transition">
                Crear partida
            </button>
        </form>
    </div>
</div>
@endsection
