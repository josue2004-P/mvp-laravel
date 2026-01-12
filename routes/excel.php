<?php

use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel; // Importante para la fachada
use App\Exports\AnalisisExport;       // Importante para tu clase de exportación

Route::middleware('auth')->group(function () {
    
    Route::get('analisis/export/excel', function () {
        return Excel::download(new AnalisisExport, 'analisis.xlsx');
    })->name('analisis.export');

});