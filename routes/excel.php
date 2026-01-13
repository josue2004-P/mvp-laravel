<?php

use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel; 
use App\Exports\AnalisisExport;      

use Illuminate\Http\Request;

Route::middleware('auth')->group(function () {
    
    Route::get('analisis/export/excel', function (Request $request) {
        return Excel::download(
            new AnalisisExport(
                $request->query('search'),
                $request->query('doctorId'),
                $request->query('tipoAnalisisId')
            ), 
            'analisis_filtrado.xlsx'
        );
    })->name('analisis.export');
});