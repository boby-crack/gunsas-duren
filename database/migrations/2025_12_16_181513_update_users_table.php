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
        // Kita tambahkan kolom role untuk membedakan Admin dan Reseller
        $table->string('role')->default('reseller'); // Values: 'admin', 'reseller'
        $table->string('no_hp')->nullable();
        $table->text('alamat')->nullable();
        // Kolom status untuk verifikasi admin (opsional, sesuai bab 1)
        $table->string('status_akun')->default('pending');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
