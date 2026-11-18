
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan status pada tabel kelas.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('kelas', 'status')) {
            Schema::table('kelas', function (Blueprint $table) {
                $table->string('status')
                    ->default('aktif')
                    ->after('nominal_standar');
            });
        }
    }

    /**
     * Hapus kolom status jika migration dibatalkan.
     */
    public function down(): void
    {
        if (Schema::hasColumn('kelas', 'status')) {
            Schema::table('kelas', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
