@extends('layouts.reseller')

@section('content')
<div class="container">
    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary mb-3">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <span>INVOICE: <strong>{{ $order->kode_invoice }}</strong></span>
                    <span class="badge bg-white text-dark">{{ strtoupper(str_replace('_', ' ', $order->status)) }}</span>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->product->gambar)
                                            <img src="{{ asset('storage/'.$item->product->gambar) }}" width="40" class="me-2 rounded">
                                        @endif
                                        {{ $item->product->nama_produk }}
                                    </div>
                                </td>
                                <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="3" class="fw-bold text-end">TOTAL BAYAR</td>
                                <td class="fw-bold text-end fs-5 text-primary">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Info Pengambilan</h5>

                    <div class="mb-3">
                        <small class="text-muted d-block">Lokasi Toko</small>
                        <span class="fw-bold text-dark"><i class="fa-solid fa-store me-1"></i> {{ $order->toko->nama_toko }}</span>
                        <p class="small text-muted mt-1">{{ $order->toko->alamat_lengkap }}</p>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Tanggal Pengambilan</small>
                        <span class="fw-bold text-danger fs-5">
                            <i class="fa-solid fa-calendar-day me-1"></i> {{ $order->tgl_ambil->format('d M Y') }}
                        </span>
                    </div>

                    <div class="alert alert-info small">
                        <i class="fa-solid fa-info-circle"></i> Tunjukkan halaman ini kepada petugas toko saat mengambil barang.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
