@extends('layout.app')

@section('content')
    @guest
        <div class="bg-white/80 p-6 rounded-xl shadow-lg mb-10">
            @include('partials.about')
        </div>
    @else
        <h1 class="text-2xl font-bold mb-8 text-[#2e2d55]">Bienvenido/a {{ auth()->user()->nombre }}</h1>

        @can('viewAny', App\Models\Pago::class)
            <div class="bg-white/80 p-6 rounded-xl shadow-lg mb-10">
                <h2 class="text-2xl font-bold mb-6 mt-4 text-center text-[#2e2d55] drop-shadow">Pagos</h2>
                @include('pagos.index')
        </div>
        @endcan

        @can('viewAny', App\Models\User::class)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                <div class="bg-white/80 p-6 rounded-xl shadow-lg">
                    <h2 class="text-2xl font-bold mb-6 mt-4 text-center text-[#2e2d55] drop-shadow">Usuarios</h2>
                    @include('users.index')
                </div>
                <div class="bg-white/80 p-6 rounded-xl shadow-lg">
                    <h2 class="text-2xl font-bold mb-6 mt-4 text-center text-[#2e2d55] drop-shadow">Juegos</h2>
                    @include('juegos.index')
                </div>
            </div>
        @endcan

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
            <div class="bg-white/80 p-6 rounded-xl shadow-lg">
                <h2 class="text-2xl font-bold mb-6 mt-4 text-center text-[#2e2d55] drop-shadow">Partidas como organizador</h2>
                @include('partidas.organizadas')
            </div>
            <div class="bg-white/80 p-6 rounded-xl shadow-lg">
                <h2 class="text-2xl font-bold mb-6 mt-4 text-center text-[#2e2d55] drop-shadow">Partidas como jugador</h2>
                @include('partidas.participadas')
            </div>
        </div>
    @endguest
@endsection
