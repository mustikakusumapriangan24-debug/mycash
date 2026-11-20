<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->unsignedTinyInteger('bulan_mulai')->default(7);
            $table->unsignedTinyInteger('bulan_akhir')->default(6);
        });
    }

    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropColumn(['bulan_mulai', 'bulan_akhir']);
        });
    }
};
