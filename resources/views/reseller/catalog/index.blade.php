@extends('layouts.reseller')

@section('title', 'Katalog Produk')

@section('content')

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show fixed-alert shadow-lg" role="alert">
        <div class="d-flex align-items-center">
            <div class="fs-3 me-3 text-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <h6 class="alert-heading fw-bold mb-0">Berhasil!</h6>
                <small>{{ session('success') }}</small>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show fixed-alert shadow-lg" role="alert">
        <div class="d-flex align-items-center">
            <div class="fs-3 me-3 text-danger">
                <i class="fas fa-times-circle"></i>
            </div>
            <div>
                <h6 class="alert-heading fw-bold mb-0">Gagal!</h6>
                <small>{{ session('error') }}</small>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<style>
    /* CSS Khusus Alert Melayang */
    .fixed-alert {
        position: fixed;
        top: 100px; /* Muncul di bawah navbar */
        right: 20px;
        z-index: 9999; /* Pastikan di atas elemen lain */
        min-width: 300px;
        max-width: 400px;
        border-radius: 12px;
        border: none;
        background: white;
        border-left: 5px solid #198754; /* Garis hijau di kiri */
        animation: slideInRight 0.5s ease-out;
    }
    
    /* Animasi Masuk */
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
</style>
{{-- HEADER HALAMAN --}}
<div class="d-flex flex-column flex-md-row justify-content-between align-items-end mb-5">
    <div>
        <span class="text-uppercase fw-bold ls-1" style="color: var(--gunsas-gold);">Area Mitra</span>
        <h2 class="fw-bold mt-1 display-6 text-dark">Belanja Stok</h2>
        <p class="text-muted mb-0">Pilih produk berkualitas untuk pelanggan setia Anda.</p>
    </div>
    
    {{-- Filter Kategori (Opsional Visual) --}}
</div>

{{-- GRID PRODUK --}}
<div class="row g-4">
            @foreach($products as $product)
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                <div class="product-card h-100 d-flex flex-column bg-white rounded-4 overflow-hidden border">
                    
                    <div class="product-img-wrap position-relative bg-light" style="height: 240px; overflow: hidden;">
                   

                        @if($product->gambar)
                            <img src="{{ asset('storage/' . $product->gambar) }}" 
                                 class="w-100 h-100 object-fit-cover transition-img" 
                                 alt="{{ $product->nama_produk }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                <i class="fas fa-image fa-3x opacity-25"></i>
                            </div>
                        @endif
                    </div>

                    <div class="p-4 d-flex flex-column flex-grow-1">
                        <h5 class="fw-bold mb-2 text-dark">{{ $product->nama_produk }}</h5>
                        <p class="text-muted small mb-3 flex-grow-1" style="line-height: 1.5;">
                            {{ Str::limit($product->deskripsi, 60) }}
                        </p>

                        <div class="mb-3 pb-3 border-bottom">
                            <small class="text-muted d-block fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">HARGA MITRA</small>
                            <span class="fw-bold fs-4" style="color: var(--gunsas-green);">
                                Rp {{ number_format($product->harga_mitra, 0, ',', '.') }}
                            </span>
                            <small class="text-muted">/ box</small>
                        </div>

                        <div class="mt-auto">
                            @if(Auth::check() && Auth::user()->status_akun == 'active')
                                <form action="{{ route('add.to.cart', $product->id) }}" method="POST">
                                    @csrf
                                    
                                    <div class="d-flex align-items-center justify-content-between mb-3 bg-light rounded-pill px-1 py-1 border">
                                        <button type="button" class="btn btn-sm rounded-circle text-muted" style="width: 32px; height: 32px;" onclick="updateQty(this, -5)">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        
                                        <input type="number" name="quantity" class="form-control border-0 bg-transparent text-center fw-bold p-0" 
                                               value="5" min="5" style="width: 50px;" readonly>

                                        <button type="button" class="btn btn-sm rounded-circle text-dark" style="width: 32px; height: 32px; background: white; shadow-sm;" onclick="updateQty(this, 5)">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>

                                    <button type="submit" class="btn btn-dark w-100 rounded-pill fw-bold py-2 btn-hover-gold">
                                        <i class="fas fa-shopping-cart me-2"></i> Masukkan Keranjang
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-dark w-100 rounded-pill fw-bold py-2">
                                    Masuk untuk Memesan
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

{{-- CSS KHUSUS KATALOG (Agar Tampilan Konsisten dengan Landing Page) --}}
<style>
    /* Styling Kartu Produk */
    .product-card {
        background: white;
        border: 1px solid var(--border-soft);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        border-color: var(--gunsas-green);
    }

    /* Gambar Produk */
    .product-img-wrap {
        height: 220px;
        overflow: hidden;
        position: relative;
        background: #FAFAFA;
    }
    .product-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: 0.5s;
    }
    .product-card:hover .product-img {
        transform: scale(1.05);
    }

    /* Badge Stok */
    .badge-kategori {
        position: absolute; top: 15px; left: 15px;
        background: rgba(255, 255, 255, 0.95);
        color: var(--gunsas-dark);
        font-weight: 700; font-size: 0.75rem;
        padding: 6px 14px; border-radius: 30px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    /* Tombol Add to Cart Premium */
    .btn-add-cart {
        width: 100%;
        background-color: var(--gunsas-dark);
        color: var(--gunsas-gold);
        font-weight: 700;
        border: none;
        padding: 12px;
        border-radius: 12px;
        transition: 0.3s;
    }
    .btn-add-cart:hover {
        background-color: var(--gunsas-gold);
        color: var(--gunsas-dark);
        box-shadow: 0 5px 15px rgba(251, 192, 45, 0.3);
    }
</style>

{{-- SCRIPT UPDATE QUANTITY (Kelipatan 5) --}}
@section('scripts')
<script>
    function updateQty(btn, amount) {
        const form = btn.closest('form');
        const input = form.querySelector('input[name="quantity"]');
        let currentVal = parseInt(input.value);
        let newVal = currentVal + amount;
        
        // Minimal order 5 box
        if (newVal >= 5) {
            input.value = newVal;
        }
    }
</script>
@endsection

@endsection