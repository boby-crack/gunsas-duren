<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun - Gunsas Duren</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #fffdf5; }

        /* Navbar */
        .navbar { background-color: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }

        /* Card & Tabs */
        .card-profile {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            background: white;
            margin-bottom: 20px;
            overflow: hidden;
        }
        .nav-pills .nav-link.active {
            background-color: #f6a600;
        }
        .nav-pills .nav-link {
            color: #333;
            font-weight: 600;
        }

        /* Foto Profil Bulat */
        .profile-img-circle {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #fff3cd;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        /* Thumbnail Dokumen */
        .doc-thumb {
            height: 150px;
            width: 100%;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #ddd;
            transition: 0.3s;
        }
        .doc-thumb:hover { transform: scale(1.02); cursor: zoom-in; }

        /* Buttons */
        .btn-gold { background-color: #f6a600; color: white; border: none; font-weight: 600; padding: 10px 30px; border-radius: 50px; }
        .btn-gold:hover { background-color: #d99000; color: white; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}" style="color: #f6a600; font-size: 1.5rem;">
                <img src="{{ asset('assets/img/logo-gunsas.png') }}" alt="Gunsas Duren" height="50"> Gunsas Duren
            </a>
            <div class="ms-auto">
                <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill btn-sm">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 100px; margin-bottom: 50px;">
        <div class="row">

            <div class="col-md-4 mb-4">
                <div class="card-profile text-center p-4">
                    <div class="mb-3">
                        @if($user->foto_profil)
                            <img src="{{ asset('storage/' . $user->foto_profil) }}" class="profile-img-circle" alt="Foto Profil">
                        @else
                            {{-- Fallback jika belum ada foto (misal Admin) --}}
                            <div class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center mx-auto profile-img-circle" style="font-size: 3rem;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                    <p class="text-muted small mb-3">{{ $user->email }}</p>

                    @if($user->role == 'reseller')
                        @if($user->status_akun == 'active')
                            <div class="badge bg-success rounded-pill px-3 py-2 mb-3"><i class="fas fa-check-circle me-1"></i> Reseller Resmi</div>
                        @elseif($user->status_akun == 'waiting_approval')
                            <div class="badge bg-warning text-dark rounded-pill px-3 py-2 mb-3"><i class="fas fa-clock me-1"></i> Menunggu Verifikasi</div>
                        @else
                            <div class="badge bg-secondary rounded-pill px-3 py-2 mb-3">Belum Aktif</div>
                        @endif

                        <div class="border-top pt-3 text-start small">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">NIK:</span>
                                <span class="fw-bold">{{ $user->nik ?? '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">No HP:</span>
                                <span class="fw-bold">{{ $user->no_hp ?? '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Kota:</span>
                                <span class="fw-bold">{{ $user->kota_domisili ?? '-' }}</span>
                            </div>
                        </div>
                    @else
                        <span class="badge bg-primary rounded-pill px-3">{{ ucfirst($user->role) }}</span>
                    @endif
                </div>
            </div>

            <div class="col-md-8">
                <div class="card-profile p-4">

                    <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active rounded-pill px-4" id="pills-edit-tab" data-bs-toggle="pill" data-bs-target="#pills-edit" type="button">
                                <i class="fas fa-user-edit me-2"></i> Edit Data
                            </button>
                        </li>

                        {{-- Tab Dokumen hanya untuk Reseller --}}
                        @if($user->role == 'reseller')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill px-4" id="pills-docs-tab" data-bs-toggle="pill" data-bs-target="#pills-docs" type="button">
                                <i class="fas fa-file-contract me-2"></i> Bukti Verifikasi
                            </button>
                        </li>
                        @endif

                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill px-4" id="pills-pass-tab" data-bs-toggle="pill" data-bs-target="#pills-pass" type="button">
                                <i class="fas fa-key me-2"></i> Ganti Password
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">

                        <div class="tab-pane fade show active" id="pills-edit">
                            @if (session('status') === 'profile-updated')
                                <div class="alert alert-success alert-dismissible fade show">
                                    Profil berhasil diperbarui. <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form method="post" action="{{ route('profile.update') }}">
                                @csrf
                                @method('patch')
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                                </div>
                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-gold">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>

                        @if($user->role == 'reseller')
                        <div class="tab-pane fade" id="pills-docs">
                            <div class="alert alert-info small">
                                <i class="fas fa-info-circle me-2"></i> Dokumen ini adalah bukti yang Anda kirimkan saat pendaftaran. Hubungi Admin jika ingin mengubahnya.
                            </div>
                            <div class="row text-center">
                                <div class="col-md-4 mb-3">
                                    <p class="fw-bold small mb-1">Selfie dengan KTP</p>
                                    @if($user->foto_pegang_ktp)
                                        <img src="{{ asset('storage/' . $user->foto_pegang_ktp) }}" class="doc-thumb" alt="Selfie">
                                    @else
                                        <div class="bg-light doc-thumb d-flex align-items-center justify-content-center text-muted">Belum Upload</div>
                                    @endif
                                </div>
                                <div class="col-md-4 mb-3">
                                    <p class="fw-bold small mb-1">KTP Fisik</p>
                                    @if($user->foto_ktp)
                                        <img src="{{ asset('storage/' . $user->foto_ktp) }}" class="doc-thumb" alt="KTP">
                                    @else
                                        <div class="bg-light doc-thumb d-flex align-items-center justify-content-center text-muted">Belum Upload</div>
                                    @endif
                                </div>
                                <div class="col-md-4 mb-3">
                                    <p class="fw-bold small mb-1">Kondisi Freezer</p>
                                    @if($user->foto_freezer)
                                        <img src="{{ asset('storage/' . $user->foto_freezer) }}" class="doc-thumb" alt="Freezer">
                                    @else
                                        <div class="bg-light doc-thumb d-flex align-items-center justify-content-center text-muted">Belum Upload</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="tab-pane fade" id="pills-pass">
                            @if (session('status') === 'password-updated')
                                <div class="alert alert-success alert-dismissible fade show">
                                    Password berhasil diubah. <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form method="post" action="{{ route('password.update') }}">
                                @csrf
                                @method('put')
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Password Lama</label>
                                    <input type="password" name="current_password" class="form-control" required>
                                    @error('current_password', 'updatePassword') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Password Baru</label>
                                    <input type="password" name="password" class="form-control" required>
                                    @error('password', 'updatePassword') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>
                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-dark rounded-pill px-4">Update Password</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
