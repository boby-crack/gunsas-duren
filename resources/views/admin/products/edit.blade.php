@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4" style="max-width: 800px;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Produk: {{ $product->nama_produk }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <div class="mb-3">
                    <label>Nama Produk</label>
                    <input type="text" name="nama_produk" class="form-control" value="{{ $product->nama_produk }}" required>
                </div>

                <div class="mb-3">
                    <label>Harga Mitra (Rp)</label>
                    <input type="number" name="harga_mitra" class="form-control" value="{{ $product->harga_mitra }}" required>
                </div>

                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3">{{ $product->deskripsi }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Ganti Gambar (Kosongkan jika tidak ingin ganti)</label>
                    <input type="file" name="gambar" class="form-control">
                    @if($product->gambar)
                        <img src="{{ asset('storage/' . $product->gambar) }}" width="100" class="mt-2 rounded">
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Update Produk</button>
            </form>
        </div>
    </div>
</div>
@endsection
