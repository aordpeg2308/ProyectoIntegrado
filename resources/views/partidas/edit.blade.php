@extends('layout.app')

@section('content')
<div class="flex items-center justify-center py-12">
    <div class="bg-[#f6d6ba]/80 shadow-lg rounded-xl p-8 w-full max-w-lg">
        <h2 class="text-2xl font-bold text-center text-[#2e2d55] mb-6">Editar fecha de la partida</h2>

        <form action="{{ route('partidas.update', $partida) }}" method="POST" novalidate>
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label class="block text-[#2e2d55] font-semibold mb-2">Nombre</label>
                <input type="text" value="{{ $partida->nombre }}" readonly
                    class="w-full px-4 py-2 bg-gray-100 border rounded-lg cursor-not-allowed">
            </div>

            <div class="mb-6">
                <label for="fecha" class="block text-[#2e2d55] font-semibold mb-2">Nueva fecha</label>
                <input type="datetime-local" name="fecha" id="fecha"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f49d6e]"
                    value="{{ old('fecha', $partida->fecha->format('Y-m-d\TH:i')) }}">
                @error('fecha')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-[#2e2d55] text-white py-2 rounded-lg font-semibold hover:bg-[#1f1e3d] transition">
                Actualizar partida
            </button>
        </form>
    </div>
</div>
@endsection
