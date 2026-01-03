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
                    <img src="{{ asset('assets/img/logo-gunsas.png') }}" alt="Logo" width="80" class="mb-2">
                    <h5 class="fw-bold">PT. Gunsas Jaya Berkah</h5>
                    <p class="text-muted small">Mitra Resmi Reseller & Agen Durian</p>
                </div>

                <div class="accordion" id="accordionSyarat">
    
                    <div class="mb-3">
                        <h6 class="fw-bold text-dark"><i class="fas fa-user-check text-warning me-2"></i>1. Syarat Menjadi Mitra</h6>
                        <ul class="small text-secondary ps-4 mb-0" style="list-style-type: disc;">
                            <li>Wajib mengisi data diri dengan benar (KTP & No. WhatsApp aktif).</li>
                            <li><strong>Wajib memiliki Freezer/Kulkas</strong>. Produk kami adalah Durian Beku (Frozen) tanpa pengawet yang wajib disimpan di suhu -18°C. Kami tidak bertanggung jawab atas kerusakan akibat kelalaian penyimpanan.</li>
                            <li>Akun baru akan melalui proses verifikasi oleh Admin sebelum bisa digunakan.</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold text-dark"><i class="fas fa-box-open text-warning me-2"></i>2. Ketentuan Pemesanan (Order)</h6>
                        <ul class="small text-secondary ps-4 mb-0" style="list-style-type: disc;">
                            <li>Pemesanan dilakukan mandiri melalui website.</li>
                            <li><strong>Aturan Jumlah Order:</strong> Sesuai kebijakan grosir, pembelian <strong>wajib kelipatan 5 Box per item</strong> (Contoh: 5, 10, 15, dst).</li>
                            <li>Harga di website adalah harga final khusus Reseller.</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold text-dark"><i class="fas fa-money-bill-wave text-warning me-2"></i>3. Pembayaran</h6>
                        <ul class="small text-secondary ps-4 mb-0" style="list-style-type: disc;">
                            <li>Pembayaran <strong>Cashless (Non-Tunai)</strong> via Transfer Bank/E-Wallet. Staff toko tidak menerima uang tunai.</li>
                            <li>Pesanan diproses setelah lunas (Status: <em>Paid</em>). Batas pembayaran 1x24 jam sebelum expired.</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold text-dark"><i class="fas fa-store text-warning me-2"></i>4. Sistem Pickup & Cek Fisik</h6>
                        <ul class="small text-secondary ps-4 mb-0" style="list-style-type: disc;">
                            <li>Pengambilan barang dilakukan H+3 setelah pembayaran lunas di outlet yang dipilih.</li>
                            <li><strong>Cek Fisik Wajib:</strong> Saat pengambilan, Mitra/Kurir WAJIB mengecek kondisi barang (Pastikan beku & kemasan segel) bersama Staff Toko.</li>
                            <li>Jika barang sudah dibawa keluar dari outlet, maka kerusakan fisik (cair/lumer/penyok) menjadi tanggung jawab Mitra sepenuhnya.</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold text-dark"><i class="fas fa-sync-alt text-warning me-2"></i>5. Garansi Rasa (Retur)</h6>
                        <ul class="small text-secondary ps-4 mb-0" style="list-style-type: disc;">
                            <li>Kami memberikan garansi khusus <strong>Rasa Asam/Basi</strong> maksimal <strong>1x24 Jam</strong> setelah barang diambil.</li>
                            <li><strong>Syarat Klaim:</strong> Barang yang dikomplain TIDAK BOLEH DIBUANG/HABIS. Wajib disisakan minimal 80%, difoto, dan dikembalikan ke outlet untuk pengecekan tim Kitchen (QC).</li>
                            <li>Jika terbukti kesalahan produksi (Basi), kami ganti produk baru 100%. Jika kesalahan penyimpanan Mitra (Freezer kurang dingin/mati), klaim ditolak.</li>
                        </ul>
                    </div>
                </div>

                <div class="alert alert-warning small border-0 mt-4 mb-0">
                    <i class="fas fa-info-circle me-1"></i> Dengan menekan tombol <strong>"Saya Setuju"</strong>, Anda menyetujui prosedur pengecekan barang dan kebijakan garansi di atas.
                </div>

                
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
