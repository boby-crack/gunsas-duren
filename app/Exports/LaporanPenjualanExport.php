<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanPenjualanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $dari, $sampai;

    public function __construct($dari, $sampai)
    {
        // Pastikan variabel mendapatkan nilai default jika kosong agar query tidak error
        $this->dari = $dari ?? date('Y-m-01'); 
        $this->sampai = $sampai ?? date('Y-m-d');
    }

    public function collection()
    {
        // Gunakan where biasa dengan range jam penuh agar data di tanggal tersebut tertangkap semua
        return Order::with(['user', 'toko'])
            ->where('tgl_pesan', '>=', $this->dari . ' 00:00:00')
            ->where('tgl_pesan', '<=', $this->sampai . ' 23:59:59')
            ->whereIn('status', ['sudah_bayar', 'siap_diambil', 'selesai'])
            ->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal Pesan',
            'Invoice',
            'Nama Pemesan',
            'Cabang/Toko',
            'Total Bayar',
            'Status'
        ];
    }

    public function map($order): array
    {
        return [
            // Parse tgl_pesan menggunakan Carbon agar formatnya rapi di Excel
            \Carbon\Carbon::parse($order->tgl_pesan)->format('d/m/Y H:i'),
            $order->kode_invoice,
            $order->user->name ?? 'User Tidak Ditemukan',
            $order->toko->nama_toko ?? 'Pusat',
            $order->total_bayar,
            strtoupper(str_replace('_', ' ', $order->status)),
        ];
    }
}