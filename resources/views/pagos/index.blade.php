<div class="bg-white/80 p-6 rounded-xl shadow-lg mb-10">
    <h2 class="text-2xl font-bold mb-6 text-center text-[#2e2d55]">Próximo pago por usuario</h2>

    <form method="GET" action="{{ route('home') }}" class="max-w-md mx-auto mb-6">
        <input type="text" name="buscar_pago_usuario"
            value="{{ request('buscar_pago_usuario') }}"
            placeholder="Buscar por nombre..."
            class="w-full h-11 pl-4 pr-4 rounded-full border border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:outline-none shadow focus:ring-2 focus:ring-[#f49d6e]">
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto text-sm">
            <thead class="bg-[#2e2d55] text-white">
                <tr>
                    <th class="p-4 text-left">Nombre</th>
                    <th class="p-4 text-left">Tipo</th>
                    <th class="p-4 text-left">Estado</th>
                    <th class="p-4 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($proximosPagos as $pago)
                    <tr class="hover:bg-[#f6d6ba]/60 transition">
                        <td class="p-4">{{ $pago['nombre'] }}</td>
                        <td class="p-4 capitalize">{{ $pago['tipo'] }}</td>
                        <td class="p-4">
                            @if ($pago['estado_pago'] === 'ok')
                                <span class="text-green-700 font-semibold">
                                    Próximo pago: {{ \Carbon\Carbon::parse($pago['proximo_pago'])->format('d/m/Y') }}
                                </span>
                            @else
                                <span class="text-red-600 font-semibold">
                                    {{ $pago['mensaje'] }}
                                </span>
                            @endif
                        </td>
                        <td class="p-4">
                            @php
                                $usuario = \App\Models\User::where('nombre', $pago['nombre'])->first();
                            @endphp
                            @if($usuario)
                                <a href="{{ route('pagos.porCliente', $usuario->id) }}"
                                    class="bg-[#2e2d55] text-white px-3 py-1 rounded hover:bg-[#f49d6e] transition whitespace-nowrap min-w-fit text-sm">
                                    Ver pagos
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
