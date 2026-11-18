<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bendahara', function (Blueprint $table) {
            $table->renameColumn('nip', 'nis');
        });
    }

    public function down(): void
    {
        Schema::table('bendahara', function (Blueprint $table) {
            $table->renameColumn('nis', 'nip');
        });
    }
};
