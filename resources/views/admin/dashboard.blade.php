@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard Overview</h1>
    </div>

    <div class="row">
       <div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        {{ auth()->user()->role == 'staff' ? 'Pesanan Masuk (Toko Anda)' : 'Pesanan Baru (Pending)' }}
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingOrders }}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

        @if(auth()->user()->role == 'admin')

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Pendapatan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Reseller Aktif
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalResellers }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endif
   <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Pesanan Terbaru Perlu Diproses</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead class="table-light">
                    <tr>
                        <th>No Invoice</th>
                        <th>Reseller</th>
                        <th>Toko Ambil</th>
                        <th>Tgl Ambil (H+3)</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td>{{ $order->kode_invoice }}</td>
                        <td>
                            {{ $order->user->name }}
                            <br><small class="text-muted">{{ $order->user->no_hp }}</small>
                        </td>
                        <td>{{ $order->toko->nama_toko }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->tgl_ambil)->format('d M Y') }}</td>
                        <td>Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                        <td>
                            @if($order->status == 'menunggu_bayar')
                                <span class="badge bg-warning text-dark">Belum Bayar</span>
                            @elseif($order->status == 'sudah_bayar')
                                <span class="badge bg-success">Lunas</span>
                            @elseif($order->status == 'siap_diambil')
                                <span class="badge bg-info text-dark">Siap Diambil</span>
                            @elseif($order->status == 'selesai')
                                <span class="badge bg-primary">Selesai</span>
                            @else
                                <span class="badge bg-danger">Batal</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-3">
                            Belum ada pesanan terbaru.
                        </td>
                    </tr>
                    @endforelse
                    </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
