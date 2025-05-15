@extends('layout.app')

@section('content')
<div class="max-w-5xl mx-auto py-6 space-y-6 text-[#2e2d55]">
    <form method="GET" action="{{ route('partidas.index') }}">
        <div class="relative w-full max-w-md mx-auto">
            <input type="text" name="buscar" placeholder="Buscar partidas disponibles..."
                value="{{ request('buscar') }}"
                class="w-full h-11 pl-12 pr-4 rounded-full border border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:outline-none shadow focus:ring-2 focus:ring-[#f49d6e]">
            <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-[#f49d6e]">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387-1.414 1.414-4.387-4.387zM8 14a6 6 0 100-12 6 6 0 000 12z"
                        clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    </form>

    <div class="bg-[#f6d6ba]/80 rounded-xl shadow-lg overflow-x-auto w-full">
        @if ($partidas->isEmpty())
            <p class="text-center p-6 text-lg font-semibold">No hay partidas disponibles.</p>
        @else
            <table class="min-w-full table-auto text-sm">
                <thead class="bg-[#2e2d55] text-white">
                    <tr>
                        <th class="p-4 text-left">Nombre</th>
                        <th class="p-4 text-left">Juego</th>
                        <th class="p-4 text-left">Fecha</th>
                        <th class="p-4 text-left">Descripción</th>
                        <th class="p-4 text-left">Jugadores</th>
                        <th class="p-4 text-left">Acción</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($partidas as $partida)
                        @php
                            $jugadoresActuales = $partida->jugadores->count(); 
                            $jugadoresDisponibles = $partida->max_jugadores - $jugadoresActuales; 
                        @endphp
                        <tr class="hover:bg-[#f6d6ba]/60 transition">
                            <td class="p-4">{{ $partida->nombre }}</td>
                            <td class="p-4">{{ $partida->juego->nombre }}</td>
                            <td class="p-4">{{ $partida->fecha->format('d/m/Y H:i') }}</td>
                            <td class="p-4">{{ $partida->descripcion }}</td>
                            <td class="p-4">
                                {{ $jugadoresActuales }} / {{ $partida->max_jugadores }} ({{ $jugadoresDisponibles }} disponibles)
                            </td>
                            <td class="p-4">
                                <form method="POST" action="{{ route('partidas.join', $partida) }}">
                                    @csrf
                                    <button type="submit"
                                        class="bg-[#2e2d55] hover:bg-[#1f1e3d] text-white px-3 py-1 rounded shadow text-xs">
                                        Unirse
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
