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
                                    <th>Bukti</th>
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
                                        <button type="button" class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#modalVerif{{ $user->id }}">
                                            <i class="fas fa-eye me-1"></i> Cek Foto
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

                                <div class="modal fade" id="modalVerif{{ $user->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold">Verifikasi: {{ $user->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row text-center">
                                                    <div class="col-md-3 mb-3">
                                                        <h6 class="fw-bold">Foto Profil</h6>
                                                        <img src="{{ asset('storage/' . $user->foto_profil) }}" class="img-fluid rounded border" style="max-height: 200px;">
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <h6 class="fw-bold text-primary">Selfie KTP</h6>
                                                        <img src="{{ asset('storage/' . $user->foto_pegang_ktp) }}" class="img-fluid rounded border" style="max-height: 200px;">
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <h6 class="fw-bold">KTP Asli</h6>
                                                        <img src="{{ asset('storage/' . $user->foto_ktp) }}" class="img-fluid rounded border" style="max-height: 200px;">
                                                        <small class="d-block mt-1">NIK: {{ $user->nik }}</small>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <h6 class="fw-bold text-success">Freezer</h6>
                                                        <img src="{{ asset('storage/' . $user->foto_freezer) }}" class="img-fluid rounded border" style="max-height: 200px;">
                                                        <small class="d-block mt-1">{{ $user->alamat_lengkap }}</small>
                                                    </div>
                                                </div>
                                                @if($user->link_sosmed)
                                                    <div class="alert alert-info py-2 text-center mt-3">
                                                        <i class="fab fa-instagram me-2"></i> Sosmed: <a href="{{ $user->link_sosmed }}" target="_blank" class="fw-bold">{{ $user->link_sosmed }}</a>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
        </div>

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

        <div class="tab-pane fade" id="pills-rejected">
            <div class="card  shadow-sm border-start border-danger border-0">
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
@endsection
