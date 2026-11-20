<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('log_transaksi_kas', function (Blueprint $table) {
            $table->string('aktivitas', 20)->change();
        });
    }

    public function down(): void
    {
        if (DB::table('log_transaksi_kas')->where('aktivitas', 'tambah')->exists()) {
            return;
        }

        Schema::table('log_transaksi_kas', function (Blueprint $table) {
            $table->enum('aktivitas', ['edit', 'hapus'])->change();
        });
    }
};
