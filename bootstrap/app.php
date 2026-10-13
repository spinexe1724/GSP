<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: '*');
        
        // Mengecualikan rute tertentu dari CSRF untuk mencegah error 419 saat lintas tab
        $middleware->validateCsrfTokens(except: [
            '/upload',
            '/admin/login',
            '/showrooms/login',
        ]);

        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, $request) {
            // Jika terjadi 419 Page Expired, kembalikan dengan pesan yang ramah
            return back()->with('error', 'Sesi Anda telah diperbarui. Silakan coba klik sekali lagi.');
        });
    })->create();