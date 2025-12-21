<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileCompletionController extends Controller
{
    public function create()
    {
        $user = auth()->user();

        // 1. Jika sudah Aktif -> Lempar ke Dashboard/Order
        if ($user->status_akun == 'active') {
            return redirect()->route('orders.index');
        }

        // 2. Jika Menunggu Approval -> Lempar ke Halaman Tunggu
        if ($user->status_akun == 'waiting_approval') {
            return redirect()->route('verification.notice');
        }

        // 3. Jika Pending ATAU Rejected -> Boleh akses form ini
        // Kita kirim data $user ke view agar field input bisa otomatis terisi (value="{{ old('nik', $user->nik) }}")
        return view('auth.complete-profile', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|numeric|digits:16',
            'no_hp' => 'required|numeric',
            'alamat_lengkap' => 'required|string',
            'kota_domisili' => 'required|string',
            // Kita wajibkan upload ulang semua foto untuk memastikan data terbaru valid
            'foto_profil' => 'required|image|max:2048',
            'foto_ktp' => 'required|image|max:2048',
            'foto_pegang_ktp' => 'required|image|max:2048',
            'foto_freezer' => 'required|image|max:2048',
        ]);

        $user = auth()->user();

        // === LOGIC HAPUS FOTO LAMA (Agar Server Tidak Penuh Sampah) ===
        if ($user->foto_profil) Storage::disk('public')->delete($user->foto_profil);
        if ($user->foto_ktp) Storage::disk('public')->delete($user->foto_ktp);
        if ($user->foto_pegang_ktp) Storage::disk('public')->delete($user->foto_pegang_ktp);
        if ($user->foto_freezer) Storage::disk('public')->delete($user->foto_freezer);

        // === SIMPAN FOTO BARU ===
        $pathProfil = $request->file('foto_profil')->store('verifikasi/profil', 'public');
        $pathKtp = $request->file('foto_ktp')->store('verifikasi/ktp', 'public');
        $pathSelfie = $request->file('foto_pegang_ktp')->store('verifikasi/selfie', 'public');
        $pathFreezer = $request->file('foto_freezer')->store('verifikasi/freezer', 'public');

        // === UPDATE DATABASE ===
        $user->update([
            'nik' => $request->nik,
            'no_hp' => $request->no_hp,
            'alamat_lengkap' => $request->alamat_lengkap,
            'kota_domisili' => $request->kota_domisili,
            'link_sosmed' => $request->link_sosmed,

            // Update Path Foto Baru
            'foto_profil' => $pathProfil,
            'foto_ktp' => $pathKtp,
            'foto_pegang_ktp' => $pathSelfie,
            'foto_freezer' => $pathFreezer,

            // PENTING: Reset status jadi 'waiting' dan hapus alasan penolakan lama
            'status_akun' => 'waiting_approval',
            'alasan_penolakan' => null,
        ]);

        return redirect()->route('verification.notice');
    }
}
