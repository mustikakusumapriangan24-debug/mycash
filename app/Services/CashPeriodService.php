<?php

namespace App\Services;

use App\Models\Kelas;
use App\Models\Student;
use App\Models\StudentPayment;
use App\Models\StudentWeeklyPayment;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class CashPeriodService
{
    public function settingForUser(User $user): ?Kelas
    {
        if ($user->hasRole('bendahara')) {
            return $user->bendahara?->kelas;
        }

        if ($user->hasRole('wali_kelas')) {
            return $user->waliKelas?->kelas()->first();
        }

        return null;
    }

    public function periodType(?Kelas $kelas): string
    {
        return $kelas?->tipe_periode === 'Mingguan'
            ? 'Mingguan'
            : 'Bulanan';
    }

    public function fee(?Kelas $kelas): ?int
    {
        if ($kelas?->nominal_standar === null || (float) $kelas->nominal_standar < 1) {
            return null;
        }

        return (int) round((float) $kelas->nominal_standar);
    }

    public function startMonth(?Kelas $kelas): int
    {
        return (int) ($kelas?->bulan_mulai ?? 7);
    }

    public function endMonth(?Kelas $kelas): int
    {
        return (int) ($kelas?->bulan_akhir ?? 6);
    }

    public function currentSchoolYear(?Kelas $kelas): int
    {
        return now()->month >= $this->startMonth($kelas)
            ? now()->year
            : now()->year - 1;
    }

    public function periods(?Kelas $kelas, int $schoolYear): array
    {
        $startMonth = $this->startMonth($kelas);
        $endMonth = $this->endMonth($kelas);
        $monthCount = (($endMonth - $startMonth + 12) % 12) + 1;
        $periods = [];

        for ($offset = 0; $offset < $monthCount; $offset++) {
            $monthNumber = (($startMonth - 1 + $offset) % 12) + 1;
            $year = $schoolYear + ($monthNumber < $startMonth ? 1 : 0);
            $monthDate = Carbon::create($year, $monthNumber, 1)->startOfMonth();

            if ($this->periodType($kelas) === 'Mingguan') {
                for ($weekInMonth = 1; $weekInMonth <= 4; $weekInMonth++) {
                    $weekNumber = ($offset * 4) + $weekInMonth;
                    $periods[] = [
                        'type' => 'weekly',
                        'key' => 'M' . $weekNumber,
                        'label' => 'M' . $weekNumber,
                        'month_label' => $monthDate->translatedFormat('F Y'),
                        'month_date' => $monthDate->copy(),
                        'week_number' => $weekNumber,
                        'school_year' => $schoolYear,
                    ];
                }

                continue;
            }

            $periods[] = [
                'type' => 'monthly',
                'key' => $monthDate->format('Y-m'),
                'label' => $monthDate->translatedFormat('M'),
                'month_label' => $monthDate->translatedFormat('F Y'),
                'month_date' => $monthDate,
                'week_number' => null,
                'school_year' => $schoolYear,
            ];
        }

        return $periods;
    }

    public function findPeriodIndex(
        array $periods,
        string $periodType,
        ?string $month,
        ?int $weekNumber
    ): ?int {
        foreach ($periods as $index => $period) {
            if ($periodType === 'Mingguan' && $period['week_number'] === $weekNumber) {
                return $index;
            }

            if ($periodType === 'Bulanan' && $period['key'] === $month) {
                return $index;
            }
        }

        return null;
    }

    public function allocate(
        Transaction $transaction,
        int $studentId,
        array $periods,
        int $startIndex,
        string $periodType,
        int $fee,
        float $amount
    ): array {
        $remaining = $amount;
        $allocations = [];

        for ($index = $startIndex; $index < count($periods) && $remaining > 0; $index++) {
            $period = $periods[$index];

            if ($periodType === 'Mingguan') {
                $payment = StudentWeeklyPayment::query()
                    ->where('student_id', $studentId)
                    ->where('school_year', $period['school_year'])
                    ->where('week_number', $period['week_number'])
                    ->lockForUpdate()
                    ->first();

                if (!$payment) {
                    $payment = new StudentWeeklyPayment([
                        'student_id' => $studentId,
                        'school_year' => $period['school_year'],
                        'week_number' => $period['week_number'],
                        'amount' => 0,
                    ]);
                }
            } else {
                $payment = StudentPayment::query()
                    ->where('student_id', $studentId)
                    ->whereDate('payment_month', $period['month_date']->format('Y-m-d'))
                    ->lockForUpdate()
                    ->first();

                if (!$payment) {
                    $payment = new StudentPayment([
                        'student_id' => $studentId,
                        'payment_month' => $period['month_date']->format('Y-m-d'),
                        'amount' => 0,
                    ]);
                }
            }

            $currentAmount = (float) $payment->amount;
            if ($currentAmount >= $fee) {
                continue;
            }

            $allocation = min($remaining, $fee - $currentAmount);
            $payment->transaction_id = $transaction->id;
            $payment->amount = $currentAmount + $allocation;
            $payment->paid_at = now();
            $payment->save();
            $remaining -= $allocation;
            $allocations[] = [
                'paid' => (float) $payment->amount >= $fee,
            ];
        }

        if ($remaining > 0) {
            throw ValidationException::withMessages([
                'amount' => 'Nominal melebihi sisa tagihan dalam rentang periode kas yang aktif.',
            ]);
        }

        return [
            'period_count' => count($allocations),
            'fully_paid_count' => count(array_filter(
                $allocations,
                fn (array $allocation) => $allocation['paid']
            )),
        ];
    }

    public function buildChecklist(
        Collection $students,
        ?Kelas $kelas,
        int $schoolYear
    ): Collection {
        $periods = $this->periods($kelas, $schoolYear);
        $studentIds = $students->pluck('id');
        $periodType = $this->periodType($kelas);
        $fee = $this->fee($kelas);

        if ($periodType === 'Mingguan') {
            $payments = StudentWeeklyPayment::query()
                ->whereIn('student_id', $studentIds)
                ->where('school_year', $schoolYear)
                ->whereIn('week_number', collect($periods)->pluck('week_number'))
                ->get()
                ->groupBy('student_id');
        } else {
            $periodDates = collect($periods)
                ->map(fn (array $period) => $period['month_date']->format('Y-m-d'));
            $payments = StudentPayment::query()
                ->whereIn('student_id', $studentIds)
                ->whereIn('payment_month', $periodDates)
                ->get()
                ->groupBy('student_id');
        }

        return $students->map(function (Student $student) use (
            $payments,
            $periods,
            $periodType,
            $fee
        ) {
            $studentPayments = $payments->get($student->id, collect());
            $periodRows = [];

            foreach ($periods as $period) {
                $payment = $studentPayments->first(function ($item) use (
                    $period,
                    $periodType
                ) {
                    if ($periodType === 'Mingguan') {
                        return (int) $item->week_number === $period['week_number'];
                    }

                    return Carbon::parse($item->payment_month)->format('Y-m')
                        === $period['key'];
                });

                $amount = (float) ($payment?->amount ?? 0);
                $periodRows[] = [
                    'label' => $period['label'],
                    'month_label' => $period['month_label'],
                    'amount' => $amount,
                    'paid' => $fee !== null && $amount >= $fee,
                    'period' => $period,
                ];
            }

            return [
                'student' => $student,
                'periods' => $periodRows,
                'total' => collect($periodRows)->sum('amount'),
            ];
        });
    }
}
