<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $titulo }}</title>
</head>
<body style="background-color: #fef3c7; font-family: sans-serif; padding: 2rem;">
    <div style="text-align: center;">
        <img src="https://i.postimg.cc/SRdtzFJ9/logo.png" alt="Logo" style="max-width: 200px; margin-bottom: 1.5rem;">
    </div>

    <div style="background-color: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
        <h2 style="color: #2e2d55;">{{ $titulo }}</h2>
        <p>{!! nl2br(e($mensaje)) !!}</p>
    </div>
</body>
</html>
