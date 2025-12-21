@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4" style="max-width: 800px;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Produk Baru</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="nama_produk" class="form-control" required placeholder="Contoh: Pancake Durian Jumbo">
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga Khusus Mitra (Rp)</label>
                    <input type="number" name="harga_mitra" class="form-control" required placeholder="Contoh: 85000">
                    <small class="text-muted">Masukkan angka saja tanpa titik/koma.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto Produk</label>
                    <input type="file" name="gambar" class="form-control">
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-save me-1"></i> Simpan Produk
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
