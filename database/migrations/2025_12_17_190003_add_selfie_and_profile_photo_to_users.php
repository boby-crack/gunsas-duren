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
        if (!Schema::hasColumn('users', 'foto_profil')) {
            $table->string('foto_profil')->nullable();
        }
        if (!Schema::hasColumn('users', 'foto_pegang_ktp')) {
            $table->string('foto_pegang_ktp')->nullable(); // Selfie KTP
        }
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['foto_profil', 'foto_pegang_ktp']);
    });
}
};
