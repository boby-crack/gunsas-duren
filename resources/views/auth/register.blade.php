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

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                    <label class="form-check-label small text-muted" for="terms">
                        Saya setuju dengan 
                        {{-- Link Pemicu Modal --}}
                        <a href="#" class="text-warning fw-bold text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalTerms">
                            Syarat & Ketentuan
                        </a> 
                        Mitra.
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

    <div class="modal fade" id="modalTerms" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content border-0 shadow">
            
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title fw-bold"><i class="fas fa-file-contract me-2"></i> Syarat & Ketentuan Mitra</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 text-secondary">
                <div class="text-center mb-4">
                    <img src="{{ asset('assets/img/logo-gunsas.png') }}" height="50" alt="Logo">
                    <p class="small text-muted mt-2">PT. Gunsas Jaya Berkah</p>
                </div>

                <h6 class="fw-bold text-dark">1. Pendahuluan</h6>
                <p class="small">Selamat datang di program kemitraan Gunsas Duren. Dengan mendaftar sebagai Reseller, Anda menyetujui seluruh syarat dan ketentuan yang berlaku.</p>

                <h6 class="fw-bold text-dark mt-3">2. Syarat Wajib</h6>
                <ul class="small mb-0">
                    <li>Wajib memiliki kartu identitas (KTP) yang sah.</li>
                    <li><strong>Wajib memiliki Freezer/Kulkas</strong> yang memadai untuk menjaga kualitas produk beku.</li>
                    <li>Bersedia memberikan data yang valid dan jujur saat verifikasi.</li>
                </ul>

                <h6 class="fw-bold text-dark mt-3">3. Pemesanan & Pembayaran</h6>
                <ul class="small mb-0">
                    <li>Minimal pembelian pertama (First Order) adalah <strong>5 Box</strong> (Varian boleh campur).</li>
                    <li>Pembayaran dilakukan via transfer bank resmi perusahaan.</li>
                    <li>Pesanan yang sudah dibayar tidak dapat dibatalkan.</li>
                </ul>

                <h6 class="fw-bold text-dark mt-3">4. Pengambilan Barang (Pickup)</h6>
                <p class="small">Sistem kami saat ini adalah <strong>Ambil Sendiri (Self Pickup)</strong> di cabang terdekat. Barang dapat diambil H+3 setelah pembayaran dikonfirmasi oleh Admin.</p>
                
                <h6 class="fw-bold text-dark mt-3">5. Kebijakan Retur</h6>
                <p class="small mb-0">Komplain kualitas (asam/basi) diterima maksimal 1x24 jam setelah barang diambil, wajib menyertakan bukti foto/video.</p>
            </div>

            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-warning text-white fw-bold rounded-pill px-4" onclick="document.getElementById('terms').checked = true; bootstrap.Modal.getInstance(document.getElementById('modalTerms')).hide();">
                    Saya Setuju & Lanjut
                </button>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</body> </html>

</body>
</html>
