@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <a href="{{ route('admin.tokos.index') }}" class="btn btn-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>

    <div class="card shadow border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Lokasi Toko: {{ $toko->nama_toko }}</h6>
        </div>
        <div class="card-body">

            {{-- MENAMPILKAN ERROR VALIDASI --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.tokos.update', $toko->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- PENTING: Untuk update data --}}

                {{-- Nama Cabang --}}
                <div class="mb-3">
                    <label class="form-label font-weight-bold">Nama Cabang / Toko</label>
                    <input type="text" name="nama_toko" class="form-control @error('nama_toko') is-invalid @enderror"
                           value="{{ old('nama_toko', $toko->nama_toko) }}" required>
                    @error('nama_toko')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Kota --}}
                <div class="mb-3">
                    <label class="form-label font-weight-bold">Kota / Wilayah</label>
                    <input type="text" name="kota" class="form-control @error('kota') is-invalid @enderror"
                           value="{{ old('kota', $toko->kota) }}" required>
                    @error('kota')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alamat Lengkap --}}
                <div class="mb-3">
                    <label class="form-label font-weight-bold">Alamat Lengkap</label>
                    <textarea name="alamat_lengkap" rows="3" class="form-control @error('alamat_lengkap') is-invalid @enderror" required>{{ old('alamat_lengkap', $toko->alamat_lengkap) }}</textarea>
                    <small class="text-muted">Alamat ini akan muncul di invoice reseller sebagai lokasi pengambilan.</small>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Link Maps (OPSIONAL) --}}
                <div class="mb-3">
                    <label class="form-label font-weight-bold">Link Google Maps (Opsional)</label>
                    <input type="url" name="link_maps" class="form-control @error('link_maps') is-invalid @enderror"
                           placeholder="https://maps.app.goo.gl/..."
                           value="{{ old('link_maps', $toko->link_maps) }}">
                    <small class="text-muted">Pastikan diawali dengan <b>http://</b> atau <b>https://</b>. Copy link dari tombol 'Share' di Google Maps.</small>
                    @error('link_maps')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Update Toko
                    </button>
                    <a href="{{ route('admin.tokos.index') }}" class="btn btn-secondary">Batal</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
