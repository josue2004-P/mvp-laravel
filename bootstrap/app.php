<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (HttpExceptionInterface $e, Request $request) {

        if ($e->getStatusCode() === 403) {

            // Para Livewire / AJAX
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Operación sin permisos'
                ], 403);
            }

            // Para requests normales
            return redirect()
                ->back()
                ->with('swal', [
                    'icon'  => 'error',
                    'title' => 'Operación no permitida',
                    'text'  => 'No tienes permisos para realizar esta acción'
                ]);
        }
    });
    })->create();
