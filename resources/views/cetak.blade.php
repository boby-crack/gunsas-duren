<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $order->kode_invoice }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 10pt; color: #333; line-height: 1.5; margin: 0; padding: 0; }
        .invoice-box { padding: 30px; }
        
        /* Header */
        .header-table { width: 100%; border-bottom: 2px solid #FBC02D; margin-bottom: 30px; padding-bottom: 10px; }
        .company-info h2 { margin: 0; color: #1B1B1B; text-transform: uppercase; letter-spacing: 1px; }
        .company-info p { margin: 2px 0; font-size: 9pt; color: #666; }

        /* Info Grid */
        .info-table { width: 100%; margin-bottom: 30px; }
        .info-td { vertical-align: top; width: 50%; }
        .info-label { color: #999; text-transform: uppercase; font-size: 8pt; font-weight: bold; margin-bottom: 5px; }
        .info-value { font-size: 10pt; font-weight: bold; color: #1B1B1B; }

        /* Item Table */
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .items-table th { background-color: #1B1B1B; color: white; padding: 12px 10px; text-align: left; font-size: 9pt; text-transform: uppercase; }
        .items-table td { padding: 12px 10px; border-bottom: 1px solid #eee; font-size: 10pt; }
        .items-table tr:nth-child(even) { background-color: #fafafa; }
        
        /* Summary */
        .total-section { width: 100%; margin-top: 20px; }
        .total-amount { font-size: 14pt; color: #388E3C; font-weight: bold; }
        
        /* Status Label */
        .status-box { 
            display: inline-block; padding: 8px 15px; border-radius: 5px; 
            font-weight: bold; text-transform: uppercase; font-size: 9pt;
            margin-top: 10px;
        }
        .paid { border: 2px solid #388E3C; color: #388E3C; }
        .unpaid { border: 2px solid #FBC02D; color: #FBC02D; }

        .footer-note { margin-top: 50px; font-size: 8pt; color: #888; border-top: 1px solid #eee; pt: 10px; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table class="header-table">
            <tr>
                <td style="width: 150px;">
                    <img src="{{ public_path('assets/img/logo-gunsas.png') }}" style="width: 100px;">
                </td>
                <td class="company-info" style="text-align: right;">
                    <h2>Invoice Pembelian</h2>
                    <p><strong>PT. Gunsas Jaya Berkah</strong></p>
                    <p>Jl. Raya Puncak No. 412, Cisarua, Bogor</p>
                    <p>Email: gunsas.duren@gmail.com | WA: 0851-8081-6488</p>
                </td>
            </tr>
        </table>

        <table class="info-table">
            <tr>
                <td class="info-td">
                    <div class="info-label">DITAGIHKAN KEPADA:</div>
                    <div class="info-value">{{ Auth::user()->name }}</div>
                    <div class="info-value" style="font-weight: normal;">Mitra Reseller Gunsas</div>
                </td>
                <td class="info-td" style="text-align: right;">
                    <div class="info-label">NOMOR INVOICE:</div>
                    <div class="info-value">#{{ $order->kode_invoice }}</div>
                    <div class="info-label" style="margin-top: 10px;">TANGGAL TRANSAKSI:</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($order->tgl_pesan)->format('d F Y') }}</div>
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 45%;">Nama Produk</th>
                    <th style="text-align: center;">Harga Satuan</th>
                    <th style="text-align: center;">Kuantitas</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->nama_produk ?? 'Produk Dihapus' }}</td>
                    <td style="text-align: center;">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td style="text-align: center;">{{ $item->jumlah }} Box</td>
                    <td style="text-align: right;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <table style="width: 100%;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <div class="info-label">STATUS PEMBAYARAN:</div>
                    @if($order->status == 'sudah_bayar' || $order->status == 'siap_diambil' || $order->status == 'selesai')
                        <div class="status-box paid">LUNAS / PAID</div>
                    @else
                        <div class="status-box unpaid">MENUNGGU PEMBAYARAN</div>
                    @endif
                    
                    <div style="margin-top: 20px;">
                        <div class="info-label">TITIK PENGAMBILAN:</div>
                        <div class="info-value">{{ $order->toko->nama_toko }}</div>
                        <div style="font-size: 9pt; color: #666;">{{ $order->toko->alamat_lengkap }}</div>
                    </div>
                </td>
                <td style="width: 50%; vertical-align: top; text-align: right;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td class="info-label" style="padding-bottom: 5px;">Total Item:</td>
                            <td class="info-value" style="padding-bottom: 5px; width: 120px;">{{ $order->orderItems->sum('jumlah') }} Box</td>
                        </tr>
                        <tr>
                            <td class="info-label" style="border-top: 1px solid #eee; padding-top: 10px;">TOTAL TAGIHAN:</td>
                            <td class="total-amount" style="border-top: 1px solid #eee; padding-top: 10px;">
                                Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-label" style="margin-top: 15px;">JADWAL AMBIL:</td>
                            <td class="info-value" style="color: #D32F2F;">
                                {{ \Carbon\Carbon::parse($order->tgl_ambil)->format('d M Y') }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="footer-note">
            <p><strong>Catatan:</strong></p>
            <ul>
                <li>Harap bawa invoice ini (digital/cetak) saat melakukan pengambilan barang di outlet.</li>
                <li>Periksa kembali kondisi barang saat serah terima.</li>
                <li>Dokumen ini dihasilkan secara otomatis oleh sistem Gunsas Duren.</li>
            </ul>
        </div>
    </div>
    <div style="margin-top: 20px; border-top: 1px dashed #ccc; padding-top: 10px; font-size: 8pt; color: #666;">
    <strong>Disclaimer:</strong>
    <p style="margin: 0;">Dokumen ini adalah bukti pembayaran sah. Pastikan barang diperiksa bersama petugas saat pengambilan. Kami tidak menerima komplain kerusakan/kekurangan barang setelah reseller meninggalkan area outlet.</p>
</div>
</body>
</html>