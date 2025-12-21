@extends('layouts.reseller')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark mb-0">Pesanan Saya</h3>
            <a href="{{ route('catalog.index') }}" class="btn btn-warning rounded-pill shadow-sm">
                <i class="fas fa-plus me-2"></i> Buat Pesanan Baru
            </a>
        </div>

        @forelse($orders as $order)
            <div class="card border-0 shadow-sm mb-3 rounded-3 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <span class="fw-bold text-dark me-2"><i class="fas fa-receipt text-secondary"></i> {{ $order->kode_invoice }}</span>
                            <span class="text-muted small">{{ $order->tgl_pesan->format('d M Y, H:i') }}</span>
                        </div>

                        @if($order->status == 'menunggu_bayar')
                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Menunggu Pembayaran</span>
                        @elseif($order->status == 'sudah_bayar')
                            <span class="badge bg-success px-3 py-2 rounded-pill">Lunas / Diproses</span>
                        @elseif($order->status == 'siap_diambil')
                            <span class="badge bg-info text-dark px-3 py-2 rounded-pill">Siap Diambil di Toko</span>
                        @elseif($order->status == 'selesai')
                            <span class="badge bg-primary px-3 py-2 rounded-pill">Selesai</span>
                        @else
                            <span class="badge bg-danger px-3 py-2 rounded-pill">Dibatalkan</span>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8 mb-3 mb-md-0">
                            <div class="d-flex align-items-start">
                                <div class="me-3 text-center">
                                    <div class="bg-light rounded p-2 text-warning">
                                        <i class="fas fa-store fa-2x"></i>
                                    </div>
                                </div>
                                <div>
                                    <p class="mb-1 text-muted small">Lokasi Pengambilan:</p>
                                    <h6 class="fw-bold text-dark mb-1">{{ $order->toko->nama_toko }}</h6>
                                    <p class="small text-danger mb-0">
                                        <i class="fas fa-calendar-alt me-1"></i> Jadwal Ambil: <strong>{{ $order->tgl_ambil->format('d M Y') }}</strong> (H+3)
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 text-md-end border-start-md">
                            <p class="mb-1 text-muted small">Total Tagihan:</p>
                            <h5 class="fw-bold text-primary mb-3">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</h5>

                            <div class="d-flex gap-2 justify-content-md-end">
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-secondary btn-sm rounded-pill px-4">
                                    Detail
                                </a>

                                @if($order->status == 'menunggu_bayar')
                                    <a href="{{ route('checkout.payment', $order->id) }}" class="btn btn-primary btn-sm rounded-pill px-4">
                                        Bayar Sekarang
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-shopping-basket fa-4x text-muted opacity-25"></i>
                </div>
                <h5 class="fw-bold text-muted">Belum ada riwayat pesanan</h5>
                <p class="text-muted mb-4">Yuk, mulai stok durian premium untuk bisnismu!</p>
                <a href="{{ route('catalog.index') }}" class="btn btn-warning rounded-pill px-5 py-2 fw-bold">Mulai Belanja</a>
            </div>
        @endforelse

    </div>
</div>
@endsection

<style>
    /* Sedikit custom css untuk garis pemisah responsif */
    @media (min-width: 768px) {
        .border-start-md { border-left: 1px solid #eee; }
    }
</style>
