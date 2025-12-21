@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Manajemen Pesanan Masuk</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th>Invoice</th>
                            <th>Reseller</th>
                            <th>Tgl Ambil</th>
                            <th>Toko</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->kode_invoice }}</td>
                            <td>
                                {{ $order->user->name }}<br>
                                <small class="text-muted">{{ $order->user->no_hp }}</small>
                            </td>
                            <td>{{ $order->tgl_ambil->format('d M Y') }}</td>
                            <td>{{ $order->toko->nama_toko }}</td>
                            <td>Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                            <td>
                                @if($order->status == 'menunggu_bayar')
                                    <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
                                @elseif($order->status == 'sudah_bayar')
                                    <span class="badge bg-success">Lunas (Perlu Disiapkan)</span>
                                @elseif($order->status == 'siap_diambil')
                                    <span class="badge bg-info text-dark">Siap Diambil</span>
                                @elseif($order->status == 'selesai')
                                    <span class="badge bg-primary">Selesai</span>
                                @else
                                    <span class="badge bg-danger">Batal</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info">
                                    <i class="fa-solid fa-eye"></i> Proses
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada pesanan masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
