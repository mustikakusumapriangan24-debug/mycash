<?php

namespace Tests\Feature;

use App\Http\Controllers\SuperAdminKelasController;
use App\Models\Bendahara;
use App\Models\Kelas;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ViewErrorBag;
use Tests\TestCase;

class ClassStudentAssignmentTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

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

        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('kelas_id')->nullable();
            $table->string('nis')->nullable();
            $table->string('name');
            $table->string('gender')->default('L');
            $table->string('phone')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

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
            $table->decimal('amount', 12, 2);
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Auth::forgetGuards();
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('bendahara');
        Schema::dropIfExists('wali_kelas');
        Schema::dropIfExists('users');
        Schema::dropIfExists('students');
        Schema::dropIfExists('kelas');

        parent::tearDown();
    }

    public function test_super_admin_can_assign_and_release_a_student_from_a_class(): void
    {
        $kelas = Kelas::create([
            'nama_kelas' => 'XII RPL 1',
            'kode_kelas' => 'XII-RPL-1',
            'tahun_ajaran' => '2026/2027',
        ]);
        $student = Student::create([
            'name' => 'Siswa Uji',
            'nis' => '12345',
            'gender' => 'P',
        ]);
        $controller = new SuperAdminKelasController();

        $controller->assignStudent(
            Request::create('/super-admin/kelas/' . $kelas->id . '/siswa', 'POST', [
                'student_id' => $student->id,
            ]),
            $kelas->id
        );

        $this->assertSame($kelas->id, $student->fresh()->kelas_id);
        $this->assertSame(1, $kelas->students()->count());

        $controller->removeStudent(
            Request::create('/super-admin/kelas/' . $kelas->id . '/siswa/' . $student->id, 'DELETE'),
            $kelas->id,
            $student->id
        );

        $this->assertNull($student->fresh()->kelas_id);
        $this->assertSame(0, $kelas->students()->count());
    }

    public function test_class_detail_uses_class_students_and_cashier_transactions_for_its_summary(): void
    {
        $kelas = Kelas::create([
            'nama_kelas' => 'XII RPL 1',
            'kode_kelas' => 'XII-RPL-1',
            'tahun_ajaran' => '2026/2027',
        ]);
        Student::create(['name' => 'Siswa Laki-laki', 'gender' => 'L', 'kelas_id' => $kelas->id]);
        Student::create(['name' => 'Siswa Perempuan', 'gender' => 'P', 'kelas_id' => $kelas->id]);
        $bendahara = Bendahara::create([
            'nama' => 'Bendahara Uji',
            'kelas_id' => $kelas->id,
        ]);
        Transaction::create([
            'bendahara_id' => $bendahara->id,
            'type' => 'in',
            'amount' => 120000,
        ]);
        Transaction::create([
            'bendahara_id' => $bendahara->id,
            'type' => 'out',
            'amount' => 32000,
        ]);
        Auth::setUser(new User(['name' => 'Administrator']));

        $view = (new SuperAdminKelasController())->show(
            Request::create('/super-admin/kelas/' . $kelas->id),
            $kelas->id
        );
        view()->share('errors', new ViewErrorBag());
        $html = $view->render();

        $this->assertStringContainsString('2 <small style="font-size:10px;font-weight:600">Siswa</small>', $html);
        $this->assertStringContainsString('Siswa Laki-laki', $html);
        $this->assertStringContainsString('Siswa Perempuan', $html);
        $this->assertStringContainsString('Rp 120.000', $html);
        $this->assertStringContainsString('Rp 32.000', $html);
        $this->assertStringContainsString('Bendahara Uji', $html);
        $this->assertStringContainsString('Belum ditentukan', $html);
        $this->assertStringNotContainsString('Rp 10.000', $html);
    }
}
