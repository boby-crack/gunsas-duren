@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">

    <h3 class="fw-bold mb-4"><i class="fas fa-users-cog me-2"></i> Manajemen Reseller</h3>

    {{-- Alert Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- NAVIGASI TABS --}}
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $pendingResellers->count() > 0 ? 'active' : '' }} position-relative" id="pills-pending-tab" data-bs-toggle="pill" data-bs-target="#pills-pending" type="button">
                <i class="fas fa-user-clock me-1"></i> Menunggu Verifikasi
                @if($pendingResellers->count() > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $pendingResellers->count() }}
                    </span>
                @endif
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $pendingResellers->count() == 0 ? 'active' : '' }}" id="pills-active-tab" data-bs-toggle="pill" data-bs-target="#pills-active" type="button">
                <i class="fas fa-user-check me-1"></i> Data Reseller Aktif
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link text-danger" id="pills-rejected-tab" data-bs-toggle="pill" data-bs-target="#pills-rejected" type="button">
                <i class="fas fa-ban me-1"></i> Ditolak / Revisi
            </button>
        </li>
    </ul>

    {{-- ISI KONTEN TABS --}}
    <div class="tab-content" id="pills-tabContent">

        {{-- TAB 1: MENUNGGU VERIFIKASI --}}
        <div class="tab-pane fade {{ $pendingResellers->count() > 0 ? 'show active' : '' }}" id="pills-pending">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold text-warning mb-3">Permintaan Reseller Baru</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal Daftar</th>
                                    <th>Nama</th>
                                    <th>Kota</th>
                                    <th>Detail</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendingResellers as $user)
                                <tr>
                                    <td>{{ $user->updated_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $user->name }}</div>
                                        <small class="text-muted">{{ $user->email }} | {{ $user->no_hp }}</small>
                                    </td>
                                    <td>{{ $user->kota_domisili }}</td>
                                    <td>
                                        {{-- TOMBOL CEK DETAIL (SUDAH DIUBAH) --}}
                                        <button type="button" class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#modalVerif{{ $user->id }}">
                                            <i class="fas fa-eye me-1"></i> Cek Detail
                                        </button>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <form action="{{ route('admin.resellers.verify', $user->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="action" value="approve">
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Terima user ini?')">
                                                    <i class="fas fa-check"></i> Terima
                                                </button>
                                            </form>

                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalReject{{ $user->id }}">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Tidak ada permintaan verifikasi baru.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- LOOPING MODAL (DITARUH DI LUAR TABEL AGAR TIDAK BOCOR) --}}
            @foreach($pendingResellers as $user)
            
                <div class="modal fade" id="modalVerif{{ $user->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content border-0 rounded-4 overflow-hidden">
                            
                            <div class="modal-header bg-white border-bottom px-4 py-3">
                                <h5 class="modal-title fw-bold">
                                    <i class="fas fa-file-invoice me-2 text-warning"></i> Verifikasi Data Mitra
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body bg-light p-4">
                                
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-body p-4">
                                        <div class="row">
                                            <div class="col-md-6 border-end">
                                                <h6 class="fw-bold text-secondary mb-3"><i class="fas fa-user me-2"></i> Identitas Diri</h6>
                                                <table class="table table-borderless table-sm mb-0">
                                                    <tr>
                                                        <td class="text-muted" width="130">Nama Lengkap</td>
                                                        <td class="fw-bold text-dark">: {{ $user->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">NIK KTP</td>
                                                        <td class="fw-bold text-dark font-monospace">: {{ $user->nik }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Email</td>
                                                        <td>: {{ $user->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">No. WhatsApp</td>
                                                        <td>: <a href="https://wa.me/{{ $user->no_hp }}" target="_blank" class="text-decoration-none text-success fw-bold">{{ $user->no_hp }} <i class="fab fa-whatsapp"></i></a></td>
                                                    </tr>
                                                </table>
                                            </div>

                                            <div class="col-md-6 ps-md-4">
                                                <h6 class="fw-bold text-secondary mb-3"><i class="fas fa-map-marker-alt me-2"></i> Lokasi & Toko</h6>
                                                <table class="table table-borderless table-sm mb-0">
                                                    <tr>
                                                        <td class="text-muted" width="130">Kota Domisili</td>
                                                        <td class="fw-bold text-dark">: {{ $user->kota_domisili }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Alamat Lengkap</td>
                                                        <td>: {{ $user->alamat_lengkap }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Sosial Media</td>
                                                        <td>: 
                                                            @if($user->link_sosmed)
                                                                <a href="{{ $user->link_sosmed }}" target="_blank" class="text-primary text-decoration-none">Klik Link <i class="fas fa-external-link-alt small"></i></a>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h6 class="fw-bold text-secondary mb-3 ms-1">Bukti Foto Lampiran</h6>
                                <div class="row g-3">
                                    
                                    <div class="col-md-3 col-sm-6">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <div class="card-header bg-white border-0 text-center py-2 small fw-bold text-muted">Foto Profil</div>
                                            <div class="card-body p-1 bg-white d-flex align-items-center justify-content-center">
                                                <div class="ratio ratio-3x4 rounded overflow-hidden border">
                                                    <a href="{{ asset('storage/' . $user->foto_profil) }}" target="_blank">
                                                        <img src="{{ asset('storage/' . $user->foto_profil) }}" class="img-fluid w-100 h-100 object-fit-cover hover-zoom">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-sm-6">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <div class="card-header bg-white border-0 text-center py-2 small fw-bold text-muted">Selfie KTP</div>
                                            <div class="card-body p-1 bg-white d-flex align-items-center justify-content-center">
                                                <div class="ratio ratio-3x4 rounded overflow-hidden border">
                                                    <a href="{{ asset('storage/' . $user->foto_pegang_ktp) }}" target="_blank">
                                                        <img src="{{ asset('storage/' . $user->foto_pegang_ktp) }}" class="img-fluid w-100 h-100 object-fit-cover hover-zoom">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-sm-6">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <div class="card-header bg-white border-0 text-center py-2 small fw-bold text-muted">KTP Asli</div>
                                            <div class="card-body p-1 bg-white d-flex align-items-center justify-content-center">
                                                <div class="ratio ratio-4x3 rounded overflow-hidden border">
                                                    <a href="{{ asset('storage/' . $user->foto_ktp) }}" target="_blank">
                                                        <img src="{{ asset('storage/' . $user->foto_ktp) }}" class="img-fluid w-100 h-100 object-fit-cover hover-zoom">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-sm-6">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <div class="card-header bg-white border-0 text-center py-2 small fw-bold text-muted">Kondisi Freezer</div>
                                            <div class="card-body p-1 bg-white d-flex align-items-center justify-content-center">
                                                <div class="ratio ratio-3x4 rounded overflow-hidden border">
                                                    <a href="{{ asset('storage/' . $user->foto_freezer) }}" target="_blank">
                                                        <img src="{{ asset('storage/' . $user->foto_freezer) }}" class="img-fluid w-100 h-100 object-fit-cover hover-zoom">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="modal-footer bg-white border-top p-3 justify-content-center">
                                <button type="button" class="btn btn-light px-5 rounded-pill fw-bold" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalReject{{ $user->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title fw-bold">Tolak Pengajuan Reseller</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('admin.resellers.verify', $user->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="action" value="reject">
                                <div class="modal-body">
                                    <p class="fw-bold">Mengapa Anda menolak {{ $user->name }}?</p>
                                    <div class="form-group">
                                        <textarea name="alasan" class="form-control" rows="4" placeholder="Contoh: Foto KTP buram..." required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer bg-light">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger">Kirim Penolakan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
            {{-- END LOOPING MODAL --}}

        </div>

        {{-- TAB 2: RESELLER AKTIF --}}
        <div class="tab-pane fade {{ $pendingResellers->count() == 0 ? 'show active' : '' }}" id="pills-active">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold text-success mb-3">Daftar Mitra Aktif</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Mitra</th>
                                    <th>Kontak</th>
                                    <th>Domisili</th>
                                    <th>Total Order</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activeResellers as $user)
                                <tr>
                                    <td class="fw-bold">{{ $user->name }}</td>
                                    <td>{{ $user->no_hp }}</td>
                                    <td>{{ $user->kota_domisili }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $user->orders ? $user->orders->count() : 0 }} Order</span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.resellers.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus reseller ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i> Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB 3: DITOLAK / REVISI --}}
        <div class="tab-pane fade" id="pills-rejected">
            <div class="card shadow-sm border-start border-danger border-0">
                <div class="card-body">
                    <h5 class="fw-bold text-danger mb-3">Riwayat Penolakan</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal Ditolak</th>
                                    <th>Nama Reseller</th>
                                    <th>Alasan Penolakan</th>
                                    <th>Status User</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rejectedResellers as $user)
                                <tr>
                                    <td>{{ $user->updated_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $user->name }}</div>
                                        <small class="text-muted">{{ $user->email }}</small>
                                    </td>
                                    <td>
                                        <span class="text-danger fst-italic">"{{ Str::limit($user->alasan_penolakan, 50) }}"</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger">Perlu Revisi</span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.resellers.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus permanen data user ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-secondary" title="Hapus User">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada data reseller yang ditolak.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    /* CSS Tambahan Khusus Foto */
    .object-fit-cover {
        object-fit: cover;
    }
    .hover-zoom {
        transition: transform 0.3s ease;
    }
    .hover-zoom:hover {
        transform: scale(1.1); /* Efek Zoom Halus */
    }
    .ratio-3x4 {
        --bs-aspect-ratio: 133.33%; /* Rasio Potrait */
    }
</style>
@endsection