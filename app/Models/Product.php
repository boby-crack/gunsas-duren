<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'harga_mitra', // Harga khusus B2B
        'gambar',
    ];

    // Relasi: Satu produk bisa ada di banyak detail transaksi
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
