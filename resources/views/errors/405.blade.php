
@extends('layouts.app')

@section('content')
<div class="text-center py-10">
    <h1 class="text-4xl font-bold text-red-600">405 - Método no permitido</h1>
    <p class="mt-4 text-lg">La acción que intentaste no está permitida. Por favor, vuelve a la página anterior o al inicio.</p>
    <a href="{{ route('home') }}" class="mt-6 inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Volver al inicio</a>
</div>
@endsection
