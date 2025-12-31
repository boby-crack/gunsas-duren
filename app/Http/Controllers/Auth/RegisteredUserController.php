<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            
            // --- TAMBAHKAN 2 BARIS INI ---
            'role' => 'reseller',        // Set user jadi reseller
            'status_akun' => 'pending',  // Paksa status jadi PENDING
            // -----------------------------
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Ini sudah benar ke dashboard. 
        // Karena statusnya sekarang 'pending', Logic Dashboard di web.php 
        // akan otomatis melempar user ke halaman Upload KTP.
        return redirect(route('dashboard', absolute: false));
    }
}
