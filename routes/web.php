<?php

use App\Http\Controllers\ContactoController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JuegoController;
use App\Http\Controllers\PartidaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\SessionController;


Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/login', [SessionController::class, 'create'])->middleware('guest')->name('login');
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy'])->middleware('auth')->name('logout');



Route::get('/usuarios/create', [UserController::class, 'create'])->middleware('can:create,App\Models\User')->name('users.create');
Route::post('/usuarios', [UserController::class, 'store'])->middleware('can:create,App\Models\User')->name('users.store');
Route::get('/user/{user}/edit', [UserController::class, 'edit'])->middleware('can:update,user')->name('users.edit');
Route::patch('/user/{user}', [UserController::class, 'update'])->middleware('can:update,user')->name('users.update');
Route::delete('/user/{user}', [UserController::class, 'destroy'])->middleware('can:delete,user')->name('users.destroy');




Route::get('/juegos/create', [JuegoController::class, 'create'])->middleware('can:create,App\Models\Juego')->name('juegos.create');
Route::post('/juegos', [JuegoController::class, 'store'])->middleware('can:create,App\Models\Juego')->name('juegos.store');
Route::get('/juegos/{juego}/edit', [JuegoController::class, 'edit'])->middleware('can:update,juego')->name('juegos.edit');
Route::patch('/juegos/{juego}', [JuegoController::class, 'update'])->middleware('can:update,juego')->name('juegos.update');
Route::delete('/juegos/{juego}', [JuegoController::class, 'destroy'])->middleware('can:delete,juego')->name('juegos.destroy');


Route::get('/partidas', [PartidaController::class, 'index'])->name('partidas.index');
Route::get('/partidas/create', [PartidaController::class, 'create'])->middleware('can:create,App\Models\Partida')->name('partidas.create');
Route::post('/partidas', [PartidaController::class, 'store'])->middleware('can:create,App\Models\Partida')->name('partidas.store');
Route::get('/partidas/{partida}/edit', [PartidaController::class, 'edit'])->middleware('can:update,partida')->name('partidas.edit');
Route::patch('/partidas/{partida}', [PartidaController::class, 'update'])->middleware('can:update,partida')->name('partidas.update');
Route::delete('/partidas/{partida}', [PartidaController::class, 'destroy'])->middleware('can:delete,partida')->name('partidas.destroy');
Route::get('/partidas/creadas', [PartidaController::class, 'creadas']) ->middleware('auth')->name('partidas.creadas');

Route::get('/partidas/participadas', [PartidaController::class, 'participadas'])->middleware('auth')->name('partidas.participadas');

Route::post('/partidas/{partida}/join', [PartidaController::class, 'join'])->middleware('auth')->name('partidas.join');
Route::post('/partidas/{partida}/leave', [PartidaController::class, 'leave'])->middleware('auth')->name('partidas.leave');


Route::get('/pagos/create', [PagoController::class, 'create'])->middleware('can:create,App\Models\Pago')->name('pagos.create');
Route::post('/pagos', [PagoController::class, 'store'])->middleware('can:create,App\Models\Pago')->name('pagos.store');
Route::get('/pagos/cliente/{user}', [PagoController::class, 'porCliente'])->name('pagos.porCliente');
Route::delete('/pagos/{pago}', [PagoController::class, 'destroy'])->name('pagos.destroy');


Route::get('/acceso-denegado', function () {
    return view('errors.denegado');
})->name('acceso.denegado');

Route::post('/contacto', [ContactoController::class, 'enviar'])->name('contacto.enviar');