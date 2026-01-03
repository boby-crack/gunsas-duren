<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gunsas Duren - Rajanya Duren</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            /* PALET WARNA GUNSAS (Premium) */
            --gunsas-gold: #FBC02D;        
            --gunsas-gold-light: #FFF9C4;  
            --gunsas-green: #388E3C;       
            --gunsas-dark: #1B1B1B;        
            --text-grey: #546E7A;          
            --bg-white: #FFFFFF;
            --border-soft: #ECEFF1;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-grey);
            background-color: var(--bg-white);
            overflow-x: hidden;
            line-height: 1.6;
        }

        h1, h2, h3, h4, h5, h6 {
            color: var(--gunsas-dark);
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        /* --- DEKORASI BACKGROUND --- */
        section {
            position: relative;
            overflow: hidden; 
        }
        
        .deco-img {
            position: absolute;
            z-index: 0;
            opacity: 0.15;
            pointer-events: none;
            filter: grayscale(20%);
            transition: transform 0.5s ease;
        }

        .deco-top-right {
            top: -50px;
            right: -80px;
            width: 350px;
            transform: rotate(15deg);
        }
        
        .deco-bottom-left {
            bottom: -50px;
            left: -80px;
            width: 300px;
            transform: rotate(-10deg);
        }

        .deco-center-right {
            top: 50%;
            right: -60px;
            transform: translateY(-50%) rotate(-5deg);
            width: 250px;
        }

        /* Konten harus di atas dekorasi */
        .container {
            position: relative;
            z-index: 2;
        }

        /* --- NAVBAR --- */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--border-soft);
            padding: 15px 0; /* Padding dirapikan */
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
        /* PERBAIKAN TOMBOL DAFTAR MITRA */
        .btn-nav-outline {
            border: 2px solid var(--gunsas-dark);
            color: var(--gunsas-dark);
            border-radius: 50px;
            padding: 8px 24px;
            font-size: 0.9rem;
            font-weight: 700;
            text-transform: uppercase; /* Agar konsisten dengan menu lain */
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            background: transparent;
            text-decoration: none; /* Hilangkan garis bawah link */
            display: inline-block;
        }
        .btn-nav-outline:hover {
            background: var(--gunsas-dark);
            color: var(--gunsas-gold);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

      /* Pastikan tombol dropdown punya warna teks yang jelas */
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

        /* --- HERO SECTION --- */
        .hero-section {
            padding: 140px 0 100px;
            background: linear-gradient(180deg, #FFFCF2 0%, #FFFFFF 100%);
        }
        .hero-badge {
            background-color: var(--gunsas-gold-light);
            color: #F57F17;
            font-weight: 800;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 8px 16px;
            border-radius: 30px;
            display: inline-block;
            margin-bottom: 20px;
        }
        .hero-title {
            font-size: 3.5rem;
            line-height: 1.15;
            margin-bottom: 25px;
        }
        .text-highlight { color: var(--gunsas-gold); }
        .hero-desc {
            font-size: 1.1rem;
            margin-bottom: 40px;
            max-width: 550px;
            color: var(--text-grey);
        }
        .btn-cta-primary {
            background-color: var(--gunsas-green);
            color: white;
            padding: 16px 40px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            border: none;
            box-shadow: 0 10px 25px rgba(56, 142, 60, 0.3);
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-cta-primary:hover {
            transform: translateY(-3px);
            background-color: #2E7D32;
            color: white;
        }
        .btn-cta-secondary {
            background-color: transparent;
            color: var(--gunsas-dark);
            padding: 16px 30px;
            font-weight: 700;
            border-radius: 50px;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
        }
        .btn-cta-secondary:hover { color: var(--gunsas-gold); }

        /* --- FEATURES & CARDS --- */
        .feature-card {
            background: white;
            padding: 40px 30px;
            border-radius: 20px;
            border: 1px solid var(--border-soft);
            transition: all 0.3s;
            height: 100%;
            position: relative;
            z-index: 2;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
            border-color: var(--gunsas-gold);
        }
        .icon-box {
            width: 60px;
            height: 60px;
            background-color: var(--gunsas-gold-light);
            color: #F9A825;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 25px;
        }

        /* --- PRODUCT CARDS --- */
        .product-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid var(--border-soft);
            transition: all 0.3s;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            border-color: var(--gunsas-green);
        }
        .product-img-wrap {
            height: 250px;
            overflow: hidden;
            position: relative;
            background: #FAFAFA;
        }
        .product-img {
            width: 100%; height: 100%; object-fit: cover; transition: 0.5s;
        }
        .product-card:hover .product-img { transform: scale(1.05); }
        .badge-kategori {
            position: absolute; top: 15px; left: 15px;
            background: rgba(255, 255, 255, 0.95);
            color: var(--gunsas-dark);
            font-weight: 700; font-size: 0.75rem;
            padding: 6px 14px; border-radius: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .btn-add-cart {
            width: 100%;
            background-color: var(--gunsas-dark);
            color: var(--gunsas-gold);
            font-weight: 700;
            border: none;
            padding: 12px;
            border-radius: 12px;
            transition: 0.3s;
        }
        .btn-add-cart:hover {
            background-color: var(--gunsas-gold);
            color: var(--gunsas-dark);
        }

        /* --- SKEMA ALUR --- */
        .step-number {
            font-size: 3rem; font-weight: 900;
            color: var(--gunsas-gold); opacity: 0.3;
            line-height: 1; margin-bottom: -15px;
            position: relative; z-index: 0;
        }
        .step-content {
            position: relative; z-index: 1;
            background: white; padding: 20px;
            border-radius: 16px;
            border: 1px solid var(--border-soft);
        }

        /* --- FAQ --- */
        .accordion-item {
            border: 1px solid var(--border-soft);
            border-radius: 12px !important;
            margin-bottom: 15px;
            overflow: hidden;
            background: white;
        }
        .accordion-button {
            background: white;
            color: var(--gunsas-dark);
            font-weight: 700;
            padding: 20px;
            box-shadow: none !important;
        }
        .accordion-button:not(.collapsed) {
            background-color: var(--gunsas-gold-light);
            color: #F57F17;
        }

        /* --- LOKASI CARD --- */
        .location-card-lg {
            border: none;
            border-radius: 20px;
            background: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            overflow: hidden;
            transition: 0.3s;
            height: 100%;
        }
        .location-card-lg:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .location-img-box {
            height: 220px;
            background-color: #EEE;
            position: relative;
        }
        .location-img-full {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .location-badge {
            position: absolute;
            bottom: 15px;
            left: 15px;
            background: white;
            color: var(--gunsas-dark);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 800;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        /* --- FOOTER --- */
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
        footer {
            background-color: var(--gunsas-dark);
            color: #B0BEC5;
            padding-top: 80px;
            padding-bottom: 40px;
            font-size: 0.95rem;
        }
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
        .floating-wa {
            position: fixed; bottom: 30px; right: 30px;
            background-color: var(--gunsas-green); color: white;
            width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
            box-shadow: 0 10px 25px rgba(56, 142, 60, 0.4);
            transition: transform 0.3s; z-index: 1000; text-decoration: none; font-size: 32px;
        }
        .floating-wa:hover { transform: scale(1.1); color: white; }

    </style>
</head>
<body>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show fixed-alert shadow-lg" role="alert">
        <div class="d-flex align-items-center">
            <div class="fs-3 me-3 text-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <h6 class="alert-heading fw-bold mb-0">Berhasil!</h6>
                <small>{{ session('success') }}</small>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show fixed-alert shadow-lg" role="alert">
        <div class="d-flex align-items-center">
            <div class="fs-3 me-3 text-danger">
                <i class="fas fa-times-circle"></i>
            </div>
            <div>
                <h6 class="alert-heading fw-bold mb-0">Gagal!</h6>
                <small>{{ session('error') }}</small>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<style>
    /* CSS Khusus Alert Melayang */
    .fixed-alert {
        position: fixed;
        top: 100px; /* Muncul di bawah navbar */
        right: 20px;
        z-index: 9999; /* Pastikan di atas elemen lain */
        min-width: 300px;
        max-width: 400px;
        border-radius: 12px;
        border: none;
        background: white;
        border-left: 5px solid #198754; /* Garis hijau di kiri */
        animation: slideInRight 0.5s ease-out;
    }
    
    /* Animasi Masuk */
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
</style>

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
                    <li class="nav-item"><a class="nav-link" href="#keunggulan">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('catalog.index') }}">Menu</a></li>
                    <li class="nav-item"><a class="nav-link" href="#skema">Kemitraan</a></li>
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

    <section class="hero-section">
        <img src="{{ asset('assets/img/pancake.png') }}" class="deco-img deco-top-right" alt="Hiasan Pancake">
        
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <span class="hero-badge">
                        <i class="fas fa-crown text-warning me-2"></i> Rajanya Duren
                    </span>
                    
                    <h1 class="hero-title">
                        Taste The <span class="text-highlight">Authentic</span> <br>
                        Of Durian.
                    </h1>
                    
                    <p class="hero-desc">
                        Gunsas Duren menyajikan durian premium dan produk olahan inovatif. Dari Puncak Bogor untuk Indonesia, dengan garansi rasa dan kualitas terbaik.
                    </p>
                    
                    <div class="d-flex align-items-center gap-3 mb-5">
                        <a href="{{ route('register') }}" class="btn-cta-primary">
                            Gabung Mitra
                        </a>
                        <a href="#produk" class="btn-cta-secondary">
                            Lihat Menu <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>

                    <div class="d-flex align-items-center gap-4 pt-4 border-top" style="border-color: rgba(0,0,0,0.05) !important;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background-color: #FFF9C4;">
                                <i class="fas fa-star text-warning fs-5"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 fw-bold" style="font-size: 1.25rem;">4.9/5.0</h4>
                                <small class="text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 1px; text-transform: uppercase;">Google Rating</small>
                            </div>
                        </div>
                        
                        <div style="width: 1px; height: 35px; background-color: #E0E0E0;"></div>

                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background-color: #E8F5E9;">
                                <i class="fas fa-users text-success fs-5"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 fw-bold" style="font-size: 1.25rem;">1000+</h4>
                                <small class="text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 1px; text-transform: uppercase;">Komunitas Loyal</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mt-5 mt-lg-0 text-center" data-aos="fade-left">
                    <div style="position: relative; display: inline-block;">
                        <div style="position: absolute; width: 350px; height: 350px; background: var(--gunsas-gold-light); border-radius: 50%; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: -1;"></div>
                        
                        <img src="{{ asset('assets/img/gambar-hero.webp') }}" 
                             class="img-fluid" 
                             style="max-height: 600px; filter: drop-shadow(0 25px 50px rgba(0,0,0,0.15)); transform: rotate(-5deg);" 
                             alt="Gunsas Signature Product" loading="eager">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="keunggulan" class="py-5 bg-white">
        <img src="{{ asset('assets/img/durian-kupas.png') }}" class="deco-img deco-bottom-left" alt="Hiasan Durian">

        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="text-uppercase fw-bold" style="color: var(--gunsas-gold); letter-spacing: 1px;">Kenapa Gunsas?</span>
                <h2 class="fw-bold mt-2 display-6">Keunggulan Kompetitif</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="icon-box"><i class="fas fa-certificate"></i></div>
                        <h5>Jaminan Kualitas</h5>
                        <p class="text-muted small mb-0">Sistem quality control ketat dari hulu ke hilir untuk memastikan rasa terbaik.</p>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="icon-box"><i class="fas fa-star"></i></div>
                        <h5>Reputasi Terbukti</h5>
                        <p class="text-muted small mb-0">Rating 4.9 di Google Reviews membuktikan tingginya kepuasan pelanggan.</p>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <div class="icon-box"><i class="fas fa-utensils"></i></div>
                        <h5>Menu Beragam</h5>
                        <p class="text-muted small mb-0">Tersedia durian kupas segar hingga produk olahan inovatif.</p>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-card">
                        <div class="icon-box"><i class="fas fa-users-cog"></i></div>
                        <h5>Tim Berpengalaman</h5>
                        <p class="text-muted small mb-0">Didukung tim R&D handal untuk inovasi produk berkelanjutan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="skema" class="py-5" style="background-color: #FAFAFA;">
        <img src="{{ asset('assets/img/soes.png') }}" class="deco-img deco-center-right" style="opacity: 0.1;" alt="Hiasan Soes">

        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="fw-bold display-6">Alur Kemitraan</h2>
                <p class="text-muted">Proses mudah menjadi mitra Gunsas Duren.</p>
            </div>

            <div class="row g-4 justify-content-center">
                <div class="col-lg-3 col-md-6 text-center" data-aos="fade-up">
                    <div class="step-number">01</div>
                    <div class="step-content">
                        <h5 class="fw-bold">Daftar</h5>
                        <p class="text-muted small mb-0">Isi data diri Anda di form registrasi website.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="step-number">02</div>
                    <div class="step-content">
                        <h5 class="fw-bold">Verifikasi</h5>
                        <p class="text-muted small mb-0">Tim kami akan memvalidasi akun Anda.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="step-number">03</div>
                    <div class="step-content border-warning">
                        <h5 class="fw-bold">Order (PO)</h5>
                        <p class="text-muted small mb-0">Pesan min. 5 Box via sistem website.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="step-number">04</div>
                    <div class="step-content">
                        <h5 class="fw-bold">Ambil (H+3)</h5>
                        <p class="text-muted small mb-0">Pickup barang fresh/beku di outlet.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

   <section id="produk" class="py-5">
    
    <div style="position: absolute; bottom: 0; left: 0; opacity: 0.05; pointer-events: none;">
        <img src="{{ asset('assets/img/durian-kupas.png') }}" style="width: 300px;">
    </div>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-end mb-5" data-aos="fade-up">
            <div>
                <span class="text-uppercase fw-bold ls-1" style="color: var(--gunsas-gold); font-size: 0.85rem;">
                    Pilihan Terbaik
                </span>
                <h2 class="fw-bold mt-2 display-6" style="color: var(--gunsas-dark);">
                    Menu Andalan Kami
                </h2>
            </div>
            
            <a href="{{ route('catalog.index') }}" class="btn btn-outline-dark rounded-pill px-4 fw-bold d-none d-md-inline-block">
                Lihat Katalog Penuh <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($products as $product)
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                <div class="product-card h-100 d-flex flex-column bg-white rounded-4 overflow-hidden border">
                    
                    <div class="product-img-wrap position-relative bg-light" style="height: 240px; overflow: hidden;">
                   

                        @if($product->gambar)
                            <img src="{{ asset('storage/' . $product->gambar) }}" 
                                 class="w-100 h-100 object-fit-cover transition-img" 
                                 alt="{{ $product->nama_produk }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                <i class="fas fa-image fa-3x opacity-25"></i>
                            </div>
                        @endif
                    </div>

                    <div class="p-4 d-flex flex-column flex-grow-1">
                        <h5 class="fw-bold mb-2 text-dark">{{ $product->nama_produk }}</h5>
                        <p class="text-muted small mb-3 flex-grow-1" style="line-height: 1.5;">
                            {{ Str::limit($product->deskripsi, 60) }}
                        </p>

                        <div class="mb-3 pb-3 border-bottom">
                            <small class="text-muted d-block fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">HARGA MITRA</small>
                            <span class="fw-bold fs-4" style="color: var(--gunsas-green);">
                                Rp {{ number_format($product->harga_mitra, 0, ',', '.') }}
                            </span>
                            <small class="text-muted">/ box</small>
                        </div>

                        <div class="mt-auto">
                            @if(Auth::check() && Auth::user()->status_akun == 'active')
                                <form action="{{ route('add.to.cart', $product->id) }}" method="POST">
                                    @csrf
                                    
                                    <div class="d-flex align-items-center justify-content-between mb-3 bg-light rounded-pill px-1 py-1 border">
                                        <button type="button" class="btn btn-sm rounded-circle text-muted" style="width: 32px; height: 32px;" onclick="updateQty(this, -5)">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        
                                        <input type="number" name="quantity" class="form-control border-0 bg-transparent text-center fw-bold p-0" 
                                               value="5" min="5" style="width: 50px;" readonly>

                                        <button type="button" class="btn btn-sm rounded-circle text-dark" style="width: 32px; height: 32px; background: white; shadow-sm;" onclick="updateQty(this, 5)">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>

                                    <button type="submit" class="btn btn-dark w-100 rounded-pill fw-bold py-2 btn-hover-gold">
                                        <i class="fas fa-shopping-cart me-2"></i> Masukkan Keranjang
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-dark w-100 rounded-pill fw-bold py-2">
                                    Masuk untuk Memesan
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5 d-md-none">
            <a href="{{ route('catalog.index') }}" class="btn btn-outline-dark rounded-pill px-5 fw-bold">
                Lihat Katalog Penuh
            </a>
        </div>
    </div>
</section>

    <section id="faq" class="py-5" style="background-color: #FAFAFA;">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h2 class="fw-bold display-6">Pertanyaan Umum (FAQ)</h2>
                <p class="text-muted">Informasi penting mengenai sistem kemitraan kami.</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion" data-aos="fade-up">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    📦 Kebijakan Minimal Order
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    Wajib <strong>5 Box per transaksi</strong>. Berlaku untuk setiap order (pertama & seterusnya) untuk menjaga harga grosir.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    ⏱️ Waktu Pengambilan Barang (PO)
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    Kami menerapkan sistem <strong>Pre-Order H+3</strong>. Pesan hari ini, barang disiapkan fresh dan bisa diambil 3 hari kemudian.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    🚚 Info Pengiriman
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    Saat ini hanya melayani <strong>Pickup (Ambil Sendiri)</strong> di outlet. Ini menjamin kualitas barang tetap terjaga saat diterima.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="lokasi" class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <span class="text-uppercase fw-bold text-muted small letter-spacing-1">Jaringan Distribusi</span>
                <h2 class="fw-bold mt-2 display-6">Lokasi Outlet Pickup</h2>
            </div>

            <div class="row g-4 justify-content-center">
                @foreach($tokos as $toko)
                <div class="col-md-6 col-lg-4" data-aos="fade-up">
                    <div class="location-card-lg">
                        <div class="location-img-box">
                            @if($toko->gambar)
                                <img src="{{ asset('storage/' . $toko->gambar) }}" class="location-img-full">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100 text-secondary">
                                    <i class="fas fa-store fa-3x opacity-25"></i>
                                </div>
                            @endif
                            <div class="location-badge">
                                <i class="fas fa-map-marker-alt text-danger me-1"></i> {{ $toko->kota }}
                            </div>
                        </div>
                        <div class="p-4 text-center">
                            <h5 class="fw-bold mb-2">{{ $toko->nama_toko }}</h5>
                            <p class="text-muted small mb-4">{{ Str::limit($toko->alamat_lengkap, 60) }}</p>
                            <a href="{{ $toko->link_maps }}" target="_blank" class="btn btn-outline-dark rounded-pill w-100 fw-bold">
                                Buka di Maps <i class="fas fa-external-link-alt ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

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
                        <li><a href="#produk" class="footer-link">Produk</a></li>
                        <li><a href="#skema" class="footer-link">Cara Gabung</a></li>
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
                &copy; {{ date('Y') }} PT. Gunsas Jaya Berkah. All rights reserved.
            </div>
        </div>
    </footer>

    <a href="https://wa.me/6285180816488" target="_blank" class="floating-wa">
        <i class="fab fa-whatsapp"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true, offset: 50 });
    </script>
    <script>
    function updateQty(btn, amount) {
        const form = btn.closest('form');
        const input = form.querySelector('input[name="quantity"]');
        let currentVal = parseInt(input.value);
        let newVal = currentVal + amount;
        
        // Minimal order 5 box
        if (newVal >= 5) {
            input.value = newVal;
        }
    }
</script>

<script>
    // Hilangkan alert otomatis setelah 3 detik
    setTimeout(function() {
        let alerts = document.querySelectorAll('.fixed-alert');
        alerts.forEach(function(alert) {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 3000);
</script>
    
</body>
</html>