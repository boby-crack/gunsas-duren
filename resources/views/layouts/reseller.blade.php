<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Reseller Area - Gunsas Duren</title>

    {{-- CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #fffdf5; min-height: 100vh; display: flex; flex-direction: column; }

        /* Navbar Style */
        .navbar { background-color: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .nav-link { color: #333; font-weight: 500; }
        .btn-primary-custom { background-color: #f6a600; border: none; color: #fff; padding: 10px 25px; border-radius: 50px; font-weight: 600; transition: 0.3s; }
        .btn-primary-custom:hover { background-color: #d99000; color: #fff; transform: translateY(-2px); }

        /* Footer */
        footer { margin-top: auto; }

        /* Card & Badge */
        .product-card { border: none; border-radius: 15px; background: #fff; transition: 0.3s; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.03); }
        .product-card:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
        .product-img { height: 220px; object-fit: cover; width: 100%; }
        .badge-reseller { background: #ffeeba; color: #856404; font-size: 0.8rem; padding: 5px 10px; border-radius: 20px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}" style="color: #f6a600; font-size: 1.5rem;">
                <img src="{{ asset('assets/img/logo-gunsas.png') }}" alt="Gunsas Duren" height="50"> Gunsas Duren
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-3">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>

                    {{-- Menu Produk --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('catalog.index') ? 'active fw-bold text-warning' : '' }}" href="{{ route('catalog.index') }}">
                            Produk
                        </a>
                    </li>

                    @if (Route::has('login'))
                        @auth
                            {{-- ========================================================= --}}
                            {{-- 1. IKON KERANJANG BELANJA (WAJIB ADA UNTUK CHECKOUT) --}}
                            {{-- ========================================================= --}}
                            <li class="nav-item me-2">
                                <a href="{{ route('cart.index') }}" class="position-relative btn btn-light rounded-circle shadow-sm text-warning" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-shopping-cart"></i>

                                    {{-- Badge Hitungan Barang (Muncul jika ada isi) --}}
                                    @if(session('cart'))
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light">
                                            {{ count(session('cart')) }}
                                        </span>
                                    @endif
                                </a>
                            </li>

                            {{-- 2. Dropdown User --}}
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle btn btn-light rounded-pill px-4" href="#" role="button" data-bs-toggle="dropdown">
                                    Halo, {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu shadow border-0">

                                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'staff')
                                        <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
                                    @else
                                        @if(Auth::user()->status_akun == 'active')
                                            <li><a class="dropdown-item" href="{{ route('orders.index') }}">Riwayat Pesanan</a></li>
                                            <li><a class="dropdown-item" href="{{ route('catalog.index') }}">Belanja Produk</a></li>
                                        @elseif(Auth::user()->status_akun == 'pending')
                                            <li><a class="dropdown-item" href="{{ route('profile.complete.create') }}">Lengkapi Profil</a></li>
                                        @elseif(Auth::user()->status_akun == 'waiting_approval')
                                            <li><a class="dropdown-item" href="{{ route('verification.notice') }}">Cek Status</a></li>
                                        @endif
                                    @endif

                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Pengaturan Akun</a></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Masuk</a></li>
                            <li class="nav-item"><a href="{{ route('register') }}" class="btn btn-primary-custom">Daftar Reseller</a></li>
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <main style="margin-top: 100px;">
        @yield('content')
    </main>

    <footer class="bg-dark text-white pt-5 pb-3 mt-5">
        <div class="container text-center">
            <p class="small text-secondary">© {{ date('Y') }} PT. Gunsas Jaya Berkah. Mitra Reseller Area.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateQty(btn, amount) {
            const form = btn.closest('form');
            const input = form.querySelector('input[name="quantity"]');
            let currentVal = parseInt(input.value);
            let newVal = currentVal + amount;
            if (newVal >= 5) input.value = newVal;
        }
    </script>
    {{-- INI DIA YANG HILANG! --}}
    {{-- Tempat untuk menyuntikkan script dari halaman anak (seperti cart/index) --}}
    @yield('scripts')

</body>
</html>
