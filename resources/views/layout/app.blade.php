<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ludus Alea</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/@heroicons/vue@2.0.16/24/solid/index.min.js" defer></script>
        @vite(['resources/css/app.css'])
</head>
<body class="flex flex-col min-h-screen text-[#2e2d55] bg-[#a46f40] relative">

   
    <div class="absolute inset-0 flex justify-center items-center opacity-80 pointer-events-none">
        <img src="{{ asset('logo.png') }}" alt="Fondo Ludus Alea" class="max-h-full max-w-full">
    </div>

    <header class="bg-[#2e2d55] text-white relative z-10">
        @include('partials.navbar')
    </header>

    <main class="flex-grow w-full p-6 relative z-10">

        @yield('content')
    </main>
<footer class="bg-slate-700 text-[#f49d6e] py-6 relative z-10 px-6">
    <div class="w-full max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
        
        <div class="flex items-center space-x-2">
            <span class="text-sm">¡Síguenos!</span>
            <a href="https://www.instagram.com/ludus_alea/" target="_blank" rel="noopener noreferrer" class="hover:text-[#f49d6e]">
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                    <path d="M7.75 2h8.5A5.75 5.75 0 0122 7.75v8.5A5.75 5.75 0 0116.25 22h-8.5A5.75 5.75 0 012 16.25v-8.5A5.75 5.75 0 017.75 2zm0 1.5A4.25 4.25 0 003.5 7.75v8.5A4.25 4.25 0 007.75 20.5h8.5a4.25 4.25 0 004.25-4.25v-8.5A4.25 4.25 0 0016.25 3.5h-8.5zM12 7a5 5 0 110 10 5 5 0 010-10zm0 1.5a3.5 3.5 0 100 7 3.5 3.5 0 000-7zm5.25-.75a1 1 0 110 2 1 1 0 010-2z"/>
                </svg>
            </a>
        </div>

        <p class="text-sm text-gray-300 text-center md:text-right">
            &copy; {{ date('Y') }} Ludus Alea. Todos los derechos reservados.
        </p>
    </div>
</footer>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function () {
                const btn = form.querySelector('#submit-btn');
                if (btn) {
                    btn.disabled = true;
                    btn.classList.add('opacity-50', 'cursor-not-allowed');
                    btn.textContent = 'Enviando...';
                }
            });
        });
    });
</script>



</body>
</html>
