@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4" style="max-width: 800px;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Lokasi Toko Baru</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.tokos.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Cabang / Toko</label>
                    <input type="text" name="nama_toko" class="form-control" required placeholder="Contoh: Gunsas Duren Pusat">
                </div>

                <div class="mb-3">
                    <label class="form-label">Kota / Wilayah</label>
                    <input type="text" name="kota" class="form-control" required placeholder="Contoh: Jakarta Selatan">
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea name="alamat_lengkap" class="form-control" rows="3" placeholder="Jalan, RT/RW, Patokan..."></textarea>
                    <small class="text-muted">Alamat ini akan muncul di invoice reseller sebagai lokasi pengambilan.</small>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-save me-1"></i> Simpan Toko
                </button>
                <a href="{{ route('admin.tokos.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
