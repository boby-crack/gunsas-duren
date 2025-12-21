@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4" style="max-width: 800px;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Lokasi Toko: {{ $toko->nama_toko }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.tokos.update', $toko->id) }}" method="POST">
                @csrf
                @method('PUT') <div class="mb-3">
                    <label class="form-label">Nama Cabang / Toko</label>
                    <input type="text" name="nama_toko"
                           value="{{ old('nama_toko', $toko->nama_toko) }}"
                           class="form-control" required placeholder="Contoh: Gunsas Duren Pusat">
                </div>

                <div class="mb-3">
                    <label class="form-label">Kota / Wilayah</label>
                    <input type="text" name="kota"
                           value="{{ old('kota', $toko->kota) }}"
                           class="form-control" required placeholder="Contoh: Jakarta Selatan">
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea name="alamat_lengkap" class="form-control" rows="3" placeholder="Jalan, RT/RW, Patokan...">{{ old('alamat_lengkap', $toko->alamat_lengkap) }}</textarea>
                    <small class="text-muted">Alamat ini akan muncul di invoice reseller sebagai lokasi pengambilan.</small>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save me-1"></i> Update Toko
                </button>

                <a href="{{ route('admin.tokos.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
