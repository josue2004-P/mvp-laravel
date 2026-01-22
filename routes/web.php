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

use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.welcome')->name('home');

Route::post('/contactar', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'nombre' => 'required|string|max:100',
        'email' => 'required|email',
        'mensaje' => 'required|string|max:1000',
    ]);
    return back()->with('success', 'Mensaje enviado correctamente.');
})->name('contactar');

Route::middleware(['auth'])->group(function () {
    Route::resource('permisos', PermisoController::class);
    Route::resource('perfiles', PerfilController::class)->parameters([
        'perfiles' => 'perfil'
    ]);
   Route::resource('unidades', UnidadController::class)->parameters([
        'unidades' => 'unidad'
    ]);

    Route::resource('usuarios', UsuarioController::class);
    Route::resource('clientes', ClienteController::class);
    Route::resource('doctores', DoctorController::class)->parameters([
        'doctores' => 'doctor'
        
    ]);
    Route::resource('tipo_analisis', TipoAnalisisController::class)
        ->parameters(['tipo_analisis' => 'tipoAnalisis']);
    Route::resource('tipo_metodo', TipoMetodoController::class);
    Route::resource('tipo_muestra', TipoMuestraController::class);
    Route::resource('categoria_hemograma_completo', CategoriaHemogramaCompletoController::class);
    Route::resource('hemograma_completo', HemogramaCompletoController::class);

    Route::resource('analisis', AnalisisController::class);
    Route::get('/analisis/export/pdf', [AnalisisController::class, 'exportPdf'])->name('analisis-general.pdf');
    Route::get('/analisis/{analisis}/pdf', [AnalisisController::class, 'generarPdf'])->name('analisis.pdf');

    Route::resource('estatus-analisis', EstatusAnalisisController::class)
     ->parameters(['estatus-analisis' => 'estatus']);

    Route::resource('configuracion-analisis', ConfiguracionAnalisisController::class);

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
