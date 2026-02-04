<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Gunsas Duren</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    <style>
        body { background-color: #f8f9fa; overflow-x: hidden; margin: 0; }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 250px;
            height: 100vh !important; /* Kunci tinggi seukuran layar */
            position: fixed; /* Melayang di kiri */
            top: 0;
            left: 0;
            background-color: #343a40;
            color: #fff;
            z-index: 1050;
            transition: all 0.3s ease;
            overflow-y: auto; /* MUNCULKAN SCROLL DI SINI */
            display: flex;
            flex-direction: column;
            padding: 1rem;
        }

        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            padding: 12px 15px;
            display: block;
            border-radius: 8px;
            margin-bottom: 5px;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: #495057;
            color: #fff;
        }

        .sidebar .nav-link.active {
            background-color: #0d6efd !important;
            color: white !important;
        }

        /* --- KONTEN UTAMA --- */
        .main-wrapper {
            margin-left: 250px; /* DORONG KONTEN KE KANAN SEJAUH SIDEBAR */
            width: calc(100% - 250px);
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* --- OVERLAY MOBILE --- */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1040;
        }

        /* --- RESPONSIVE MOBILE --- */
        @media (max-width: 991.98px) {
            .sidebar {
                left: -250px; /* Sembunyikan sidebar ke kiri */
            }
            .sidebar.show {
                left: 0; /* Munculkan saat tombol diklik */
            }
            .main-wrapper {
                margin-left: 0; /* Di HP konten penuhi layar */
                width: 100%;
            }
            .sidebar-overlay.show {
                display: block;
            }
        }

        .content { padding: 20px; }

        /* Custom Scrollbar Sidebar */
        .sidebar::-webkit-scrollbar { width: 5px; }
        .sidebar::-webkit-scrollbar-thumb { background: #495057; border-radius: 10px; }
    </style>
</head>
<body>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="sidebar" id="adminSidebar">
        <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-3 text-white text-decoration-none">
            <img src="{{ asset('assets/img/logo-gunsas.png') }}" alt="Gunsas Duren" height="35">
            <span class="ms-2 fs-5 fw-bold">Gunsas Admin</span>
        </a>
        <hr>

        <nav class="nav flex-column mb-auto">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high me-2"></i> Dashboard
            </a>

            @if(auth()->user()->role == 'admin')
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-box me-2"></i> Data Produk
                </a>
                <a href="{{ route('admin.tokos.index') }}" class="{{ request()->routeIs('admin.tokos.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-store me-2"></i> Data Toko
                </a>
                <a href="{{ route('admin.resellers.index') }}" class="{{ request()->routeIs('admin.resellers.*') ? 'active' : '' }}">
                    <i class="fas fa-users me-2"></i> Data Reseller
                    @php $waitingCount = \App\Models\User::where('status_akun', 'waiting_approval')->count(); @endphp
                    @if($waitingCount > 0)
                        <span class="badge bg-danger rounded-pill ms-2">{{ $waitingCount }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-gear me-2"></i> Manage User
                </a>
            @endif

            <hr class="text-secondary">

            <a href="{{ route('admin.orders.index') }}" class="text-warning fw-bold {{ request()->routeIs('admin.orders.*') ? 'bg-warning text-dark' : '' }}">
                <i class="fa-solid fa-cart-shopping me-2"></i> Pesanan Masuk
                @php
                    $pCount = auth()->user()->role == 'staff'
                        ? \App\Models\Order::where('status', 'sudah_bayar')->where('toko_id', auth()->user()->toko_id)->count()
                        : \App\Models\Order::where('status', 'sudah_bayar')->count();
                @endphp
                @if($pCount > 0) <span class="badge bg-danger ms-auto">{{ $pCount }}</span> @endif
            </a>

            @if(auth()->user()->role == 'admin')
                <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-invoice me-2"></i> Laporan
                </a>
            @endif
        </nav>
    </div>

    <div class="main-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm border-bottom p-3">
            <div class="container-fluid">
                <button class="btn btn-outline-primary d-lg-none me-2" id="btnToggleSidebar">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="ms-auto d-flex align-items-center">
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDrop" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-user-circle me-1"></i> {{ Auth::user()->name ?? 'Admin' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="content">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('adminSidebar');
        const btnToggle = document.getElementById('btnToggleSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function toggleMenu() {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }

        if(btnToggle) btnToggle.addEventListener('click', toggleMenu);
        if(overlay) overlay.addEventListener('click', toggleMenu);
    });

     document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('roleSelect');
        const tokoDiv = document.getElementById('tokoDiv');

        // Fungsi untuk Cek Role
        function checkRole() {
            if (roleSelect.value === 'staff') {
                tokoDiv.style.display = 'block'; // Munculkan
            } else {
                tokoDiv.style.display = 'none';  // Sembunyikan
            }
        }

        // 1. Jalankan saat halaman pertama kali dimuat (agar staff yang diedit langsung muncul tokonya)
        checkRole();

        // 2. Jalankan setiap kali role diganti
        roleSelect.addEventListener('change', checkRole);
    });
    </script>
</body>
</html>



