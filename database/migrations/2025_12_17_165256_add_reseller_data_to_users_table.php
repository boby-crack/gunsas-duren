<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    Schema::table('users', function (Blueprint $table) {

        // Cek satu per satu, jika belum ada baru buat
        if (!Schema::hasColumn('users', 'nik')) {
            $table->string('nik')->nullable();
        }
        if (!Schema::hasColumn('users', 'alamat_lengkap')) {
            $table->text('alamat_lengkap')->nullable();
        }
        if (!Schema::hasColumn('users', 'kota_domisili')) {
            $table->string('kota_domisili')->nullable();
        }
        if (!Schema::hasColumn('users', 'link_sosmed')) {
            $table->string('link_sosmed')->nullable();
        }
        if (!Schema::hasColumn('users', 'foto_ktp')) {
            $table->string('foto_ktp')->nullable();
        }
        if (!Schema::hasColumn('users', 'foto_freezer')) {
            $table->string('foto_freezer')->nullable();
        }

        // Penyebab error utama Anda:
        if (!Schema::hasColumn('users', 'status_akun')) {
            $table->string('status_akun')->default('pending');
        }
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['nik', 'alamat_lengkap', 'kota_domisili', 'link_sosmed', 'foto_ktp', 'foto_freezer', 'status_akun']);
    });
}
};
