<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            // User yang menerima notifikasi
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Jenis notifikasi
            $table->enum('type', [
                'pengingat_pembayaran',
                'pembayaran_berhasil',
                'pembayaran_diperbarui',
                'pembayaran_dihapus',
            ]);

            // Judul dan isi notifikasi
            $table->string('title');
            $table->text('message');

            // Menandai apakah notifikasi sudah dibaca
            $table->timestamp('read_at')->nullable();

            $table->timestamps();

            // Mempercepat pencarian notifikasi berdasarkan user
            $table->index(['user_id', 'read_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};