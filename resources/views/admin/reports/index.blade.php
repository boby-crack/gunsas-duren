@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Laporan Penjualan</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.reports.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Dari Tanggal</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                </div>
                <div class="col-md-6 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa-solid fa-filter me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.reports.print', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                       target="_blank" class="btn btn-danger w-100">
                        <i class="fa-solid fa-print me-1"></i> Cetak PDF
                    </a>
                    <a href="{{ route('admin.reports.excel', request()->all()) }}" class="btn btn-success  w-100">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header py-3 bg-success text-white">
            <h6 class="m-0 font-weight-bold">Hasil Rekapitulasi: Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Pesan</th>
                            <th>Invoice</th>
                            <th>Pemesan</th>
                            <th>Cabang</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $index => $order)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $order->tgl_pesan->format('d/m/Y') }}</td>
                            <td>{{ $order->kode_invoice }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->toko->nama_toko }}</td>
                            <td class="text-end">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data penjualan pada periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-dark">
                        <tr>
                            <td colspan="5" class="text-end fw-bold">GRAND TOTAL</td>
                            <td class="text-end fw-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
