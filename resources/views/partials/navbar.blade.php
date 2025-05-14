@php
    $currentRoute = request()->route()?->getName();
    $user = auth()->user();
@endphp
<nav class="flex items-center justify-between px-6 py-4 bg-slate-700">
    <div>
        <a href="{{ route('home') }}">
           <img src="{{ asset('logo.png') }}" alt="Ludus Alea" class="h-28 -my-3">

        </a>
    </div>

    <div class="flex items-center space-x-6 text-white">
        @guest
            <a href="{{ route('login') }}"
               class="{{ $currentRoute === 'login' ? 'text-[#f49d6e] font-semibold' : 'hover:text-[#f49d6e]' }}">
                Log In
            </a>
        @endguest

        @auth
            
            @can('create', App\Models\Partida::class)
                <a href="{{ route('partidas.create') }}"
                   class="{{ $currentRoute === 'partidas.create' ? 'text-[#f49d6e] font-semibold' : 'hover:text-[#f49d6e]' }}">
                    Crear Partida
                </a>
            @endcan

           
            <a href="{{ route('partidas.index') }}"
               class="{{ $currentRoute === 'partidas.index' ? 'text-[#f49d6e] font-semibold' : 'hover:text-[#f49d6e]' }}">
                Unirse a Partida
            </a>

            
            @can('update', $user)
                <a href="{{ route('users.edit', $user) }}"
                   class="{{ str_contains($currentRoute, 'users.edit') ? 'text-[#f49d6e] font-semibold' : 'hover:text-[#f49d6e]' }}">
                    Editar Usuario
                </a>
            @endcan

            
            @can('create', App\Models\Pago::class)
                <a href="{{ route('pagos.create') }}"
                   class="{{ $currentRoute === 'pagos.create' ? 'text-[#f49d6e] font-semibold' : 'hover:text-[#f49d6e]' }}">
                    Crear Pago
                </a>
            @endcan

            
            @can('create', App\Models\User::class)
                <a href="{{ route('users.create') }}"
                   class="{{ $currentRoute === 'users.create' ? 'text-[#f49d6e] font-semibold' : 'hover:text-[#f49d6e]' }}">
                    Crear Usuario
                </a>
            @endcan

           
            @can('create', App\Models\Juego::class)
                <a href="{{ route('juegos.create') }}"
                   class="{{ $currentRoute === 'juegos.create' ? 'text-[#f49d6e] font-semibold' : 'hover:text-[#f49d6e]' }}">
                   Añadir Juego
                </a>
            @endcan

           
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="hover:text-[#f49d6e] ml-4">
                    Cerrar sesión
                </button>
            </form>
        @endauth
    </div>
</nav>
