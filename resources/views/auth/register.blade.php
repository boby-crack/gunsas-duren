<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Reseller - Gunsas Duren</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fffdf5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
        }
        .login-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            background: #fff;
            padding: 2rem;
            width: 100%;
            max-width: 500px; /* Sedikit lebih lebar dari login */
        }
        .btn-gold {
            background-color: #f6a600;
            color: white;
            font-weight: 600;
            border-radius: 50px;
            padding: 10px 20px;
            border: none;
            width: 100%;
            transition: 0.3s;
        }
        .btn-gold:hover {
            background-color: #d99000;
            color: white;
            transform: translateY(-2px);
        }
        .form-control {
            border-radius: 10px;
            padding: 12px;
            background-color: #f8f9fa;
            border: 1px solid #eee;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #f6a600;
            background-color: #fff;
        }
        .logo-img {
            height: 70px;
            margin-bottom: 15px;
        }
        .link-gold {
            color: #f6a600;
            text-decoration: none;
            font-weight: 500;
        }
        .link-gold:hover {
            text-decoration: underline;
            color: #d99000;
        }
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center">
        <div class="login-card">
            <div class="text-center">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('assets/img/logo-gunsas.png') }}" alt="Gunsas Duren" class="logo-img">
                </a>
                <h4 class="fw-bold mb-1">Gabung Mitra Reseller</h4>
                <p class="text-muted small mb-4">Mulai bisnis durian Anda bersama kami</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger text-start small py-2">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Budi Santoso" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="Contoh: budi@gmail.com" value="{{ old('email') }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold text-muted">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold text-muted">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                    </div>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required>
                    <label class="form-check-label small text-muted" for="flexCheckDefault">
                        Saya setuju dengan <a href="#" class="link-gold">Syarat & Ketentuan</a> Mitra.
                    </label>
                </div>

                <button type="submit" class="btn btn-gold mb-3">
                    Daftar Sekarang
                </button>

                <div class="text-center small">
                    Sudah punya akun? <a href="{{ route('login') }}" class="link-gold">Masuk disini</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
