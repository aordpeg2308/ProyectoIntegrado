@extends('layout.app')

@section('content')
    <div class="w-full max-w-2xl mx-auto bg-[white]/80 rounded-xl p-10 shadow-2xl z-10">
        <header class="mb-6">
            <img class="w-28 mx-auto" src="{{ asset('logo.png') }}" alt="Logo Ludus Alea">
        </header>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <label class="block mb-1 text-[#2e2d55]" for="email">Email</label>
                <input type="email" name="email" id="email" required
                    class="w-full p-3 text-[#2e2d55] border-b-2 border-[#2e2d55] outline-none focus:bg-[#f49d6e]/50 rounded bg-transparent"
                    placeholder="Introduce tu email" value="{{ old('email') }}">
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block mb-1 text-[#2e2d55]" for="password">Contraseña</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required
                        class="w-full p-3 text-[#2e2d55] border-b-2 border-[#2e2d55] outline-none focus:bg-[#f49d6e]/50 rounded bg-transparent"
                        placeholder="Introduce tu contraseña">

                    <button type="button" onclick="togglePassword()" 
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-[#2e2d55]">
                        <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                             class="w-6 h-6 hidden">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12s-3.75 6.75-9.75 6.75S2.25 12 2.25 12z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>

                        <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                             class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3.98 8.223A10.477 10.477 0 002.25 12c0 .966.137 1.897.392 2.778M6.75 6.75A10.45 10.45 0 0112 5.25c6 0 9.75 6.75 9.75 6.75a10.45 10.45 0 01-1.591 2.507M6.75 6.75L3 3m3.75 3.75l3.749 3.749m0 0a3 3 0 104.242 4.242m-4.242-4.242L12 12m0 0l3.75 3.75m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-[#2e2d55] hover:bg-[#f49d6e] text-white font-bold py-3 px-4 rounded transition">
                    Iniciar sesión
                </button>
            </div>
        </form>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';

            eyeOpen.classList.toggle('hidden', !isHidden);
            eyeClosed.classList.toggle('hidden', isHidden);
        }
    </script>
@endsection
