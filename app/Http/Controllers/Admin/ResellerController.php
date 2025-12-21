<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ResellerController extends Controller
{
    public function index()
{
    // 1. Menunggu Verifikasi
    $pendingResellers = User::where('role', 'reseller')
                            ->where('status_akun', 'waiting_approval')
                            ->orderBy('updated_at', 'asc')
                            ->get();

    // 2. Reseller Aktif
    $activeResellers = User::where('role', 'reseller')
                           ->where('status_akun', 'active')
                           ->latest()
                           ->get();

    // 3. Ditolak (TAMBAHAN BARU)
    $rejectedResellers = User::where('role', 'reseller')
                             ->where('status_akun', 'rejected')
                             ->latest()
                             ->get();

    return view('admin.resellers.index', compact('pendingResellers', 'activeResellers', 'rejectedResellers'));
}

    // Method untuk Proses Verifikasi (Terima/Tolak)
    public function verify(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $action = $request->input('action');

        if ($action == 'approve') {
            // Jika diterima, hapus alasan penolakan sebelumnya (jika ada)
            $user->update([
                'status_akun' => 'active',
                'alasan_penolakan' => null
            ]);
            return redirect()->back()->with('success', 'Reseller berhasil diterima!');
        }

        elseif ($action == 'reject') {
            // Validasi alasan wajib diisi
            $request->validate(['alasan' => 'required|string|min:5']);

            // Opsional: Hapus foto agar user upload ulang yang baru
            if($user->foto_ktp) Storage::disk('public')->delete($user->foto_ktp);
            if($user->foto_pegang_ktp) Storage::disk('public')->delete($user->foto_pegang_ktp);
            if($user->foto_freezer) Storage::disk('public')->delete($user->foto_freezer);
            // Foto profil jangan dihapus, biar dia gak capek upload itu lagi (opsional)

            $user->update([
                'status_akun' => 'rejected',
                'alasan_penolakan' => $request->alasan // Simpan alasan
            ]);

            return redirect()->back()->with('success', 'Pengajuan ditolak. Alasan telah dikirim ke user.');
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        // Hapus file terkait
        if($user->foto_ktp) Storage::disk('public')->delete($user->foto_ktp);
        if($user->foto_freezer) Storage::disk('public')->delete($user->foto_freezer);

        $user->delete();
        return redirect()->back()->with('success', 'Data reseller dihapus.');
    }
}
