
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('kelas', 'nama_kelas')) {
            Schema::table('kelas', function (Blueprint $table) {
                $table->string('nama_kelas')->after('id');
            });
        }

        if (!Schema::hasColumn('kelas', 'tahun_ajaran')) {
            Schema::table('kelas', function (Blueprint $table) {
                $table->string('tahun_ajaran')->after('kode_kelas');
            });
        }

        if (!Schema::hasColumn('kelas', 'keterangan')) {
            Schema::table('kelas', function (Blueprint $table) {
                $table->text('keterangan')->nullable()->after('tahun_ajaran');
            });
        }

        if (!Schema::hasColumn('wali_kelas', 'alamat')) {
            Schema::table('wali_kelas', function (Blueprint $table) {
                $table->text('alamat')->nullable()->after('no_hp');
            });
        }
    }

    public function down(): void
    {
        Schema::table('wali_kelas', function (Blueprint $table) {
            if (Schema::hasColumn('wali_kelas', 'alamat')) {
                $table->dropColumn('alamat');
            }
        });

        Schema::table('kelas', function (Blueprint $table) {
            $columns = [];

            foreach (['nama_kelas', 'tahun_ajaran', 'keterangan'] as $column) {
                if (Schema::hasColumn('kelas', $column)) {
                    $columns[] = $column;
                }
            }

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
