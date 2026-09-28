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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->nullable(); // Nomor Induk Siswa (opsional)
            $table->string('name');            // Nama lengkap siswa
            $table->enum('gender', ['L', 'P'])->default('L'); // Jenis Kelamin (L/P)
            $table->string('phone')->nullable(); // No HP/WA (opsional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};