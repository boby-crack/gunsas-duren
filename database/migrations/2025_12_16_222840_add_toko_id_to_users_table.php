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
        // Kolom ini boleh NULL (karena Admin & Reseller tidak punya toko spesifik)
        // Jika Toko dihapus, user tidak ikut terhapus (Set Null)
        $table->foreignId('toko_id')->nullable()->constrained('tokos')->onDelete('set null')->after('role');
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['toko_id']);
        $table->dropColumn('toko_id');
    });
}
};
