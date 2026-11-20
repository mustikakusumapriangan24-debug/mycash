<?php

namespace Tests\Unit;

use App\Models\Kelas;
use App\Services\CashPeriodService;
use PHPUnit\Framework\TestCase;

class CashPeriodServiceTest extends TestCase
{
    public function test_fee_is_unset_until_a_class_fee_is_configured(): void
    {
        $service = new CashPeriodService();

        $this->assertNull($service->fee(new Kelas()));
        $this->assertSame(
            5000,
            $service->fee(new Kelas(['nominal_standar' => 5000]))
        );
    }

    public function test_monthly_periods_follow_the_configured_school_year_range(): void
    {
        $kelas = new Kelas([
            'tipe_periode' => 'Bulanan',
            'bulan_mulai' => 7,
            'bulan_akhir' => 6,
        ]);

        $periods = (new CashPeriodService())->periods($kelas, 2026);

        $this->assertCount(12, $periods);
        $this->assertSame('2026-07', $periods[0]['key']);
        $this->assertSame('2027-06', $periods[11]['key']);
    }

    public function test_weekly_periods_are_limited_to_four_per_configured_month(): void
    {
        $kelas = new Kelas([
            'tipe_periode' => 'Mingguan',
            'bulan_mulai' => 1,
            'bulan_akhir' => 3,
        ]);

        $periods = (new CashPeriodService())->periods($kelas, 2026);

        $this->assertCount(12, $periods);
        $this->assertSame('M1', $periods[0]['key']);
        $this->assertSame('M12', $periods[11]['key']);
        $this->assertSame(0, (new CashPeriodService())->findPeriodIndex(
            $periods,
            'Mingguan',
            null,
            1
        ));
        $this->assertNull((new CashPeriodService())->findPeriodIndex(
            $periods,
            'Mingguan',
            null,
            13
        ));
    }
}
