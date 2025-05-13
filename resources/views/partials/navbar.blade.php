@php
    $currentRoute = request()->path();
    $user = auth()->user();
@endphp

<nav class="flex items-center justify-between px-6 py-4 bg-[#2e2d55]">

    
    <div>
        <a href="/">
            <img src="{{ asset('logo.png') }}" alt="Ludus Alea" class="h-10">
        </a>
    </div>

   
    <div class="flex items-center space-x-6 text-white">
        @guest
            <a href="/login"
               class="{{ $currentRoute === 'login' ? 'text-[#f49d6e] font-semibold' : 'hover:text-[#f49d6e]' }}">
                Log In
            </a>
        @endguest

        @auth
           
            <a href="/partidas/create"
               class="{{ str_starts_with($currentRoute, 'partidas/create') ? 'text-[#f49d6e] font-semibold' : 'hover:text-[#f49d6e]' }}">
                Crear Partida
            </a>

            <a href="/partidas"
               class="{{ $currentRoute === 'partidas' ? 'text-[#f49d6e] font-semibold' : 'hover:text-[#f49d6e]' }}">
                Unirse a Partida
            </a>

            <a href="/user/{{ $user->id }}/edit"
               class="{{ str_contains($currentRoute, 'user') ? 'text-[#f49d6e] font-semibold' : 'hover:text-[#f49d6e]' }}">
                Editar Usuario
            </a>

            @if($user->rol === 'tesorero')
                <a href="/pagos/create"
                   class="{{ str_starts_with($currentRoute, 'pagos/create') ? 'text-[#f49d6e] font-semibold' : 'hover:text-[#f49d6e]' }}">
                    Crear Pago
                </a>
            @endif

            @if($user->rol === 'admin')
                <a href="/usuarios/create"
                   class="{{ str_starts_with($currentRoute, 'usuarios/create') ? 'text-[#f49d6e] font-semibold' : 'hover:text-[#f49d6e]' }}">
                    Crear Usuario
                </a>

                <a href="/juegos/create"
                   class="{{ str_starts_with($currentRoute, 'juegos/create') ? 'text-[#f49d6e] font-semibold' : 'hover:text-[#f49d6e]' }}">
                    Crear Juego
                </a>
            @endif

            
            <form method="POST" action="/logout" class="inline">
                @csrf
                <button type="submit" class="hover:text-[#f49d6e] ml-4">
                    Cerrar sesión
                </button>
            </form>
        @endauth
    </div>
</nav>
