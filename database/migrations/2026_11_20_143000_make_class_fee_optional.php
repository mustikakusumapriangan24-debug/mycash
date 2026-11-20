<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->decimal('nominal_standar', 12, 2)
                ->nullable()
                ->default(null)
                ->change();
        });

        DB::table('kelas')
            ->where('nominal_standar', 10000)
            ->update(['nominal_standar' => null]);
    }

    public function down(): void
    {
        DB::table('kelas')
            ->whereNull('nominal_standar')
            ->update(['nominal_standar' => 10000]);

        Schema::table('kelas', function (Blueprint $table) {
            $table->decimal('nominal_standar', 12, 2)
                ->default(10000)
                ->nullable(false)
                ->change();
        });
    }
};
