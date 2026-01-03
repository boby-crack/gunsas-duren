<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // TAMBAHKAN KODE INI:
        // Jika sedang pakai Ngrok/Production, paksa gunakan HTTPS
        if($this->app->environment('production') || !empty($_SERVER['HTTP_X_FORWARDED_PROTO'])){
            URL::forceScheme('https');
        }
        
        // ATAU CARA PALING "KASAR" TAPI AMPUH (Khusus saat demo Ngrok):
        // Langsung tulis ini saja tanpa if:
        URL::forceScheme('https');
    }
}
