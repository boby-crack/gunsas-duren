@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mb-3">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Item: {{ $order->kode_invoice }}</h6>
                    <button onclick="window.print()" class="btn btn-sm btn-outline-dark">
                        <i class="fa-solid fa-print"></i> Cetak Invoice
                    </button>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga Mitra</th>
                                <th>Qty</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td>{{ $item->product->nama_produk }}</td>
                                <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="fw-bold">
                            <tr>
                                <td colspan="3" class="text-end">TOTAL:</td>
                                <td class="text-end text-primary fs-5">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-warning">
                    <h6 class="m-0 font-weight-bold text-dark">Aksi Admin</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="small text-muted fw-bold">Pemesan</label>
                        <p class="mb-0">{{ $order->user->name }} ({{ $order->user->no_hp }})</p>
                    </div>

                    <div class="mb-3">
                        <label class="small text-muted fw-bold">Jadwal Ambil</label>
                        <p class="mb-0 fw-bold text-danger">{{ $order->tgl_ambil->format('d M Y') }}</p>
                        <small>Lokasi: {{ $order->toko->nama_toko }}</small>
                    </div>

                    <hr>

                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Update Status Pesanan</label>
                            <select name="status" class="form-select">
                                <option value="menunggu_bayar" {{ $order->status == 'menunggu_bayar' ? 'selected' : '' }}>Menunggu Bayar</option>
                                <option value="sudah_bayar" {{ $order->status == 'sudah_bayar' ? 'selected' : '' }}>Sudah Bayar (Lunas)</option>
                                <option value="siap_diambil" {{ $order->status == 'siap_diambil' ? 'selected' : '' }}>Siap Diambil (Packing Selesai)</option>
                                <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai (Sudah Diambil)</option>
                                <option value="batal" {{ $order->status == 'batal' ? 'selected' : '' }}>Batalkan Pesanan</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa-solid fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .sidebar, .navbar, .btn-secondary, .card-header button, form { display: none !important; }
    .content, .container-fluid { width: 100% !important; margin: 0 !important; padding: 0 !important; }
    .card { border: none !important; box-shadow: none !important; }
}
</style>
@endsection
