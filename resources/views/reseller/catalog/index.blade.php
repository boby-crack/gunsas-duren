@extends('layouts.reseller')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Pesan Error Validasi (Muncul jika ada yang mencoba hack input) --}}
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    @foreach($products as $product)
    <div class="col-md-3 mb-4">
        <div class="card card-product h-100 shadow-sm border-0">
            {{-- Bagian Gambar --}}
            <div style="height: 200px; overflow: hidden;" class="bg-light d-flex align-items-center justify-content-center position-relative">
                @if($product->gambar)
                    <img src="{{ asset('storage/' . $product->gambar) }}" class="card-img-top" style="object-fit: cover; height: 100%; width: 100%;">
                @else
                    <i class="fa-solid fa-image fa-3x text-secondary"></i>
                @endif
            </div>

            <div class="card-body d-flex flex-column p-4">
                <h5 class="card-title text-dark fw-bold mb-1">{{ $product->nama_produk }}</h5>
                <p class="card-text text-muted small flex-grow-1 mb-3">{{ Str::limit($product->deskripsi, 60) }}</p>

                <div class="mb-3">
                    <span class="badge bg-warning text-dark mb-1">Harga Mitra</span>
                    <h5 class="text-primary fw-bold">Rp {{ number_format($product->harga_mitra, 0, ',', '.') }}</h5>
                </div>

                {{-- FORM ADD TO CART DENGAN INPUT QTY --}}
                <form action="{{ route('add.to.cart', $product->id) }}" method="POST" class="mt-auto">
                    @csrf {{-- Token Keamanan Wajib --}}
                    
                    <div class="d-flex align-items-center justify-content-between mb-3 border rounded px-2 py-1">
                        {{-- Tombol Kurang --}}
                        <button type="button" class="btn btn-sm text-secondary" onclick="updateQty(this, -5)">
                            <i class="fas fa-minus"></i>
                        </button>
                        
                        {{-- Input Angka --}}
                        <input type="number" name="quantity" class="form-control border-0 text-center fw-bold bg-transparent" 
                            value="5" min="5" style="width: 50px;" readonly>
                            
                        {{-- Tombol Tambah --}}
                        <button type="button" class="btn btn-sm text-secondary" onclick="updateQty(this, 5)">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>

                    {{-- Tombol Submit Form --}}
                    <button type="submit" class="btn btn-dark w-100 rounded-pill fw-bold">
                        <i class="fa-solid fa-cart-plus me-1"></i> Tambah Stok
                    </button>
                </form>

            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- SCRIPT SEDERHANA UNTUK HANDLE TOMBOL +/- --}}
<script>
    function updateQty(btn, amount) {
        // Cari input di dalam form yang sama dengan tombol yang diklik
        const form = btn.closest('form');
        const input = form.querySelector('input[name="quantity"]');
        
        let currentVal = parseInt(input.value);
        let newVal = currentVal + amount;

        if (newVal >= 5) {
            input.value = newVal;
        }
    }
</script>
@endsection