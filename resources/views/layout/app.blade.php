<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ludus Alea</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        @vite(['resources/css/app.css'])
    @endif
</head>
<body class="flex flex-col min-h-screen text-[#2e2d55] bg-[#f6d6ba] relative">

    <!-- Imagen de fondo centrada -->
    <div class="absolute inset-0 flex justify-center items-center opacity-80 pointer-events-none">
        <img src="{{ asset('logo.png') }}" alt="Fondo Ludus Alea" class="max-h-full max-w-full">
    </div>

    <header class="bg-[#2e2d55] text-white relative z-10">
        @include('partials.navbar')
    </header>

    <main class="flex-grow container mx-auto p-6 rounded-md shadow-md relative z-10">
        @yield('content')
    </main>

    <footer class="bg-[#2e2d55] text-white text-center py-4 relative z-10">
        Aplicación desarrollada por 🦫 en 2025
    </footer>
</body>
</html>
