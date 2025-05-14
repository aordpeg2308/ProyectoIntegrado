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
                            👁️
                        </button>
                    </div>
    @error('password')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>


                <div>
                    <button type="submit"
                        class="w-full bg-[#2e2d55] hover:bg-[#f49d6e] text-white font-bold py-3 px-4 rounded transition">
                        Iniciar sesión
                    </button>
                </div>
            </form>
        </div>
    
@endsection
