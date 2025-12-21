<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Verifikasi - Gunsas Duren</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fffdf5;
            min-height: 100vh; /* Ganti height jadi min-height agar aman di HP */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .status-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.05);
            max-width: 500px;
            width: 100%;
            text-align: center;
            border-top: 5px solid #f6a600;
        }
        .icon-box {
            width: 100px;
            height: 100px;
            background-color: #fff3cd;
            color: #f6a600;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 3rem;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(246, 166, 0, 0.4); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 15px rgba(246, 166, 0, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(246, 166, 0, 0); }
        }
        .btn-outline-gold {
            color: #f6a600;
            border: 2px solid #f6a600;
            font-weight: 600;
            border-radius: 50px;
        }
        .btn-outline-gold:hover {
            background-color: #f6a600;
            color: white;
        }
        /* Style untuk tombol home */
        .btn-home {
            background-color: #f8f9fa;
            color: #6c757d;
            border: 1px solid #dee2e6;
            font-weight: 500;
            border-radius: 50px;
        }
        .btn-home:hover {
            background-color: #e9ecef;
            color: #495057;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="status-card mx-auto">
        <div class="icon-box">
            <i class="fas fa-user-clock"></i>
        </div>

        <h3 class="fw-bold mb-3">Data Sedang Diverifikasi</h3>

        <p class="text-muted mb-4">
            Terima kasih <strong>{{ auth()->user()->name }}</strong>. Kami telah menerima data pengajuan Anda. <br>
            Tim Admin kami sedang memeriksa validitas dokumen (KTP & Freezer) yang Anda kirimkan.
        </p>

        <div class="alert alert-warning d-flex align-items-center text-start small mb-4">
            <i class="fas fa-info-circle me-3 fs-4"></i>
            <div>
                Proses verifikasi biasanya memakan waktu <strong>1x24 Jam</strong> di hari kerja. Notifikasi akan dikirimkan via WhatsApp jika akun sudah aktif.
            </div>
        </div>

        <div class="d-grid gap-2">
            <a href="{{ route('orders.index') }}" class="btn btn-warning text-white fw-bold rounded-pill">
                <i class="fas fa-sync-alt me-2"></i> Cek Status Sekarang
            </a>

            <a href="https://wa.me/6282194229108?text=Halo%20Admin,%20saya%20sudah%20upload%20data%20reseller%20atas%20nama%20{{ auth()->user()->name }}.%20Mohon%20segera%20diverifikasi."
               target="_blank" class="btn btn-outline-gold rounded-pill mt-1">
                <i class="fab fa-whatsapp me-2"></i> Hubungi Admin
            </a>

            <a href="{{ route('home') }}" class="btn btn-home rounded-pill mt-1">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
            </a>

            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="btn btn-link text-muted text-decoration-none small">
                    Keluar / Logout
                </button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
