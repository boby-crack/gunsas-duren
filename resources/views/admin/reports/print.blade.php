<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan Gunsas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; }
        .header { border-bottom: 2px solid #000; margin-bottom: 20px; padding-bottom: 10px; }
    </style>
</head>
<body onload="window.print()">

    <div class="container mt-4">
        <div class="text-center header">
            <h2 class="fw-bold">GUNSAS DUREN (PT. GUNSAS JAYA BERKAH)</h2>
            <p class="mb-0">Laporan Penjualan & Pemesanan Reseller (B2B)</p>
            <small>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</small>
        </div>

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Tgl Invoice</th>
                    <th>Kode Invoice</th>
                    <th>Nama Reseller</th>
                    <th>Lokasi Ambil</th>
                    <th>Nominal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $index => $order)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $order->tgl_pesan->format('d/m/Y') }}</td>
                    <td>{{ $order->kode_invoice }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->toko->nama_toko }}</td>
                    <td class="text-end">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-end fw-bold">TOTAL PENDAPATAN</td>
                    <td class="text-end fw-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="mt-5 text-end">
            <p>Jakarta, {{ date('d F Y') }}</p>
            <br><br><br>
            <p class="fw-bold text-decoration-underline">{{ Auth::user()->name }}</p>
            <p>Administrator</p>
        </div>
    </div>

</body>
</html>
