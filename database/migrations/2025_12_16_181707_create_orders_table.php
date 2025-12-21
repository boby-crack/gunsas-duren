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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('kode_invoice')->unique(); // INV-2025...
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Reseller
        $table->foreignId('toko_id')->constrained('tokos'); // Wajib pilih toko

        $table->dateTime('tgl_pesan');
        $table->date('tgl_ambil'); // Ini yang divalidasi H+3

        $table->decimal('total_bayar', 12, 2);
        $table->enum('status', ['menunggu_bayar', 'sudah_bayar', 'siap_diambil', 'selesai', 'batal'])->default('menunggu_bayar');
        $table->string('snap_token')->nullable(); // Token Midtrans
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
