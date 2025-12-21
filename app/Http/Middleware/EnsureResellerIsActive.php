<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureResellerIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // 1. Jika User adalah Admin/Staff, silakan lewat
        if ($user->role !== 'reseller') {
            return $next($request);
        }

        // 2. Jika Status Masih PENDING (Baru Daftar)
        // Lempar ke form lengkapi profil
        if ($user->status_akun === 'pending') {
            // Cek agar tidak looping (jika sedang buka halaman profil, jangan redirect lagi)
            if ($request->routeIs('profile.complete.*')) {
                return $next($request);
            }
            return redirect()->route('profile.complete.create');
        }

        // 3. Jika Status WAITING (Sudah Upload, Tunggu Admin)
        // Lempar ke halaman tunggu
        if ($user->status_akun === 'waiting_approval') {
            // Cek agar tidak looping
            if ($request->routeIs('verification.notice')) {
                return $next($request);
            }
            return redirect()->route('verification.notice');
        }

        // 4. Jika Status REJECTED (Ditolak)
        if ($user->status_akun === 'rejected') {
            // Jangan redirect loop jika sudah di halaman rejected
            if ($request->routeIs('verification.rejected')) {
                return $next($request);
            }
            // Arahkan ke halaman rejected
            return redirect()->route('verification.rejected');
        }

        // 5. Jika ACTIVE, silakan lanjut belanja
        return $next($request);
    }
}
