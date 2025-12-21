<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapi Profil Mitra - Gunsas Duren</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
        .form-section { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        .btn-gold { background-color: #f6a600; color: white; border: none; font-weight: bold; }
        .btn-gold:hover { background-color: #d99000; color: white; }
        .btn-light-custom { background-color: #e9ecef; color: #6c757d; border: none; font-weight: 600; }
        .btn-light-custom:hover { background-color: #dee2e6; color: #495057; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center mb-4">
                <img src="{{ asset('assets/img/logo-gunsas.png') }}" height="60" class="mb-3">
                <h3>Satu Langkah Lagi!</h3>
                <p class="text-muted">Untuk menjaga kualitas produk, kami perlu memverifikasi fasilitas penyimpanan Anda.</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profile.complete.store') }}" method="POST" enctype="multipart/form-data" class="form-section">
                @csrf

                <h5 class="fw-bold text-warning mb-3">1. Identitas Diri</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">NIK (Sesuai KTP) <span class="text-danger">*</span></label>
                        <input type="number" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}" placeholder="Harus 16 digit" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nomor WhatsApp Aktif <span class="text-danger">*</span></label>
                        <input type="number" name="no_hp" class="form-control" value="{{ old('no_hp', auth()->user()->no_hp) }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat Lengkap (Domisili/Toko) <span class="text-danger">*</span></label>
                    <textarea name="alamat_lengkap" class="form-control" rows="2" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan..." required>{{ old('alamat_lengkap') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kota / Kabupaten <span class="text-danger">*</span></label>
                    <input type="text" name="kota_domisili" class="form-control" value="{{ old('kota_domisili') }}" required>
                </div>

                <hr class="my-4">

                <h5 class="fw-bold text-warning mb-3">2. Verifikasi Wajah & Identitas</h5>

                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Foto Profil (Close Up) <span class="text-danger">*</span></label>
                        <input type="file" name="foto_profil" class="form-control" accept="image/*" required>
                        <small class="text-muted">Wajah terlihat jelas, tanpa masker/kacamata hitam.</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Foto Selfie Memegang KTP <span class="text-danger">*</span></label>
                        <input type="file" name="foto_pegang_ktp" class="form-control" accept="image/*" required>
                        <small class="text-muted">Pegang KTP di samping wajah, pastikan tulisan terbaca.</small>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Foto KTP (Fisik) <span class="text-danger">*</span></label>
                        <input type="file" name="foto_ktp" class="form-control" accept="image/*" required>
                        <small class="text-muted">Foto KTP asli secara penuh & jelas.</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Foto Freezer <span class="text-danger">*</span></label>
                        <input type="file" name="foto_freezer" class="form-control" accept="image/*" required>
                        <small class="text-muted">Foto kondisi freezer tempat penyimpanan produk.</small>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="fw-bold text-warning mb-3">3. Data Tambahan</h5>

                <div class="mb-3">
                    <label class="form-label">Link Media Sosial <span class="text-muted">(Opsional)</span></label>
                    <input type="text" name="link_sosmed" class="form-control" placeholder="Contoh: https://instagram.com/duren_enak" value="{{ old('link_sosmed') }}">
                </div>

                <div class="alert alert-info d-flex align-items-center mt-4">
                    <i class="fas fa-info-circle me-3 fs-4"></i>
                    <div>
                        Dengan mengirim data ini, saya menyatakan bahwa saya memiliki fasilitas pendingin (Freezer) yang layak.
                    </div>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-gold py-2 rounded-pill">
                        <i class="fas fa-paper-plane me-2"></i> Kirim Data Verifikasi
                    </button>

                    <a href="{{ route('home') }}" class="btn btn-light-custom py-2 rounded-pill">
                        <i class="fas fa-arrow-left me-2"></i> Nanti Saja, Lihat Produk Dulu
                    </a>
                </div>

            </form>

            <div class="text-center mt-3">
                 <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link text-muted text-decoration-none small">
                        Bukan akun Anda? Logout
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

</body>
</html>
