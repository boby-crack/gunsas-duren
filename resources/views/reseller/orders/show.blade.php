@extends('layouts.reseller')

@section('title', 'Detail Pesanan #' . $order->kode_invoice)

@section('content')
<style>
    .detail-card { background: white; border-radius: 20px; border: 1px solid #ECEFF1; overflow: hidden; }
    .section-title { font-weight: 800; color: #1B1B1B; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
    .section-title i { color: #FBC02D; }
    
    .status-banner { padding: 15px 25px; font-weight: 700; display: flex; align-items: center; justify-content: space-between; }
    .status-menunggu_bayar { background-color: #FFF9C4; color: #F57F17; }
    .status-sudah_bayar { background-color: #E8F5E9; color: #2E7D32; }
    .status-siap_diambil { background-color: #E1F5FE; color: #0288D1; }
    .status-selesai { background-color: #F5F5F5; color: #616161; }

    .product-thumb { width: 50px; height: 50px; object-fit: cover; border-radius: 10px; border: 1px solid #eee; }
    
    .info-label { font-size: 0.75rem; font-weight: 700; color: #90A4AE; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 5px; }
    .info-value { font-weight: 700; color: #1B1B1B; display: block; }
    
    .table-custom thead { background-color: #FAFAFA; }
    .table-custom th { border: none; font-size: 0.85rem; color: #546E7A; padding: 15px; }
    .table-custom td { padding: 15px; vertical-align: middle; border-top: 1px solid #F5F5F5; }

    .btn-download { background-color: #D32F2F; color: white; border: none; padding: 10px 20px; border-radius: 50px; font-weight: 700; transition: 0.3s; }
    .btn-download:hover { background-color: #B71C1C; color: white; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(211, 47, 47, 0.3); }
    
    .btn-back { border: 2px solid #ECEFF1; color: #546E7A; border-radius: 50px; padding: 8px 20px; font-weight: 700; transition: 0.3s; text-decoration: none; }
    .btn-back:hover { background: #1B1B1B; color: #FBC02D; border-color: #1B1B1B; }
</style>

<div class="container">
    {{-- Action Bar --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <a href="{{ route('orders.index') }}" class="btn-back">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Riwayat
        </a>
        
        <a href="{{ route('orders.invoice', $order->id) }}" class="btn-download shadow-sm">
            <i class="fas fa-file-pdf me-2"></i> Download Invoice (PDF)
        </a>
    </div>

    <div class="row g-4">
        {{-- KIRI: DAFTAR PRODUK --}}
        <div class="col-lg-8">
            <div class="detail-card shadow-sm mb-4">
                {{-- Status Banner --}}
                <div class="status-banner status-{{ $order->status }}">
                    <span><i class="fas fa-receipt me-2"></i> INVOICE: {{ $order->kode_invoice }}</span>
                    <span class="badge bg-white text-dark rounded-pill px-3">{{ strtoupper(str_replace('_', ' ', $order->status)) }}</span>
                </div>

                <div class="p-4">
                    <h5 class="section-title"><i class="fas fa-shopping-basket"></i> Rincian Pesanan</h5>
                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center">Harga</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            @if($item->product->gambar)
                                                <img src="{{ asset('storage/'.$item->product->gambar) }}" class="product-thumb">
                                            @else
                                                <div class="product-thumb bg-light d-flex align-items-center justify-content-center"><i class="fas fa-box text-muted"></i></div>
                                            @endif
                                            <div>
                                                <span class="fw-bold text-dark d-block">{{ $item->product->nama_produk }}</span>
                                                <small class="text-muted">Mitra Grosir</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center fw-bold text-muted">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="text-center fw-bold text-dark">{{ $item->jumlah }} Box</td>
                                    <td class="text-end fw-bold text-dark">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end py-4 fw-bold text-muted">TOTAL PEMBAYARAN</td>
                                    <td class="text-end py-4 fw-bold fs-4 text-success">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- KANAN: INFO PENGAMBILAN --}}
        <div class="col-lg-4">
            <div class="detail-card shadow-sm p-4 mb-4">
                <h5 class="section-title"><i class="fas fa-store"></i> Titik Pengambilan</h5>
                
                <div class="mb-4">
                    <span class="info-label">Nama Outlet</span>
                    <span class="info-value">{{ $order->toko->nama_toko }}</span>
                </div>

                <div class="mb-4">
                    <span class="info-label">Alamat Lengkap</span>
                    <p class="text-muted small fw-bold mb-0 lh-sm">{{ $order->toko->alamat_lengkap }}</p>
                </div>

                <div class="mb-4 p-3 bg-light rounded-4">
                    <span class="info-label">Jadwal Pengambilan</span>
                    <span class="info-value text-danger fs-5">
                        <i class="far fa-calendar-check me-1"></i> {{ $order->tgl_ambil->format('d M Y') }}
                    </span>
                    <small class="text-muted fw-bold" style="font-size: 10px;">*Tunjukkan invoice ini ke petugas outlet</small>
                </div>

                <div class="alert bg-warning bg-opacity-10 border-0 rounded-4 p-3 mb-0">
                    <div class="d-flex gap-2">
                        <i class="fas fa-info-circle text-warning mt-1"></i>
                        <p class="small mb-0 text-dark fw-bold">
                            Pastikan Anda datang sesuai jadwal untuk menjamin kesegaran produk durian pilihan Anda.
                        </p>
                    </div>
                </div>
            </div>

            @if($order->status == 'menunggu_bayar')
                <a href="{{ route('checkout.payment', $order->id) }}" class="btn btn-dark w-100 py-3 rounded-pill fw-bold shadow">
                    Lanjutkan Pembayaran <i class="fas fa-chevron-right ms-2 text-warning"></i>
                </a>
            @endif
        </div>
    </div>
</div>
@endsection