<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_transaksi_kas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('transaksi_kas_id')->nullable();

            $table->string('no_nota');

            $table->unsignedBigInteger('kelas_id')->nullable();

            $table->unsignedBigInteger('user_id');

            $table->enum('aktivitas', [
                'edit',
                'hapus'
            ]);

            $table->json('data_lama');

            $table->json('data_baru')->nullable();

            $table->text('keterangan')->nullable();

            $table->string('ip_address', 45)->nullable();

            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->index('transaksi_kas_id');
            $table->index('no_nota');
            $table->index('kelas_id');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_transaksi_kas');
    }
};