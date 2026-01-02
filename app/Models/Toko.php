<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_toko',
        'alamat_lengkap',
        'kota',
        'link_maps',
    ];

    // Relasi: Satu Toko bisa jadi tempat ambil banyak Order
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
