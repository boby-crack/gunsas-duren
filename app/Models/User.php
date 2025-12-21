<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

   protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'no_hp',
    'toko_id',
    // --- DATA BARU ---
    'nik',
    'alamat_lengkap',
    'kota_domisili',
    'link_sosmed',
    'foto_ktp',
    'foto_freezer',
    'foto_profil',
    'foto_pegang_ktp',
    'status_akun',
    'alasan_penolakan',
];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi: Satu Reseller bisa punya banyak Order
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function toko()
{
    return $this->belongsTo(Toko::class);
}
}
