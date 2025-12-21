<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Buat 1 Akun Admin
        User::create([
            'name' => 'Admin Gunsas',
            'email' => 'admin@gunsas.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'no_hp' => '081234567890'
        ]);

        // Buat 1 Akun Reseller Contoh
        User::create([
            'name' => 'Reseller A',
            'email' => 'reseller@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'reseller',
            'no_hp' => '089876543210'
        ]);
    }
}
