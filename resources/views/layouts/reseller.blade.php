<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Area Mitra - Gunsas Duren</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
        .navbar { background-color: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .nav-link { color: #333; font-weight: 500; }
        .btn-warning { color: #fff; font-weight: 600; }
        .btn-warning:hover { color: #fff; }

        /* Spacer agar konten tidak ketutup navbar fixed */
        .main-content { margin-top: 80px; min-height: 80vh; }
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
                    <li class="nav-item"><a class="nav-link" href="{{ route('catalog.index') }}">Belanja Produk</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle btn btn-light rounded-pill px-4" href="#" role="button" data-bs-toggle="dropdown">
                            Halo, {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item active" href="{{ route('orders.index') }}">
                                    <i class="fas fa-history me-2 text-muted"></i> Riwayat Pesanan
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-content container py-4">
        @yield('content')
    </div>

    <footer class="bg-white py-4 mt-5 border-top">
        <div class="container text-center">
            <p class="mb-0 text-muted">&copy; {{ date('Y') }} Gunsas Duren. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
