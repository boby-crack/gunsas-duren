@extends('layouts.reseller')

@section('title', 'Riwayat Pesanan - Gunsas Duren')

@section('content')
<style>
    .order-card { background: white; border-radius: 20px; border: 1px solid #ECEFF1; transition: 0.3s; overflow: hidden; }
    .order-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    
    .status-badge { font-weight: 700; font-size: 0.75rem; padding: 6px 16px; border-radius: 50px; text-transform: uppercase; letter-spacing: 0.5px; }
    .bg-waiting { background-color: #FFF9C4; color: #F57F17; } /* Menunggu Bayar */
    .bg-paid { background-color: #E8F5E9; color: #2E7D32; }    /* Sudah Bayar */
    .bg-ready { background-color: #E1F5FE; color: #0288D1; }   /* Siap Diambil */
    .bg-done { background-color: #F5F5F5; color: #616161; }    /* Selesai */
    
    .store-icon { width: 50px; height: 50px; background-color: #FAFAFA; color: #FBC02D; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; border: 1px solid #eee; }
    
    .btn-detail-custom { border: 2px solid #ECEFF1; color: #546E7A; border-radius: 50px; padding: 6px 20px; font-weight: 700; font-size: 0.85rem; transition: 0.3s; text-decoration: none; }
    .btn-detail-custom:hover { background: #1B1B1B; color: #FBC02D; border-color: #1B1B1B; }
    
    .btn-pay-now { background: #388E3C; color: white; border: none; border-radius: 50px; padding: 8px 20px; font-weight: 700; font-size: 0.85rem; transition: 0.3s; text-decoration: none; box-shadow: 0 4px 12px rgba(56, 142, 60, 0.2); }
    .btn-pay-now:hover { background: #2E7D32; color: white; transform: scale(1.05); }

    /* Garis vertikal pemisah desktop */
    @media (min-width: 768px) {
        .border-divider { border-left: 1px dashed #ECEFF1; padding-left: 30px; }
    }
</style>

<div class="container">
    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
        <div>
            <span class="text-uppercase fw-bold text-warning ls-1 small">Aktivitas Mitra</span>
            <h2 class="fw-bold m-0 text-dark">Pesanan Saya</h2>
        </div>
        <a href="{{ route('catalog.index') }}" class="btn btn-dark rounded-pill px-4 py-2 fw-bold shadow-sm">
            <i class="fas fa-plus me-2"></i> Buat Pesanan Baru
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-12">
            @forelse($orders as $order)
                <div class="order-card shadow-sm mb-4">
                    {{-- Bagian Atas: Info Invoice & Status --}}
                    <div class="px-4 py-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2 bg-light bg-opacity-10">
                        <div>
                            <span class="text-muted small fw-bold text-uppercase">Invoice:</span>
                            <span class="fw-bold text-dark ms-1">#{{ $order->kode_invoice }}</span>
                            <span class="mx-2 text-muted opacity-50">|</span>
                            <span class="text-muted small"><i class="far fa-clock me-1"></i> {{ $order->tgl_pesan->format('d M Y, H:i') }}</span>
                        </div>

                        @if($order->status == 'menunggu_bayar')
                            <span class="status-badge bg-waiting">Menunggu Pembayaran</span>
                        @elseif($order->status == 'sudah_bayar')
                            <span class="status-badge bg-paid">Lunas & Diproses</span>
                        @elseif($order->status == 'siap_diambil')
                            <span class="status-badge bg-ready">Siap Diambil</span>
                        @elseif($order->status == 'selesai')
                            <span class="status-badge bg-done">Selesai</span>
                        @else
                            <span class="status-badge bg-danger text-white">Dibatalkan</span>
                        @endif
                    </div>

                    {{-- Bagian Tengah: Konten Order --}}
                    <div class="p-4">
                        <div class="row align-items-center">
                            <div class="col-md-7 mb-4 mb-md-0">
                                <div class="d-flex align-items-center">
                                    <div class="store-icon me-3">
                                        <i class="fas fa-store"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 text-muted small fw-bold">Titik Pengambilan:</p>
                                        <h6 class="fw-bold text-dark mb-1">{{ $order->toko->nama_toko }}</h6>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="small text-muted"><i class="fas fa-calendar-check text-success me-1"></i> Jadwal: <strong>{{ $order->tgl_ambil->format('d M Y') }}</strong></span>
                                            <span class="badge bg-warning bg-opacity-10 text-warning border-0 rounded-pill" style="font-size: 10px;">PRE-ORDER H+3</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5 border-divider text-md-end">
                                <div class="mb-3">
                                    <p class="mb-0 text-muted small fw-bold">Total Pembayaran:</p>
                                    <h4 class="fw-bold text-success mb-0">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</h4>
                                </div>

                                <div class="d-flex gap-2 justify-content-md-end">
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn-detail-custom">
                                        Detail
                                    </a>

                                    @if($order->status == 'menunggu_bayar')
                                        <a href="{{ route('checkout.payment', $order->id) }}" class="btn-pay-now">
                                            Bayar Sekarang <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                {{-- State Kosong --}}
                <div class="text-center py-5">
                    <div class="mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light" style="width: 120px; height: 120px;">
                            <i class="fas fa-receipt fa-4x text-muted opacity-25"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold text-dark">Belum ada riwayat pesanan</h4>
                    <p class="text-muted mx-auto" style="max-width: 400px;">Anda belum melakukan transaksi apapun. Yuk, mulai stok durian premium untuk bisnismu sekarang!</p>
                    <a href="{{ route('catalog.index') }}" class="btn btn-warning rounded-pill px-5 py-2 mt-3 fw-bold shadow-sm">Mulai Belanja</a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection