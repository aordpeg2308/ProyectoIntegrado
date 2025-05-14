<div class="max-w-5xl mx-auto py-6 space-y-6 text-[#2e2d55]">
    <form method="GET" action="{{ route('home') }}">
        <div class="relative w-full max-w-md mx-auto">
            <input type="text" name="buscar_juego" placeholder="Buscar juegos..."
                value="{{ request('buscar_juego') }}"
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
        @if ($juegos->isEmpty())
            <p class="text-center p-6 text-lg font-semibold">No hay juegos que mostrar.</p>
        @else
            <table class="min-w-full table-auto text-sm">
                <thead class="bg-[#2e2d55] text-white">
                    <tr>
                        <th class="p-4 text-left">Nombre</th>
                        <th class="p-4 text-left">Mín. Jugadores</th>
                        <th class="p-4 text-left">Máx. Jugadores</th>
                        <th class="p-4 text-left">Dueño</th>
                        <th class="p-4 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($juegos as $juego)
                        <tr class="hover:bg-[#f6d6ba]/60 transition">
                            <td class="p-4">{{ $juego->nombre }}</td>
                            <td class="p-4">{{ $juego->min_jugadores }}</td>
                            <td class="p-4">{{ $juego->max_jugadores }}</td>
                            <td class="p-4">
                                {{ $juego->user->nombre }} {{$juego->user->apellidos  }}
                            </td>
                            <td class="p-4">
                                <div class="flex gap-2">
                                    @can('update', $juego)
                                        <a href="{{ route('juegos.edit', $juego) }}"
                                            class="bg-[#f49d6e] hover:bg-[#e88b5b] text-white px-3 py-1 rounded shadow text-xs">Editar</a>
                                    @endcan
                                    @can('delete', $juego)
                                        <form method="POST" action="{{ route('juegos.destroy', $juego) }}"
                                            onsubmit="return confirm('¿Seguro que quieres eliminar este juego?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded shadow text-xs">Eliminar</button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
