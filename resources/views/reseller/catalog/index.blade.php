@extends('layouts.reseller')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-info border-0 shadow-sm">
            <i class="fa-solid fa-bullhorn me-2"></i>
            Selamat datang Mitra! Silakan pilih produk untuk stok toko Anda.
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    @foreach($products as $product)
    <div class="col-md-3 mb-4">
        <div class="card card-product h-100 shadow-sm">
            <div style="height: 200px; overflow: hidden;" class="bg-light d-flex align-items-center justify-content-center">
                @if($product->gambar)
                    <img src="{{ asset('storage/' . $product->gambar) }}" class="card-img-top" style="object-fit: cover; height: 100%; width: 100%;">
                @else
                    <i class="fa-solid fa-image fa-3x text-secondary"></i>
                @endif
            </div>

            <div class="card-body d-flex flex-column">
                <h5 class="card-title text-dark fw-bold">{{ $product->nama_produk }}</h5>
                <p class="card-text text-muted small flex-grow-1">{{ Str::limit($product->deskripsi, 60) }}</p>

                <div class="mb-2">
                    <span class="badge bg-warning text-dark">Harga Mitra</span>
                    <h5 class="text-primary fw-bold mt-1">Rp {{ number_format($product->harga_mitra, 0, ',', '.') }}</h5>
                </div>

                <a href="{{ route('add.to.cart', $product->id) }}" class="btn btn-dark w-100 mt-auto">
                    <i class="fa-solid fa-plus me-1"></i> Tambah Stok
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
