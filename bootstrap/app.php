<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    // REGISTER MIDDLEWARE DI SINI (LARAVEL 11/12)
    ->withMiddleware(function (Middleware $middleware): void {

        // Alias middleware custom
        $middleware->alias([
            'role' => RoleMiddleware::class,
        ]);

        // (opsional) middleware global bisa ditaruh di sini
        // $middleware->append(SomeMiddleware::class);
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (\Illuminate\Http\Exceptions\PostTooLargeException $e, $request) {
            return back()->with('error', 'Gagal upload! Ukuran file (video/gambar) terlalu besar dan melebihi batas maksimal.');
        });
    })

    ->create();
