<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Mencegah redirect HTML untuk request API
        $middleware->redirectGuestsTo(fn (Request $request) => null);

        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureUserRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Kembalikan response 401 Unauthorized JSON jika belum login/token expired
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            return response()->json([
                'status'  => 'error',
                'error'   => '401 Unauthorized',
                'message' => 'Akses Ditolak: Anda belum login atau token telah kadaluarsa.'
            ], 401);
        });

        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => true,
        );
    })->create();
