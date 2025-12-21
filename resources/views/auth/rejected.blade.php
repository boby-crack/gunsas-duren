<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Ditolak - Gunsas Duren</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #fff5f5; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card-reject { max-width: 500px; width: 100%; border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(220, 53, 69, 0.1); overflow: hidden; }
        .header-reject { background-color: #dc3545; padding: 30px; text-align: center; color: white; }
    </style>
</head>
<body>

<div class="container p-3">
    <div class="card card-reject mx-auto bg-white">
        <div class="header-reject">
            <i class="fas fa-times-circle fa-4x mb-3"></i>
            <h4 class="fw-bold">Pengajuan Ditolak</h4>
            <p class="mb-0 opacity-75">Maaf, data Anda belum memenuhi syarat.</p>
        </div>
        <div class="card-body p-4 text-center">
            <h6 class="text-muted fw-bold text-start text-uppercase small ls-1">Pesan dari Admin:</h6>

            <div class="alert alert-danger text-start mt-2 border-0 bg-light-danger text-danger">
                <i class="fas fa-quote-left me-2 opacity-50"></i>
                {{ auth()->user()->alasan_penolakan ?? 'Data tidak valid.' }}
            </div>

            <p class="text-muted small mt-4">
                Silakan perbaiki data Anda sesuai catatan di atas dan ajukan kembali.
            </p>

            <div class="d-grid gap-2">
                {{-- Tombol untuk Reset Status jadi Pending & Redirect ke Form --}}
                <form action="{{ route('profile.complete.create') }}" method="GET">
                    {{-- Kita akali: Tombol ini mengarah ke form, nanti di Controller form kita reset statusnya --}}
                    <button type="submit" class="btn btn-dark w-100 py-2 rounded-pill fw-bold">
                        <i class="fas fa-edit me-2"></i> Perbaiki & Upload Ulang
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100 py-2 rounded-pill">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
