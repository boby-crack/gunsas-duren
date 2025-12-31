<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Reseller\CatalogController;
use App\Http\Controllers\Reseller\CheckoutController;
use App\Http\Controllers\Reseller\OrderController;
use App\Http\Controllers\Reseller\ProfileCompletionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ResellerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\PaymentCallbackController;

/*
|--------------------------------------------------------------------------
| 1. ROUTE PUBLIK (Bisa Diakses Tanpa Login)
|--------------------------------------------------------------------------
*/

// Halaman Depan (Landing Page)
Route::get('/', [PublicController::class, 'index'])->name('home');

// Halaman Katalog (Bisa lihat produk tanpa login)
Route::get('/katalog', [PublicController::class, 'catalog'])->name('catalog.index');


/*
|--------------------------------------------------------------------------
| 2. ROUTE CALLBACK MIDTRANS (Wajib di Luar Auth)
|--------------------------------------------------------------------------
*/
Route::post('/midtrans/callback', [PaymentCallbackController::class, 'receive']);


/*
|--------------------------------------------------------------------------
| 3. ROUTE KHUSUS MEMBER (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // === A. AREA UMUM / PENGATURAN AKUN ===
    // (Bisa diakses oleh semua status: Pending, Waiting, Active)


   // 1. Logic Redirect Dashboard (Sistem Cerdas)
    Route::get('/dashboard', function () {
        $user = auth()->user();

        // A. Jika Admin/Staff -> Ke Dashboard Admin
        if ($user->role === 'admin' || $user->role === 'staff') {
            return redirect()->route('admin.dashboard');
        }

        // B. Jika Reseller Baru (PENDING) -> Lempar ke Form Lengkapi Profil
        if ($user->status_akun == 'pending') {
            return redirect()->route('profile.complete.create');
        }

        // C. Jika Reseller Menunggu (WAITING) -> Lempar ke Halaman Tunggu
        if ($user->status_akun == 'waiting_approval') {
            return redirect()->route('verification.notice');
        }

        // D. Jika Reseller Ditolak (REJECTED) -> Lempar ke Halaman Penolakan (BARU)
        if ($user->status_akun == 'rejected') {
            return redirect()->route('verification.rejected');
        }

        // E. Jika Reseller Aktif (ACTIVE) -> Arahkan ke Home
        return redirect()->route('home');

    })->name('dashboard');

    Route::get('/pengajuan-ditolak', function() {
        // Cek manual agar user aktif tidak nyasar kesini
        if (auth()->user()->status_akun !== 'rejected') {
            return redirect()->route('dashboard');
        }
        return view('auth.rejected');
    })->name('verification.rejected');

    // 2. Form Lengkapi Profil (Untuk User Status: Pending)
    Route::get('/lengkapi-profil', [ProfileCompletionController::class, 'create'])->name('profile.complete.create');
    Route::post('/lengkapi-profil', [ProfileCompletionController::class, 'store'])->name('profile.complete.store');

    // 3. Halaman Ruang Tunggu (Untuk User Status: Waiting Approval)
    Route::get('/menunggu-verifikasi', function() {
        return view('auth.waiting-approval');
    })->name('verification.notice');

    // 4. Edit Profil User (Ganti Password, Hapus Akun)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // === B. AREA KHUSUS RESELLER AKTIF (PROTEKSI MIDDLEWARE) ===
    // User 'Pending' & 'Waiting' DILARANG MASUK SINI
    Route::middleware(['reseller.active'])->group(function () {

        // Fitur Belanja (Keranjang)
        Route::post('/add-to-cart/{id}', [CatalogController::class, 'addToCart'])->name('add.to.cart');
        Route::get('/keranjang', [CatalogController::class, 'cart'])->name('cart.index');
        Route::delete('/remove-from-cart', [CatalogController::class, 'removeCart'])->name('remove.from.cart');

        // Fitur Checkout & Pembayaran
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
        Route::get('/payment/{id}', [CheckoutController::class, 'payment'])->name('checkout.payment');

        // Riwayat Pesanan (SEKARANG SUDAH AMAN DI DALAM SINI)
        Route::get('/riwayat-pesanan', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/riwayat-pesanan/{id}', [OrderController::class, 'show'])->name('orders.show');
    });


    // === C. AREA ADMIN & STAFF ===
    Route::prefix('admin')->name('admin.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Master Data
        Route::resource('products', ProductController::class);
        Route::resource('tokos', TokoController::class);
        Route::resource('users', UserController::class);

        // Data Reseller
        Route::get('/resellers', [ResellerController::class, 'index'])->name('resellers.index');
        Route::delete('/resellers/{id}', [ResellerController::class, 'destroy'])->name('resellers.destroy');
        // Route Verifikasi (Terima/Tolak)
        Route::post('/resellers/{id}/verify', [ResellerController::class, 'verify'])->name('resellers.verify');

        // Manajemen Pesanan
        Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{id}', [App\Http\Controllers\Admin\OrderController::class, 'update'])->name('orders.update');

        // Laporan
        Route::get('/laporan', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/laporan/cetak', [ReportController::class, 'print'])->name('reports.print');


    });

});

require __DIR__.'/auth.php';
