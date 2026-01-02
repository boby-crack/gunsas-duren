<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('tokos', function (Blueprint $table) {
        // Menambahkan kolom link_maps yang boleh kosong (nullable)
        // Text dipilih karena link maps kadang sangat panjang
        $table->text('link_maps')->nullable()->after('kota');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tokos', function (Blueprint $table) {
            //
        });
    }
};
