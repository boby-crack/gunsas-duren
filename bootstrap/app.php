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
    ->withMiddleware(function (Middleware $middleware): void {

        // 1. Pengecualian CSRF (Agar Midtrans bisa kirim notifikasi)
        $middleware->validateCsrfTokens(except: [
            'midtrans/callback',
            'payment/notification',
        ]);

        // 2. DAFTARKAN MIDDLEWARE BARU DISINI
        // Kita beri nama panggilan 'reseller.active'
        $middleware->alias([
            'reseller.active' => \App\Http\Middleware\EnsureResellerIsActive::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
