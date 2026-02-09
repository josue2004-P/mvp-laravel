<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\UnidadController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\TipoAnalisisController;
use App\Http\Controllers\TipoMetodoController;
use App\Http\Controllers\TipoMuestraController;
use App\Http\Controllers\CategoriaHemogramaCompletoController;
use App\Http\Controllers\HemogramaCompletoController;
use App\Http\Controllers\AnalisisController;
use App\Http\Controllers\EstatusAnalisisController;
use App\Http\Controllers\ConfiguracionAnalisisController;
use App\Http\Controllers\EspecialidadController;

use Illuminate\Support\Facades\Route;

// Route::view('/', 'pages.welcome')->name('home');

// Route::post('/contactar', function (\Illuminate\Http\Request $request) {
//     $request->validate([
//         'nombre' => 'required|string|max:100',
//         'email' => 'required|email',
//         'mensaje' => 'required|string|max:1000',
//     ]);
//     return back()->with('success', 'Mensaje enviado correctamente.');
// })->name('contactar');

Route::middleware(['auth'])->group(function () {
    Route::resource('permisos', PermisoController::class);
    Route::resource('perfiles', PerfilController::class)->parameters(['perfiles' => 'perfil']);
    Route::resource('usuarios', UsuarioController::class);
});

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
    
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
