@php
    $currentRoute = request()->route()?->getName();
    $user = auth()->user();
@endphp

<nav x-data="{ open: false }" class="bg-slate-700 px-6 py-4">
    <div class="flex items-center justify-between">
        <a href="{{ route('home') }}">
            <div class="relative w-20 h-20">
                <div class="absolute inset-0 rounded-full bg-white/70 blur-sm z-0"></div>
                <img src="{{ asset('logo.png') }}" alt="Ludus Alea" class="relative z-10 w-20 h-20 object-contain">
            </div>
        </a>

        <button @click="open = !open" class="text-white md:hidden focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <div class="hidden md:flex items-center space-x-6 text-white">
            @guest
                <a href="{{ route('login') }}"
                   class="{{ $currentRoute === 'login' ? 'text-[#f49d6e] font-semibold' : 'hover:text-[#f49d6e]' }}">
                    Iniciar Sesión
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
    </div>

    <div x-show="open" class="md:hidden mt-4 flex flex-col space-y-4 text-white">
        @guest
            <a href="{{ route('login') }}"
               class="{{ $currentRoute === 'login' ? 'text-[#f49d6e] font-semibold' : 'hover:text-[#f49d6e]' }}">
                Iniciar Sesión
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

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="hover:text-[#f49d6e]">
                    Cerrar sesión
                </button>
            </form>
        @endauth
    </div>
</nav>
