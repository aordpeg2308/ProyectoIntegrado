@extends('layout.app')

@section('content')
<div class="flex items-center justify-center py-12">
    <div class="bg-[#f6d6ba]/80 shadow-lg rounded-xl p-8 w-full max-w-lg">
        <h2 class="text-2xl font-bold text-center text-[#2e2d55] mb-6">Registrar nuevo pago</h2>

        <form action="{{ route('pagos.store') }}" method="POST" novalidate onsubmit="document.getElementById('submit-btn').disabled = true;">
            @csrf

            <div class="mb-4">
                <label for="user_id" class="block text-[#2e2d55] font-semibold mb-2">Usuario</label>
                <select name="user_id" id="user_id"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f49d6e]">
                    <option value="">Selecciona un usuario</option>
                    @foreach ($usuarios as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->nombre }} {{ $user->apellidos }} ({{ ucfirst($user->tipo) }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="cantidad" class="block text-[#2e2d55] font-semibold mb-2">Cantidad (€)</label>
                <input type="number" name="cantidad" id="cantidad" step="1" min="10"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f49d6e]"
                    value="{{ old('cantidad') }}" placeholder="Ej: 25">
                @error('cantidad')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="fecha" class="block text-[#2e2d55] font-semibold mb-2">Fecha de pago</label>
                <input type="date" name="fecha" id="fecha"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f49d6e]"
                    value="{{ old('fecha', now()->toDateString()) }}">
                @error('fecha')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button id="submit-btn" type="submit"
                class="w-full bg-[#2e2d55] text-white py-2 rounded-lg font-semibold hover:bg-[#1f1e3d] transition">
                Registrar pago
            </button>
        </form>
    </div>
</div>
@endsection
