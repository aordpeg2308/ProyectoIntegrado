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

Route::middleware(['auth', 'can:create,App\Models\User'])->group(function () {
    Route::get('/usuarios/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');
});
Route::middleware(['auth', 'can:update,user'])->group(function () {
    Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/user/{user}', [UserController::class, 'update'])->name('users.update');
});
Route::delete('/user/{user}', [UserController::class, 'destroy'])->middleware(['auth', 'can:delete,user'])->name('users.destroy');

Route::middleware(['auth', 'can:create,App\Models\Juego'])->group(function () {
    Route::get('/juegos/create', [JuegoController::class, 'create'])->name('juegos.create');
    Route::post('/juegos', [JuegoController::class, 'store'])->name('juegos.store');
});
Route::middleware(['auth', 'can:update,juego'])->group(function () {
    Route::get('/juegos/{juego}/edit', [JuegoController::class, 'edit'])->name('juegos.edit');
    Route::patch('/juegos/{juego}', [JuegoController::class, 'update'])->name('juegos.update');
});
Route::delete('/juegos/{juego}', [JuegoController::class, 'destroy'])->middleware(['auth', 'can:delete,juego'])->name('juegos.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/partidas', [PartidaController::class, 'index'])->name('partidas.index');
    Route::get('/partidas/creadas', [PartidaController::class, 'creadas'])->name('partidas.creadas');
    Route::get('/partidas/participadas', [PartidaController::class, 'participadas'])->name('partidas.participadas');
    Route::post('/partidas/{partida}/join', [PartidaController::class, 'join'])->name('partidas.join');
    Route::post('/partidas/{partida}/leave', [PartidaController::class, 'leave'])->name('partidas.leave');
});
Route::middleware(['auth', 'can:create,App\Models\Partida'])->group(function () {
    Route::get('/partidas/create', [PartidaController::class, 'create'])->name('partidas.create');
    Route::post('/partidas', [PartidaController::class, 'store'])->name('partidas.store');
});
Route::middleware(['auth', 'can:update,partida'])->group(function () {
    Route::get('/partidas/{partida}/edit', [PartidaController::class, 'edit'])->name('partidas.edit');
    Route::patch('/partidas/{partida}', [PartidaController::class, 'update'])->name('partidas.update');
});
Route::delete('/partidas/{partida}', [PartidaController::class, 'destroy'])->middleware(['auth', 'can:delete,partida'])->name('partidas.destroy');

Route::middleware(['auth', 'can:create,App\Models\Pago'])->group(function () {
    Route::get('/pagos/create', [PagoController::class, 'create'])->name('pagos.create');
    Route::post('/pagos', [PagoController::class, 'store'])->name('pagos.store');
});
Route::get('/pagos/cliente/{user}', [PagoController::class, 'porCliente'])->middleware('auth')->name('pagos.porCliente');
Route::delete('/pagos/{pago}', [PagoController::class, 'destroy'])->middleware('auth')->name('pagos.destroy');

Route::get('/acceso-denegado', function () {
    return view('errors.denegado');
})->name('acceso.denegado');

Route::post('/contacto', [ContactoController::class, 'enviar'])->name('contacto.enviar');
