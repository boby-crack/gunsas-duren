@extends('layouts.reseller')

@section('title', 'Checkout - Gunsas Duren')

@section('content')
<style>
    .checkout-card { background: white; border-radius: 25px; border: 1px solid #ECEFF1; overflow: hidden; }
    .section-title { font-weight: 800; color: #1B1B1B; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
    .section-title i { color: #FBC02D; }
    
    /* Summary Sidebar */
    .summary-sticky { position: sticky; top: 120px; }
    .item-list { max-height: 300px; overflow-y: auto; padding-right: 5px; }
    .item-list::-webkit-scrollbar { width: 4px; }
    .item-list::-webkit-scrollbar-thumb { background: #eee; border-radius: 10px; }
    
    .checkout-input { padding: 12px 18px; border-radius: 12px; border: 2px solid #F5F5F5; background: #FAFAFA; font-weight: 600; transition: 0.3s; }
    .checkout-input:focus { border-color: #FBC02D; background: white; outline: none; box-shadow: none; }
    
    .btn-pay { background: #388E3C; color: white; border: none; width: 100%; padding: 16px; border-radius: 50px; font-weight: 700; transition: 0.3s; box-shadow: 0 10px 20px rgba(56, 142, 60, 0.2); }
    .btn-pay:hover { background: #2E7D32; color: white; transform: translateY(-3px); }
    
    .info-preorder { background: #FFF9C4; border-radius: 15px; padding: 15px; border-left: 5px solid #FBC02D; }
</style>

<div class="container">
    {{-- Header --}}
    <div class="mb-5">
        <span class="text-uppercase fw-bold text-warning ls-1 small">Langkah Terakhir</span>
        <h2 class="fw-bold m-0 text-dark">Checkout Pesanan</h2>
    </div>

    <div class="row g-4">
        {{-- KIRI: FORM INPUT --}}
        <div class="col-lg-7">
            <div class="checkout-card shadow-sm p-4 p-md-5">
                
                @if ($errors->any())
                    <div class="alert alert-danger border-0 rounded-4 mb-4">
                        <ul class="mb-0 small fw-bold">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf

                    {{-- Lokasi Pengambilan --}}
                    <div class="mb-4">
                        <label class="section-title h5"><i class="fas fa-store"></i> Lokasi Pengambilan</label>
                        <select name="toko_id" class="form-select checkout-input" required>
                            <option value="">-- Pilih Cabang Gunsas --</option>
                            @foreach($tokos as $toko)
                                <option value="{{ $toko->id }}" {{ old('toko_id') == $toko->id ? 'selected' : '' }}>
                                    {{ $toko->nama_toko }} - {{ $toko->kota }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted d-block mt-2">Silakan pilih outlet terdekat dari lokasi Anda.</small>
                    </div>

                    {{-- Tanggal Ambil --}}
                    <div class="mb-4">
                        <label class="section-title h5"><i class="fas fa-calendar-alt"></i> Jadwal Pengambilan</label>
                        <input type="date" name="tgl_ambil" class="form-control checkout-input" 
                               min="{{ $minDate }}" value="{{ old('tgl_ambil', $minDate) }}" required>
                        
                        <div class="info-preorder mt-3">
                            <div class="d-flex gap-3 align-items-start">
                                <i class="fas fa-info-circle mt-1"></i>
                                <p class="mb-0 small fw-bold text-dark">
                                    Sesuai aturan Pre-Order, pengambilan minimal H+3.<br>
                                    Tersedia paling cepat pada: <span class="text-success">{{ \Carbon\Carbon::parse($minDate)->format('d M Y') }}</span>.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Informasi Pemesan --}}
                    <div class="mb-5">
                        <label class="section-title h5"><i class="fas fa-user"></i> Data Pemesan</label>
                        <div class="p-3 border rounded-4 bg-light">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="rounded-circle bg-white border d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-user-check text-warning"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <p class="mb-0 small text-muted fw-bold">NAMA MITRA</p>
                                    <h6 class="mb-0 fw-bold text-dark">{{ Auth::user()->name }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-pay">
                        <i class="fas fa-lock me-2"></i> Buat Pesanan & Bayar Sekarang
                    </button>
                </form>
            </div>
        </div>

        {{-- KANAN: RINGKASAN ITEM --}}
        <div class="col-lg-5">
            <div class="summary-sticky">
                <div class="checkout-card shadow-sm p-4">
                    <h5 class="fw-bold text-dark mb-4 pb-2 border-bottom">Ringkasan Item</h5>
                    
                    <div class="item-list mb-4">
                        @php $total = 0; @endphp
                        @foreach(session('cart') as $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-light rounded-3 border d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; flex-shrink: 0;">
                                    @if(isset($details['image']) && $details['image'])
                                        <img src="{{ asset('storage/'.$details['image']) }}" class="img-fluid rounded" style="max-height: 100%;">
                                    @else
                                        <i class="fas fa-box text-muted"></i>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold text-dark small">{{ $details['name'] }}</h6>
                                    <small class="text-muted fw-bold">{{ $details['quantity'] }} Box x Rp {{ number_format($details['price'], 0, ',', '.') }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="fw-bold text-dark small">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="p-3 rounded-4" style="background: #F8F9FA;">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small fw-bold">Subtotal</span>
                            <span class="text-dark fw-bold small">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted small fw-bold">Biaya Admin</span>
                            <span class="text-success small fw-bold">FREE</span>
                        </div>
                        <hr class="my-2 border-secondary opacity-25">
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="fw-bold text-dark">Total Bayar</span>
                            <span class="fw-bold text-success fs-4">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <p class="text-center text-muted small mt-4 mb-0">
                        <i class="fas fa-shield-alt me-1 text-success"></i> Pembayaran Aman via Midtrans / Bank Transfer
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection