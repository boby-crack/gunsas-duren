@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <a href="{{ route('admin.tokos.index') }}" class="btn btn-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>

    <div class="card shadow border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Lokasi Toko Baru</h6>
        </div>
        <div class="card-body">

            {{-- MENAMPILKAN ERROR VALIDASI (WAJIB ADA) --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.tokos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nama Cabang --}}
                <div class="mb-3">
                    <label class="form-label font-weight-bold">Nama Cabang / Toko</label>
                    <input type="text" name="nama_toko" class="form-control @error('nama_toko') is-invalid @enderror"
                           placeholder="Contoh: Gunsas Duren Pusat"  required>
                    @error('nama_toko')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Kota --}}
                <div class="mb-3">
                    <label class="form-label font-weight-bold">Kota / Wilayah</label>
                    <input type="text" name="kota" class="form-control @error('kota') is-invalid @enderror"
                           placeholder="Contoh: Jakarta Selatan"  required>
                    @error('kota')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alamat Lengkap --}}
                <div class="mb-3">
                    <label class="form-label font-weight-bold">Alamat Lengkap</label>
                    <textarea name="alamat_lengkap" rows="3" class="form-control @error('alamat_lengkap') is-invalid @enderror"
                              placeholder="Jalan, RT/RW, Patokan..." required></textarea>
                    <small class="text-muted">Alamat ini akan muncul di invoice reseller sebagai lokasi pengambilan.</small>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Link Maps --}}
                <div class="mb-3">
                    <label class="form-label font-weight-bold">Link Google Maps (Opsional)</label>
                    <input type="url" name="link_maps" class="form-control @error('link_maps') is-invalid @enderror"
                           placeholder="https://maps.app.goo.gl/...">
                    <small class="text-muted">Copy link dari tombol 'Share' di Google Maps agar akurat.</small>
                    @error('link_maps')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Foto Outlet</label>
                    <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                    <small class="text-muted">Format: JPG, PNG. Maksimal 2MB.</small>
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Simpan Toko
                    </button>
                    <a href="{{ route('admin.tokos.index') }}" class="btn btn-secondary">Batal</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
