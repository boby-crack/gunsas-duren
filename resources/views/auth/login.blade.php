<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Gunsas Duren</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fffdf5; /* Cream lembut */
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            background: #fff;
            padding: 2rem;
            width: 100%;
            max-width: 450px;
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
            height: 80px;
            margin-bottom: 20px;
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
        <div class="login-card text-center">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/img/logo-gunsas.png') }}" alt="Gunsas Duren" class="logo-img">
            </a>

            <h4 class="fw-bold mb-1">Selamat Datang Kembali</h4>
            <p class="text-muted small mb-4">Silakan masuk untuk mengelola pesanan Anda</p>

            @if ($errors->any())
                <div class="alert alert-danger text-start small py-2">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="text-start">
                @csrf

                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="Masukan email..." value="{{ old('email') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label class="form-label small fw-bold text-muted">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="small link-gold">Lupa Password?</a>
                        @endif
                    </div>
                    <input type="password" name="password" class="form-control" placeholder="Masukan password..." required>
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                    <label class="form-check-label small text-muted" for="remember_me">Ingat Saya</label>
                </div>

                <button type="submit" class="btn btn-gold mb-3">
                    Masuk Sekarang
                </button>

                <div class="text-center small">
                    Belum punya akun? <a href="{{ route('register') }}" class="link-gold">Daftar Jadi Reseller</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
