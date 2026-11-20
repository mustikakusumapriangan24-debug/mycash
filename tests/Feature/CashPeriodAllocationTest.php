<?php

namespace Tests\Feature;

use App\Models\Kelas;
use App\Models\Student;
use App\Models\StudentWeeklyPayment;
use App\Models\Transaction;
use App\Services\CashPeriodService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CashPeriodAllocationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->nullable();
            $table->string('name');
            $table->string('gender')->default('L');
            $table->string('phone')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bendahara_id')->nullable();
            $table->string('type');
            $table->decimal('amount', 12, 2);
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->string('receipt_path')->nullable();
            $table->timestamps();
        });

        Schema::create('student_weekly_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->unsignedSmallInteger('school_year');
            $table->unsignedTinyInteger('week_number');
            $table->decimal('amount', 12, 2)->default(0);
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->unique(
                ['student_id', 'school_year', 'week_number'],
                'student_weekly_payment_period_unique'
            );
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('student_weekly_payments');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('students');

        parent::tearDown();
    }

    public function test_weekly_payment_amount_is_distributed_across_active_periods(): void
    {
        $student = Student::create(['name' => 'Test Student']);
        $transaction = Transaction::create([
            'type' => 'in',
            'amount' => 12000,
            'category' => 'Kas Siswa',
            'description' => 'Pembayaran kas siswa',
        ]);
        $kelas = new Kelas([
            'tipe_periode' => 'Mingguan',
            'nominal_standar' => 10000,
            'bulan_mulai' => 7,
            'bulan_akhir' => 6,
        ]);
        $service = new CashPeriodService();

        $summary = $service->allocate(
            $transaction,
            $student->id,
            $service->periods($kelas, 2026),
            0,
            'Mingguan',
            10000,
            12000
        );

        $payments = StudentWeeklyPayment::query()
            ->where('student_id', $student->id)
            ->orderBy('week_number')
            ->get();
        $checklist = $service
            ->buildChecklist(collect([$student]), $kelas, 2026)
            ->first();

        $this->assertSame([10000.0, 2000.0], $payments
            ->map(fn (StudentWeeklyPayment $payment) => (float) $payment->amount)
            ->all());
        $this->assertSame(1, $summary['fully_paid_count']);
        $this->assertTrue($checklist['periods'][0]['paid']);
        $this->assertFalse($checklist['periods'][1]['paid']);
        $this->assertSame(2000.0, $checklist['periods'][1]['amount']);
    }
}
