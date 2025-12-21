<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_invoice',
        'user_id',
        'toko_id',      // Lokasi ambil
        'tgl_pesan',
        'tgl_ambil',    // Validasi H+3
        'total_bayar',
        'status',       // 'menunggu_bayar', 'siap_diambil', dll
        'snap_token',   // Midtrans
    ];

    // Agar Laravel otomatis menganggap kolom ini sebagai Tanggal (Carbon)
    protected $casts = [
        'tgl_pesan' => 'datetime',
        'tgl_ambil' => 'date',
    ];

    // Relasi ke User (Reseller yang pesan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Toko (Tempat ambil barang)
    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }

    // Relasi ke Detail Item (Barang apa saja yang dibeli)
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
