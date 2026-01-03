<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo-gunsas.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/logo-gunsas.png') }}">
    
    <title>@yield('title', 'Reseller Area - Gunsas Duren')</title>
    
    {{-- CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            /* PALET WARNA GUNSAS */
            --gunsas-gold: #FBC02D;        
            --gunsas-gold-light: #FFF9C4;  
            --gunsas-green: #388E3C;       
            --gunsas-dark: #1B1B1B;        
            --text-grey: #546E7A;          
            --bg-white: #FFFFFF;
            --border-soft: #ECEFF1;
        }

        /* --- SETUP STICKY FOOTER --- */
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-grey);
            background-color: var(--bg-white);
            overflow-x: hidden;
            line-height: 1.6;
            
            /* Flexbox Layout untuk Body */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Wrapper Konten Utama */
        main {
            /* flex: 1 0 auto; akan memaksa main mengisi ruang kosong tersisa */
            flex: 1 0 auto; 
            width: 100%;
            padding-top: 110px; /* Jarak aman dari Navbar Fixed */
            padding-bottom: 50px; /* Jarak aman ke Footer */
        }

        /* Footer */
        footer {
            /* flex-shrink: 0; mencegah footer mengecil/tertekan */
            flex-shrink: 0;
            background-color: var(--gunsas-dark);
            color: #B0BEC5;
            padding-top: 60px;
            padding-bottom: 30px;
            font-size: 0.95rem;
            margin-top: auto; /* Tambahan pengaman */
            border-top: 4px solid var(--gunsas-gold);
        }

        h1, h2, h3, h4, h5, h6 {
            color: var(--gunsas-dark);
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        /* --- NAVBAR --- */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--border-soft);
            padding: 15px 0;
        }
        .nav-link {
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--gunsas-dark) !important;
            margin: 0 12px;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .nav-link:hover {
            color: var(--gunsas-gold) !important;
        }

        /* Tombol Daftar Mitra */
        .btn-nav-outline {
            border: 2px solid var(--gunsas-dark);
            color: var(--gunsas-dark);
            border-radius: 50px;
            padding: 8px 24px;
            font-size: 0.9rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            background: transparent;
            text-decoration: none;
            display: inline-block;
        }
        .btn-nav-outline:hover {
            background: var(--gunsas-dark);
            color: var(--gunsas-gold);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        /* User Dropdown */
        ./* Pastikan tombol dropdown punya warna teks yang jelas */
        .btn-user-dropdown {
            border: 2px solid var(--gunsas-dark);
            color: var(--gunsas-dark) !important; /* Paksa warna gelap Gunsas */
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 700;
            transition: 0.3s;
            background: transparent;
            text-decoration: none;
        }

        /* Saat di-hover atau dropdown dibuka, teks jadi warna emas atau putih */
        .btn-user-dropdown:hover, 
        .show > .btn-user-dropdown {
            background: var(--gunsas-dark);
            color: var(--gunsas-gold) !important;
            border-color: var(--gunsas-dark);
        }

        /* Memperbaiki tampilan item di dalam list dropdown */
        .dropdown-item {
            font-weight: 600;
            color: var(--gunsas-dark);
            transition: 0.2s;
        }

        .dropdown-item:hover {
            background-color: var(--gunsas-gold-light);
            color: var(--gunsas-dark);
        }

        /* Icon Keranjang Navbar */
        .btn-icon-nav {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--gunsas-gold-light);
            color: var(--gunsas-dark);
            border-radius: 50%;
            transition: 0.3s;
        }

        .btn-icon-nav:hover {
            background-color: var(--gunsas-gold);
            color: white;
        }

        /* Footer Elements */
        .footer-heading {
            color: var(--gunsas-gold);
            font-weight: 800;
            margin-bottom: 25px;
            letter-spacing: 1px;
        }
        .footer-link {
            color: #B0BEC5; text-decoration: none; transition: 0.3s;
            display: block; margin-bottom: 10px;
        }
        .footer-link:hover { color: var(--gunsas-gold); padding-left: 5px; }

        /* Floating WA */
        .wa-float {
            position: fixed; bottom: 30px; right: 30px; z-index: 1000;
            background-color: #25d366; color: white; width: 60px; height: 60px;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3); text-decoration: none; transition: 0.3s;
        }
        .wa-float:hover { transform: scale(1.1); color: white; }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('assets/img/logo-gunsas.png') }}" alt="Gunsas Duren" height="45">
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#keunggulan">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('catalog.index') }}">Menu</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#skema">Kemitraan</a></li>
                       @if(Auth::check() && Auth::user()->status_akun == 'active')
                        <li class="nav-item ms-3">
                            <a href="{{ route('cart.index') }}" class="position-relative btn-icon-nav" title="Lihat Keranjang">
                                <i class="fas fa-shopping-cart fs-5"></i>
                                
                                {{-- PERBAIKAN: Hitung jumlah array dari session 'cart' --}}
                                @php
                                    $cart = session('cart', []); // Ambil session, default array kosong
                                    $cartCount = count($cart);   // Hitung jumlah item
                                @endphp

                                @if($cartCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                        </li>
                    @endif
                    
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item dropdown ms-4">
                                <a class="nav-link btn-user-dropdown dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-4 mt-2" aria-labelledby="navbarDropdown">
                                    @if(Auth::user()->role == 'admin')
                                        <li><a class="dropdown-item py-2 fw-bold" href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
                                    @else
                                        <li><a class="dropdown-item py-2" href="{{ route('orders.index') }}">Riwayat Order</a></li>
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item py-2 text-danger fw-bold">Keluar</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item ms-4">
                                <a href="{{ route('login') }}" class="nav-link" style="margin: 0;">Masuk</a>
                            </li>
                            <li class="nav-item ms-3">
                                <a href="{{ route('register') }}" class="btn-nav-outline">Daftar Mitra</a>
                            </li>
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    {{-- WRAPPER KONTEN UTAMA --}}
    {{-- Elemen ini akan memanjang (flex: 1) untuk mendorong footer ke bawah --}}
    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>

    {{-- FOOTER --}}
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h4 class="footer-heading">GUNSAS DUREN</h4>
                    <p class="opacity-75 small">
                        Penyedia durian premium dan produk olahan inovatif. Menghadirkan sensasi rasa otentik dari Puncak, Bogor untuk Indonesia.
                    </p>
                </div>
                <div class="col-lg-2 offset-lg-1 mb-4">
                    <h6 class="text-white fw-bold mb-3">Menu</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link">Beranda</a></li>
                        <li><a href="#" class="footer-link">Produk</a></li>
                        <li><a href="#" class="footer-link">Cara Gabung</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h6 class="text-white fw-bold mb-3">Kontak Kami</h6>
                    <ul class="list-unstyled small opacity-75">
                        <li class="mb-3"><i class="fas fa-phone text-warning me-2"></i> 0851-8081-6488</li>
                        <li class="mb-3"><i class="fas fa-map-marker-alt text-warning me-2"></i> Jl. Raya Puncak No. 412, Cisarua, Bogor</li>
                        <li><i class="fas fa-envelope text-warning me-2"></i> gunsas.duren@gmail.com</li>
                    </ul>
                </div>
                <div class="col-lg-2 mb-4">
                    <h6 class="text-white fw-bold mb-3">Ikuti Kami</h6>
                    <div class="d-flex gap-3">
                        <a href="https://instagram.com/gunsas.duren" class="text-white fs-4"><i class="fab fa-instagram"></i></a>
                        <a href="https://tiktok.com/@gunsas.duren" class="text-white fs-4"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-top border-secondary pt-4 mt-5 text-center small opacity-50">
                &copy; {{ date('Y') }} PT. Gunsas Jaya Berkah. All Rights Reserved.
            </div>
        </div>
    </footer>

    {{-- Floating WhatsApp --}}
    <a href="https://wa.me/6285180816488" class="wa-float" target="_blank">
        <i class="fab fa-whatsapp fs-2"></i>
    </a>

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

    @yield('scripts')

</body>
</html>