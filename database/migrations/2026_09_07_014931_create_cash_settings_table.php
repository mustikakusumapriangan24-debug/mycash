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
        Schema::create('cash_settings', function (Blueprint $table) {
            $table->id();

            // Nominal kas
            $table->decimal('amount', 12, 2);

            // Tanggal mulai berlakunya nominal
            $table->date('effective_from');

            // Keterangan perubahan nominal
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_settings');
    }
};