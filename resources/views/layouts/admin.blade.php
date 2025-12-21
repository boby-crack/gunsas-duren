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
        body { background-color: #f8f9fa; }
        .sidebar {
            min-height: 100vh;
            background-color: #343a40; /* Dark Sidebar */
            color: #fff;
        }
        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #495057;
            color: #fff;
        }
        .content { width: 100%; padding: 20px; }
    </style>
</head>
<body>

    <div class="d-flex">
        <div class="sidebar d-flex flex-column flex-shrink-0 p-3" style="width: 250px;">
            <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
              <img src="{{ asset('assets/img/logo-gunsas.png') }}" alt="Gunsas Duren" height="50">
                <span class="ms-4 fs-4">Gunsas Admin</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">

    <li class="nav-item mb-2">
        <a href="{{ route('admin.dashboard') }}"
           class="nav-link rounded {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : 'text-secondary' }}">
            <i class="fa-solid fa-gauge-high me-2"></i> Dashboard
        </a>
    </li>

    @if(auth()->user()->role == 'admin')

        <li class="nav-item mb-2">
            <a href="{{ route('admin.products.index') }}"
               class="nav-link rounded {{ request()->routeIs('admin.products.*') ? 'bg-primary text-white' : 'text-secondary' }}">
                <i class="fa-solid fa-box me-2"></i> Data Produk
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('admin.tokos.index') }}"
               class="nav-link rounded {{ request()->routeIs('admin.tokos.*') ? 'bg-primary text-white' : 'text-secondary' }}">
                <i class="fa-solid fa-store me-2"></i> Data Toko
            </a>
        </li>

        <li class="nav-item {{ Request::routeIs('admin.resellers.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.resellers.index') }}">
        <i class="fas fa-fw fa-users"></i> {{-- Sesuaikan ikon Anda --}}
        <span>Data Reseller</span>

        {{-- LOGIKA BADGE NOTIFIKASI --}}
        @php
            // Menghitung jumlah user yang statusnya 'waiting_approval'
            $waitingCount = \App\Models\User::where('status_akun', 'waiting_approval')->count();
        @endphp

        @if($waitingCount > 0)
            <span class="badge bg-danger badge-counter rounded-pill ms-2">
                {{ $waitingCount }}
                <span class="visually-hidden">permintaan baru</span>
            </span>
        @endif
        {{-- AKHIR LOGIKA --}}

    </a>
</li>

        <li class="nav-item mb-2">
            <a href="{{ route('admin.users.index') }}"
               class="nav-link rounded {{ request()->routeIs('admin.users.*') ? 'bg-primary text-white' : 'text-secondary' }}">
                <i class="fa-solid fa-user-gear me-2"></i> Manage User
            </a>
        </li>

    @endif
    <hr class="sidebar-divider my-3">

    <li class="nav-item mb-2">
        <a href="{{ route('admin.orders.index') }}"
           class="nav-link rounded {{ request()->routeIs('admin.orders.*') ? 'bg-warning text-dark fw-bold' : 'text-warning' }}">
            <i class="fa-solid fa-cart-shopping me-2"></i> Pesanan Masuk

            @php
                if(auth()->user()->role == 'staff') {
                    // Staff cuma hitung orderan tokonya
                    $pendingCount = \App\Models\Order::where('status', 'sudah_bayar')
                                    ->where('toko_id', auth()->user()->toko_id)
                                    ->count();
                } else {
                    // Admin hitung semua
                    $pendingCount = \App\Models\Order::where('status', 'sudah_bayar')->count();
                }
            @endphp

            @if($pendingCount > 0)
                <span class="badge bg-danger ms-auto float-end">{{ $pendingCount }}</span>
            @endif
        </a>
    </li>

    @if(auth()->user()->role == 'admin')
        <li class="nav-item mb-2">
            <a href="{{ route('admin.reports.index') }}"
               class="nav-link rounded {{ request()->routeIs('admin.reports.*') ? 'bg-primary text-white' : 'text-secondary' }}">
                <i class="fa-solid fa-file-invoice me-2"></i> Laporan
            </a>
        </li>
    @endif

</ul>
        </div>

        <div class="w-100">
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm border-bottom">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-user-circle me-1"></i> {{ Auth::user()->name ?? 'Admin' }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#">Profile</a></li>
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

            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
