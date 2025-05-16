@extends('layout.app')

@section('content')
    <div class="bg-white/80 p-6 rounded-xl shadow-lg max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-center text-[#2e2d55]">
            Pagos realizados por {{ $user->nombre }}
        </h2>

        <table class="min-w-full table-auto text-sm mb-6">
            <thead class="bg-[#2e2d55] text-white">
                <tr>
                    <th class="p-4 text-left">Fecha</th>
                    <th class="p-4 text-left">Cantidad</th>
                    <th class="p-4 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($pagos as $pago)
                    <tr class="hover:bg-[#f6d6ba]/60 transition">
                        <td class="p-4">{{ \Carbon\Carbon::parse($pago->fecha)->format('d/m/Y') }}</td>
                        <td class="p-4">{{ $pago->cantidad }} €</td>
                        <td class="p-4">
                            <form action="{{ route('pagos.destroy', $pago) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-4 text-center text-gray-500">No hay pagos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="text-center">
            <a href="{{ route('home') }}" class="text-[#2e2d55] underline hover:text-[#f49d6e]">Volver al inicio</a>
        </div>
    </div>
@endsection
