<?php

namespace Tests\Feature;

use App\Http\Controllers\SuperAdminBendaharaController;
use App\Models\Bendahara;
use App\Models\Kelas;
use App\Models\User;
use App\Models\WaliKelas;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SuperAdminBendaharaIndexTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('role')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });

        Schema::create('wali_kelas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nama');
            $table->string('nip')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('alamat')->nullable();
            $table->timestamps();
        });

        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas');
            $table->string('kode_kelas');
            $table->string('tahun_ajaran')->nullable();
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('id_wali_kelas')->nullable();
            $table->string('tipe_periode')->default('Bulanan');
            $table->decimal('nominal_standar', 12, 2)->nullable();
            $table->unsignedTinyInteger('bulan_mulai')->nullable();
            $table->unsignedTinyInteger('bulan_akhir')->nullable();
            $table->string('status')->default('aktif');
            $table->timestamps();
        });

        Schema::create('bendahara', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('kelas_id')->nullable();
            $table->string('nama');
            $table->string('nis')->nullable();
            $table->string('no_hp')->nullable();
            $table->timestamps();
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bendahara_id')->nullable();
            $table->string('type');
            $table->decimal('amount', 12, 2)->default(0);
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('bendahara');
        Schema::dropIfExists('kelas');
        Schema::dropIfExists('wali_kelas');
        Schema::dropIfExists('users');

        parent::tearDown();
    }

    public function test_bendahara_list_supports_search_and_ten_row_pagination(): void
    {
        $user = User::create([
            'name' => 'Bendahara Utama',
            'email' => 'bendahara@example.test',
            'password' => 'secret',
            'status' => 'aktif',
        ]);
        $wali = WaliKelas::create([
            'nama' => 'Wali Uji',
        ]);
        $kelas = Kelas::create([
            'nama_kelas' => 'XII RPL 1',
            'kode_kelas' => 'XII-RPL-1',
            'id_wali_kelas' => $wali->id,
        ]);
        Bendahara::create([
            'nama' => 'Bendahara Utama',
            'nis' => '123456',
            'no_hp' => '081234567890',
            'user_id' => $user->id,
            'kelas_id' => $kelas->id,
        ]);

        for ($index = 1; $index <= 10; $index++) {
            Bendahara::create([
                'nama' => 'Bendahara Lain ' . $index,
                'nis' => '20000' . $index,
            ]);
        }

        $controller = new SuperAdminBendaharaController();
        $allView = $controller->index(Request::create('/super-admin/bendahara', 'GET'));
        $allRows = $allView->getData()['bendahara'];

        $this->assertSame(11, $allRows->total());
        $this->assertCount(10, $allRows->items());

        $searchView = $controller->index(
            Request::create('/super-admin/bendahara?search=XII+RPL+1', 'GET')
        );

        $this->assertSame(1, $searchView->getData()['bendahara']->total());
        $matchingBendahara = $searchView->getData()['bendahara']->first();
        $this->assertSame('XII RPL 1', $matchingBendahara->kelas->nama_kelas);
        $this->assertTrue($matchingBendahara->kelas->relationLoaded('waliKelas'));
    }
}
