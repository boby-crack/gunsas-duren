@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    {{-- Tombol Navigasi --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
        <button onclick="window.print()" class="btn btn-dark shadow-sm">
            <i class="fa-solid fa-print me-1"></i> Cetak Invoice
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        {{-- BAGIAN KIRI: RINCIAN ITEM --}}
        <div class="col-md-8">
            <div class="card shadow border-0 mb-4">
                <div class="card-header py-3 bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fa-solid fa-receipt me-2"></i>Invoice: {{ $order->kode_invoice }}
                        </h6>
                        {{-- Badge Status Visual --}}
                        @php
                            $status_color = [
                                'menunggu_bayar' => 'warning',
                                'sudah_bayar' => 'success',
                                'siap_diambil' => 'info',
                                'selesai' => 'primary',
                                'batal' => 'danger'
                            ];
                        @endphp
                        <span class="badge bg-{{ $status_color[$order->status] ?? 'secondary' }} text-white px-3 py-2 rounded-pill">
                            {{ strtoupper(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead class="text-muted small text-uppercase" style="background: #f8f9fc;">
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center">Harga Satuan</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                <tr class="border-bottom">
                                    <td class="fw-bold text-dark">{{ $item->product->nama_produk }}</td>
                                    <td class="text-center">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $item->jumlah }}</td>
                                    <td class="text-end fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold py-3">GRAND TOTAL:</td>
                                    <td class="text-end text-primary fw-bold py-3" style="font-size: 1.2rem;">
                                        Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- BAGIAN KANAN: INFORMASI & AKSI --}}
        <div class="col-md-4">
            {{-- Info Customer --}}
            <div class="card shadow border-0 mb-4">
                <div class="card-header py-3 bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">Informasi Pengambilan</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="small text-muted fw-bold d-block">RESELLER / PEMESAN</label>
                        <span class="text-dark fw-bold">{{ $order->user->name }}</span><br>
                        <small class="text-muted"><i class="fa-brands fa-whatsapp me-1"></i>{{ $order->user->no_hp }}</small>
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted fw-bold d-block">JADWAL PENGAMBILAN (H+3)</label>
                        <span class="text-danger fw-bold h5"><i class="fa-solid fa-calendar-day me-1"></i>{{ $order->tgl_ambil->format('d M Y') }}</span>
                    </div>
                    <div class="mb-0">
                        <label class="small text-muted fw-bold d-block">LOKASI OUTLET</label>
                        <span class="text-dark fw-bold"><i class="fa-solid fa-store me-1"></i>{{ $order->toko->nama_toko }}</span>
                    </div>
                </div>
            </div>

            {{-- Aksi Berdasarkan Role --}}
           <div class="card shadow border-0 mb-4">
    <div class="card-header py-3 {{ auth()->user()->role == 'admin' ? 'bg-warning' : 'bg-info' }}">
        <h6 class="m-0 font-weight-bold text-dark">
            <i class="fa-solid fa-user-gear me-2"></i>Aksi {{ ucfirst(auth()->user()->role) }}
        </h6>
    </div>
    <div class="card-body">
        {{-- CEK APAKAH PESANAN SUDAH FINAL --}}
        @if($order->status == 'selesai')
            <div class="text-center py-3">
                <i class="fa-solid fa-circle-check text-success fa-3x mb-3"></i>
                <h6 class="fw-bold text-success">PESANAN SUDAH SELESAI</h6>
                <p class="small text-muted">Status pesanan ini sudah final dan tidak dapat diubah kembali.</p>
            </div>
        @elseif($order->status == 'batal')
            <div class="text-center py-3">
                <i class="fa-solid fa-circle-xmark text-danger fa-3x mb-3"></i>
                <h6 class="fw-bold text-danger">PESANAN DIBATALKAN</h6>
                <p class="small text-muted">Pesanan yang telah dibatalkan tidak dapat diproses lagi.</p>
            </div>
        @else
            {{-- FORM HANYA MUNCUL JIKA STATUS BELUM SELESAI/BATAL --}}
            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-bold small">UPDATE STATUS OPERASIONAL</label>
                    
                    @if(auth()->user()->role == 'admin')
                        <select name="status" class="form-select form-control border-primary">
                            {{-- Admin tidak butuh opsi 'menunggu_bayar' karena itu otomatis Midtrans --}}
                            <option value="sudah_bayar" {{ $order->status == 'sudah_bayar' ? 'selected' : '' }}>Sudah Bayar (Siapkan Barang)</option>
                            <option value="siap_diambil" {{ $order->status == 'siap_diambil' ? 'selected' : '' }}>Siap Diambil (Packing Selesai)</option>
                            <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai (Sudah Diambil)</option>
                            <option value="batal" {{ $order->status == 'batal' ? 'selected' : '' }}>Batalkan Pesanan</option>
                        </select>
                    @else
                        {{-- Logika Staff --}}
                        @if($order->status == 'siap_diambil')
                            <select name="status" class="form-select form-control border-info">
                                <option value="siap_diambil" selected disabled>Status: Siap Diambil</option>
                                <option value="selesai">Selesaikan (Sudah Diambil)</option>
                            </select>
                        @else
                            <div class="alert alert-secondary small mb-0">
                                <i class="fa-solid fa-clock me-1"></i> Menunggu Admin Pusat menyiapkan barang.
                            </div>
                        @endif
                    @endif
                </div>

                @if(auth()->user()->role == 'admin' || (auth()->user()->role == 'staff' && $order->status == 'siap_diambil'))
                    <button type="submit" class="btn btn-primary w-100 py-2 shadow-sm">
                        <i class="fa-solid fa-save me-1"></i> Perbarui Status
                    </button>
                @endif
            </form>
        @endif
    </div>
</div>
        </div>
    </div>
</div>

<style>
/* CSS UNTUK CETAK */
@media print {
    .sidebar, .navbar, .btn-secondary, .btn-dark, form, .alert, .card-header button { 
        display: none !important; 
    }
    .content-wrapper { margin: 0 !important; padding: 0 !important; }
    .container-fluid { width: 100% !important; }
    .card { border: none !important; box-shadow: none !important; }
    .card-header { background-color: transparent !important; color: black !important; border-bottom: 2px solid #333 !important; }
    .table th { background-color: #eee !important; color: black !important; }
    .badge { border: 1px solid #333 !important; color: black !important; }
}
</style>
@endsection