<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Gunsas Duren - Supplier Durian Premium</title>

    {{-- CSS & Font --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #fffdf5; scroll-behavior: smooth; }

        /* Navbar Style */
        .navbar { background-color: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .nav-link { color: #333; font-weight: 500; }
        .btn-primary-custom { background-color: #f6a600; border: none; color: #fff; padding: 10px 25px; border-radius: 50px; font-weight: 600; transition: 0.3s; }
        .btn-primary-custom:hover { background-color: #d99000; color: #fff; transform: translateY(-2px); }

        /* Hero Section */
        .hero-section { padding: 80px 0; display: flex; align-items: center; }
        .hero-title { font-size: 3.5rem; font-weight: 700; color: #2d2d2d; line-height: 1.2; }
        .hero-title span { color: #f6a600; }
        .hero-desc { color: #666; font-size: 1.1rem; margin: 20px 0 30px; }
        .hero-img { width: 100%; border-radius: 20px; box-shadow: 0 20px 40px rgba(246, 166, 0, 0.2); }

        /* Product Card */
        .product-card { border: none; border-radius: 15px; background: #fff; transition: 0.3s; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.03); }
        .product-card:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
        .product-img { height: 220px; object-fit: cover; width: 100%; }
        .badge-reseller { background: #ffeeba; color: #856404; font-size: 0.8rem; padding: 5px 10px; border-radius: 20px; }

        /* Lokasi Hover */
        .hover-top { transition: transform 0.3s; }
        .hover-top:hover { transform: translateY(-5px); }

        /* Floating WA */
        a[href*="wa.me"]:hover { transform: scale(1.1); }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
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

                    {{-- Menu Utama --}}
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('catalog.index') }}">Produk</a></li>

                    @if (Route::has('login'))
                        @auth
                            {{-- 1. IKON KERANJANG --}}
                            <li class="nav-item me-2">
                                <a href="{{ route('cart.index') }}" class="position-relative btn btn-light rounded-circle shadow-sm text-warning" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-shopping-cart"></i>
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
                                        <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-2 text-warning"></i> Dashboard Admin</a></li>
                                    @else
                                        @if(Auth::user()->status_akun == 'active')
                                            <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="fas fa-history me-2 text-muted"></i> Riwayat Pesanan</a></li>
                                            <li><a class="dropdown-item" href="{{ route('catalog.index') }}"><i class="fas fa-shopping-bag me-2 text-muted"></i> Belanja Produk</a></li>
                                        @elseif(Auth::user()->status_akun == 'pending')
                                            <li><a class="dropdown-item" href="{{ route('profile.complete.create') }}"><i class="fas fa-file-upload me-2 text-danger"></i> Lengkapi Profil</a></li>
                                        @elseif(Auth::user()->status_akun == 'waiting_approval')
                                            <li><a class="dropdown-item" href="{{ route('verification.notice') }}"><i class="fas fa-clock me-2 text-info"></i> Cek Status Verifikasi</a></li>
                                        @endif
                                    @endif

                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user-cog me-2 text-muted"></i> Pengaturan Akun</a></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Masuk</a></li>
                            <li class="nav-item"><a href="{{ route('register') }}" class="btn btn-primary-custom">Daftar Reseller</a></li>
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section mt-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="hero-title">Rasakan Nikmatnya <br><span>Durian Premium</span></h1>
                    <p class="hero-desc">Supplier tangan pertama durian kupas dan olahan durian terbaik. Gabung menjadi mitra reseller kami dan dapatkan harga spesial untuk keuntungan maksimal.</p>
                    <div class="d-flex gap-3">
                        <a href="#katalog" class="btn btn-primary-custom">Lihat Produk</a>
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-outline-warning rounded-pill px-4 py-2 fw-bold">Gabung Mitra</a>
                        @endguest
                    </div>
                </div>
                <div class="col-lg-6 text-center mt-4 mt-lg-0">
                    <img src="https://images.unsplash.com/photo-1587049352846-4a222e784d38?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Durian Banner" class="hero-img">
                </div>
            </div>
        </div>
    </section>

    {{-- BAGIAN MITRA RESELLER TELAH DIHAPUS SESUAI PERMINTAAN --}}

    <section id="katalog" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge-reseller mb-2">Pilihan Terbaik</span>
                <h2 class="fw-bold">Produk Unggulan Kami</h2>
            </div>

            <div class="row g-4">
                @foreach($products as $product)
                <div class="col-md-4 col-lg-3">
                    <div class="product-card h-100">
                        @if($product->gambar)
                            <img src="{{ asset('storage/' . $product->gambar) }}" class="product-img" alt="{{ $product->nama_produk }}">
                        @else
                            <img src="https://via.placeholder.com/300x300?text=No+Image" class="product-img" alt="Placeholder">
                        @endif

                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-2">{{ $product->nama_produk }}</h5>
                            <p class="text-muted small mb-3">{{ Str::limit($product->deskripsi, 50) }}</p>

                            <h5 class="text-warning fw-bold mb-3">Rp {{ number_format($product->harga_mitra, 0, ',', '.') }}</h5>

                            @auth
                                @if(Auth::user()->status_akun == 'active')
                                    <form action="{{ route('add.to.cart', $product->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="quantity" value="5">

                                        <div class="d-flex align-items-center justify-content-between mb-2 border rounded px-2 py-1">
                                            <button type="button" class="btn btn-sm text-secondary" onclick="updateQty(this, -5)"><i class="fas fa-minus"></i></button>
                                            <input type="number" name="quantity" class="form-control border-0 text-center fw-bold bg-transparent p-0" value="5" min="5" style="width: 50px;" readonly>
                                            <button type="button" class="btn btn-sm text-secondary" onclick="updateQty(this, 5)"><i class="fas fa-plus"></i></button>
                                        </div>

                                        <button type="submit" class="btn btn-sm btn-dark w-100 rounded-pill">
                                            <i class="fas fa-cart-plus me-2"></i> Tambah ke Keranjang
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary w-100 rounded-pill">
                                        <i class="fas fa-lock me-2"></i> Verifikasi Akun Dulu
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-sm btn-primary-custom w-100">
                                    <i class="fas fa-sign-in-alt me-2"></i> Masuk untuk Memesan
                                </a>
                            @endauth

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- SECTION LOKASI CABANG (SUDAH DIPERBAIKI LINK MAPS-NYA) --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Lokasi Cabang (Pickup Point)</h2>
                <p class="text-muted">Temukan cabang Gunsas Duren terdekat dari lokasi Anda</p>
            </div>

            <div class="row justify-content-center">
                @forelse($tokos as $toko)
                <div class="col-md-4 mb-4">
                    {{-- Tambahkan position-relative agar stretched-link berfungsi --}}
                    <div class="card h-100 border-0 shadow-sm hover-top position-relative">
                        <div class="card-body text-center p-4">
                            <div class="mb-3 text-warning">
                                <i class="fas fa-map-marker-alt fa-3x"></i>
                            </div>
                            <h5 class="fw-bold">{{ $toko->nama_toko }}</h5>
                            <p class="text-muted small mb-3">{{ $toko->alamat }}</p>
                            <hr class="border-light">
                            <div class="d-flex justify-content-between text-muted small">
                                <span><i class="fas fa-city me-1"></i> {{ $toko->kota }}</span>

                                {{-- PERBAIKAN LINK MAPS + STRETCHED-LINK --}}
                                {{-- Cek apakah admin sudah mengisi link maps yang spesifik? --}}
                                    @if($toko->link_maps)
                                        <a href="{{ $toko->link_maps }}" target="_blank" class="text-warning text-decoration-none fw-bold stretched-link">
                                            Lihat Peta <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    @else
                                        {{-- Fallback: Jika link kosong, tetap gunakan pencarian otomatis --}}
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($toko->nama_toko . ' ' . $toko->kota) }}" target="_blank" class="text-warning text-decoration-none fw-bold stretched-link">
                                            Lihat Peta <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada lokasi cabang yang tersedia.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Apa Kata Mitra Kami?</h2>
                <p class="text-muted">Ribuan reseller telah sukses bersama Gunsas Duren</p>
            </div>
            <div class="row">
                {{-- Testimoni 1 --}}
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm p-3 h-100">
                        <div class="card-body">
                            <div class="mb-3 text-warning"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                            <p class="fst-italic text-muted">"Kualitas duriannya stabil banget, pelanggan saya jarang komplain. Sistem order lewat web juga gampang."</p>
                            <div class="d-flex align-items-center mt-3">
                                <img src="https://randomuser.me/api/portraits/men/32.jpg" class="rounded-circle me-3" width="50">
                                <div><h6 class="fw-bold mb-0">Pak Hendra</h6><small class="text-muted">Reseller Jakarta Selatan</small></div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Testimoni 2 --}}
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm p-3 h-100">
                        <div class="card-body">
                            <div class="mb-3 text-warning"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                            <p class="fst-italic text-muted">"Awalnya ragu, tapi pas coba order ternyata proses ambil barang di cabang lancar. Untungnya lumayan banget."</p>
                            <div class="d-flex align-items-center mt-3">
                                <img src="https://randomuser.me/api/portraits/women/44.jpg" class="rounded-circle me-3" width="50">
                                <div><h6 class="fw-bold mb-0">Ibu Sari</h6><small class="text-muted">Reseller Bogor</small></div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Testimoni 3 --}}
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm p-3 h-100">
                        <div class="card-body">
                            <div class="mb-3 text-warning"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></div>
                            <p class="fst-italic text-muted">"Stok selalu aman. Paling suka fitur riwayat pesanan, jadi saya bisa rekap pengeluaran bulanan dengan mudah."</p>
                            <div class="d-flex align-items-center mt-3">
                                <img src="https://randomuser.me/api/portraits/men/85.jpg" class="rounded-circle me-3" width="50">
                                <div><h6 class="fw-bold mb-0">Mas Dimas</h6><small class="text-muted">Reseller Depok</small></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="py-5 bg-light">
        <div class="container" style="max-width: 800px;">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Pertanyaan Umum (FAQ)</h2>
            </div>
            <div class="accordion shadow-sm" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">Apakah ada minimal pembelian?</button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                        <div class="accordion-body text-muted">Ya, untuk mendapatkan harga khusus Reseller, minimal pembelian pertama adalah 5 Box. Pembelian selanjutnya bebas tanpa minimal order.</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">Kapan barang bisa diambil setelah pesan?</button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body text-muted">Sistem kami menerapkan H+3. Jika Anda memesan hari Senin, barang siap diambil hari Kamis. Ini untuk memastikan kualitas stok durian yang fresh.</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">Apakah bisa dikirim ke rumah?</button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body text-muted">Saat ini kami hanya melayani sistem <strong>Ambil di Cabang (Pickup)</strong> untuk menjaga kualitas beku produk dan menekan biaya ongkir Anda.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h4 class="text-warning fw-bold mb-3">Gunsas Duren</h4>
                    <p class="small text-secondary">Penyedia durian kupas dan olahan durian premium nomor 1 di Indonesia. Kami berkomitmen memberdayakan mitra reseller untuk sukses bersama.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-tiktok fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Tautan Cepat</h5>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('home') }}" class="text-secondary text-decoration-none">Beranda</a></li>
                        <li class="mb-2"><a href="{{ route('catalog.index') }}" class="text-secondary text-decoration-none">Katalog Produk</a></li>
                        <li class="mb-2"><a href="{{ route('register') }}" class="text-secondary text-decoration-none">Daftar Mitra</a></li>
                        <li class="mb-2"><a href="{{ route('login') }}" class="text-secondary text-decoration-none">Login Member</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Hubungi Kami</h5>
                    <ul class="list-unstyled small text-secondary">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-warning"></i> Jl. Raya Durian No. 88, Bogor, Jawa Barat</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2 text-warning"></i> info@gunsasduren.com</li>
                        <li class="mb-2"><i class="fab fa-whatsapp me-2 text-warning"></i> +62 812-3456-7890</li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center small text-secondary">
                © {{ date('Y') }} PT. Gunsas Jaya Berkah. All Rights Reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <a href="https://wa.me/6282194229108?text=Halo%20Admin%20Gunsas,%20saya%20mau%20tanya%20tentang%20reseller"
       target="_blank"
       style="position: fixed; bottom: 30px; right: 30px; z-index: 1000; background-color: #25d366; color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0,0,0,0.3); text-decoration: none; transition: 0.3s;">
        <i class="fab fa-whatsapp" style="font-size: 35px;"></i>
    </a>

    <script>
    function updateQty(btn, amount) {
        const form = btn.closest('form');
        const input = form.querySelector('input[name="quantity"]');
        let currentVal = parseInt(input.value);
        let newVal = currentVal + amount;
        if (newVal >= 5) input.value = newVal;
    }
    </script>

</body>
</html>
