@extends('layouts.reseller')

@section('content')
<div class="container pb-5">

    {{-- Header Judul Halaman --}}
    <div class="text-center mb-5">
        <span class="badge-reseller mb-2">Area Reseller</span>
        <h2 class="fw-bold">Belanja Stok Toko</h2>
        <p class="text-muted">Pilih produk berkualitas untuk pelanggan setia Anda</p>
    </div>

    {{-- Pesan Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Grid Produk --}}
    <div class="row g-4">
        @foreach($products as $product)
        <div class="col-md-4 col-lg-3">
            <div class="product-card h-100">

                {{-- Gambar --}}
                <div style="height: 220px; overflow: hidden; background: #f8f9fa;" class="d-flex align-items-center justify-content-center">
                    @if($product->gambar)
                        <img src="{{ asset('storage/' . $product->gambar) }}" class="product-img" alt="{{ $product->nama_produk }}">
                    @else
                        <i class="fas fa-image fa-3x text-muted"></i>
                    @endif
                </div>

                <div class="card-body p-4">
                    <h5 class="fw-bold mb-2">{{ $product->nama_produk }}</h5>
                    <p class="text-muted small mb-3">{{ Str::limit($product->deskripsi, 50) }}</p>

                    <h5 class="text-warning fw-bold mb-3">Rp {{ number_format($product->harga_mitra, 0, ',', '.') }}</h5>

                    {{-- FORM BELI (Minimal 5) --}}
                   {{-- FORM BELANJA (Alur E-Commerce) --}}
                            <form action="{{ route('add.to.cart', $product->id) }}" method="POST">
                                @csrf

                                {{-- Input Jumlah (Tetap Min. 5 sesuai aturan bisnis, tapi tampilan belanja) --}}
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="small text-muted fw-bold">Jumlah Box:</span>
                                    <div class="d-flex align-items-center border rounded px-2 py-1 bg-light">
                                        <button type="button" class="btn btn-sm text-secondary p-0" onclick="updateQty(this, -5)">
                                            <i class="fas fa-minus small"></i>
                                        </button>
                                        <input type="number" name="quantity" class="form-control border-0 text-center fw-bold bg-transparent p-0 mx-1"
                                            value="5" min="5" style="width: 40px; font-size: 1rem;" readonly>
                                        <button type="button" class="btn btn-sm text-secondary p-0" onclick="updateQty(this, 5)">
                                            <i class="fas fa-plus small"></i>
                                        </button>
                                    </div>
                                </div>

                                {{-- Tombol "Tambah ke Keranjang" (Shopping Style) --}}
                                <button type="submit" class="btn btn-primary-custom w-100 rounded-pill shadow-sm">
                                    <i class="fas fa-cart-plus me-2"></i> Tambah ke Keranjang
                                </button>
                            </form>

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
