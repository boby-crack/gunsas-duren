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
        body { background-color: #f8f9fa; overflow-x: hidden; }

        /* Sidebar Styling */
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            color: #fff;
            width: 250px;
            transition: all 0.3s ease;
            z-index: 1050;
            position: sticky;
            top: 0;
        }

        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            transition: 0.2s;
        }

        .sidebar a:hover, .sidebar a.active-link {
            background-color: #495057;
            color: #fff;
        }

        /* Overlay untuk Mobile */
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

        /* Responsivitas Mobile (Layar < 992px) */
        @media (max-width: 991.98px) {
            .sidebar {
                position: fixed;
                left: -250px; /* Sembunyi ke kiri */
            }
            .sidebar.show {
                left: 0; /* Muncul saat toggle diklik */
            }
            .sidebar-overlay.show {
                display: block;
            }
        }

        .content { width: 100%; padding: 20px; }
        .nav-link.active { background-color: #0d6efd !important; color: white !important; }
    </style>
</head>
<body>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="d-flex">
        <div class="sidebar d-flex flex-column flex-shrink-0 p-3" id="adminSidebar">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <img src="{{ asset('assets/img/logo-gunsas.png') }}" alt="Gunsas Duren" height="40">
                <span class="ms-3 fs-5 fw-bold">Gunsas Admin</span>
            </a>
            <hr>

            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link rounded {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-secondary' }}">
                        <i class="fa-solid fa-gauge-high me-2"></i> Dashboard
                    </a>
                </li>

                @if(auth()->user()->role == 'admin')
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.products.index') }}"
                           class="nav-link rounded {{ request()->routeIs('admin.products.*') ? 'active' : 'text-secondary' }}">
                            <i class="fa-solid fa-box me-2"></i> Data Produk
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.tokos.index') }}"
                           class="nav-link rounded {{ request()->routeIs('admin.tokos.*') ? 'active' : 'text-secondary' }}">
                            <i class="fa-solid fa-store me-2"></i> Data Toko
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.resellers.index') }}"
                           class="nav-link rounded {{ request()->routeIs('admin.resellers.*') ? 'active' : 'text-secondary' }}">
                            <i class="fas fa-users me-2"></i> Data Reseller
                            @php
                                $waitingCount = \App\Models\User::where('status_akun', 'waiting_approval')->count();
                            @endphp
                            @if($waitingCount > 0)
                                <span class="badge bg-danger rounded-pill ms-2">{{ $waitingCount }}</span>
                            @endif
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.users.index') }}"
                           class="nav-link rounded {{ request()->routeIs('admin.users.*') ? 'active' : 'text-secondary' }}">
                            <i class="fa-solid fa-user-gear me-2"></i> Manage User
                        </a>
                    </li>
                @endif

                <hr class="sidebar-divider my-2">

                <li class="nav-item mb-2">
                    <a href="{{ route('admin.orders.index') }}"
                       class="nav-link rounded {{ request()->routeIs('admin.orders.*') ? 'bg-warning text-dark fw-bold' : 'text-warning' }}">
                        <i class="fa-solid fa-cart-shopping me-2"></i> Pesanan Masuk
                        @php
                            if(auth()->user()->role == 'staff') {
                                $pendingCount = \App\Models\Order::where('status', 'sudah_bayar')
                                                ->where('toko_id', auth()->user()->toko_id)->count();
                            } else {
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
                           class="nav-link rounded {{ request()->routeIs('admin.reports.*') ? 'active' : 'text-secondary' }}">
                            <i class="fa-solid fa-file-invoice me-2"></i> Laporan
                        </a>
                    </li>
                @endif
            </ul>
        </div>

        <div class="w-100">
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-outline-primary d-lg-none me-2" id="btnToggleSidebar">
                        <i class="fa-solid fa-bars"></i>
                    </button>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDrop" role="button" data-bs-toggle="dropdown">
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
        // --- LOGIKA SIDEBAR MOBILE ---
        const sidebar = document.getElementById('adminSidebar');
        const btnToggle = document.getElementById('btnToggleSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function toggleMobileMenu() {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }

        if(btnToggle) btnToggle.addEventListener('click', toggleMobileMenu);
        if(overlay) overlay.addEventListener('click', toggleMobileMenu);


        // --- LOGIKA ROLE STAFF (DROPDOWN TOKO) ---
        const roleSelect = document.getElementById('roleSelect');
        const tokoDiv = document.getElementById('tokoDiv');

        function checkRole() {
            if (roleSelect && roleSelect.value === 'staff') {
                tokoDiv.style.display = 'block';
            } else if (roleSelect) {
                tokoDiv.style.display = 'none';
            }
        }

        checkRole();
        if(roleSelect) roleSelect.addEventListener('change', checkRole);
    });
    </script>
</body>
</html>
