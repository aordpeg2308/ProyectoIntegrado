<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página no encontrada - Ludus Alea</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css'])
   
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes portal-spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .portal {
            animation: portal-spin 8s linear infinite;
        }
    </style>
</head>
<body class="bg-black min-h-screen flex items-center justify-center text-center text-white px-4">

    <div class="space-y-8">
        <img src="{{ asset('404.png') }}" alt="404" class="w-64 md:w-80 mx-auto float">

        <h1 class="text-5xl font-bold">Página no encontrada</h1>
   

        <div class="flex flex-col md:flex-row gap-4 justify-center mt-6">
            <a href="{{ route('home') }}" class="px-6 py-3 bg-[#2e2d55] hover:bg-[#f49d6e] text-white rounded-full transition">
                Volver al inicio
            </a>
            <button onclick="window.history.back()" class="px-6 py-3 bg-[#f49d6e] hover:bg-[#2e2d55] text-white rounded-full transition">
                Volver atrás
            </button>
        </div>
    </div>

</body>
</html>
