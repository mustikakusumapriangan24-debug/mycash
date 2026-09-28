<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Student;
use App\Models\StudentPayment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    private const MONTHLY_FEE = 10000;

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD BENDAHARA
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $totalPemasukan = Transaction::where('type', 'in')
            ->sum('amount');

        $totalPengeluaran = Transaction::where('type', 'out')
            ->sum('amount');

        $totalSaldo = $totalPemasukan - $totalPengeluaran;

        $transactions = Transaction::latest()->get();

        $expenseByCategory = Transaction::where('type', 'out')
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        return view('dashboard', compact(
            'totalPemasukan',
            'totalPengeluaran',
            'totalSaldo',
            'transactions',
            'expenseByCategory'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | PANTAU KAS WALI KELAS
    |--------------------------------------------------------------------------
    */

    public function waliKelasKas()
    {
        $totalPemasukan = Transaction::where('type', 'in')
            ->sum('amount');

        $totalPengeluaran = Transaction::where('type', 'out')
            ->sum('amount');

        $totalSaldo = $totalPemasukan - $totalPengeluaran;

        $transactions = Transaction::latest()
            ->get();

        return view(
            'wali-kelas.pantau-kas',
            compact(
                'totalPemasukan',
                'totalPengeluaran',
                'totalSaldo',
                'transactions'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STATUS PEMBAYARAN KAS
    |--------------------------------------------------------------------------
    */

    public function paymentStatus()
    {
        $selectedYear = request()->get(
            'year',
            now()->year
        );

        $selectedYear = (int) $selectedYear;

        if (
            $selectedYear < 2020 ||
            $selectedYear > 2100
        ) {
            $selectedYear = now()->year;
        }

        $students = Student::orderBy(
            'name',
            'asc'
        )->get();

        $payments = StudentPayment::whereIn(
            'student_id',
            $students->pluck('id')
        )
        ->whereYear(
            'payment_month',
            $selectedYear
        )
        ->get()
        ->groupBy('student_id');

        $studentPayments = $students->map(
            function ($student) use (
                $payments,
                $selectedYear
            ) {
                $paymentData = $payments->get(
                    $student->id,
                    collect()
                );

                $months = [];

                for (
                    $i = 1;
                    $i <= 12;
                    $i++
                ) {
                    $month = Carbon::create(
                        $selectedYear,
                        $i,
                        1
                    );

                    $payment = $paymentData->first(
                        function ($item) use ($month) {
                            return Carbon::parse(
                                $item->payment_month
                            )->format('Y-m') ===
                            $month->format('Y-m');
                        }
                    );

                    $amount = $payment
                        ? (float) $payment->amount
                        : 0;

                    $months[] = [
                        'month' =>
                            $month->format('Y-m-d'),

                        'label' =>
                            $month->translatedFormat('M'),

                        'amount' =>
                            $amount,

                        'paid' =>
                            $amount >=
                            self::MONTHLY_FEE,
                    ];
                }

                return [
                    'student' =>
                        $student,

                    'months' =>
                        $months,

                    'total' =>
                        collect($months)->sum(
                            'amount'
                        ),
                ];
            }
        );

        return view(
            'status-pembayaran',
            [
                'students' =>
                    $students,

                'studentPayments' =>
                    $studentPayments,

                'selectedYear' =>
                    $selectedYear,

                'monthlyFee' =>
                    self::MONTHLY_FEE,
            ]
        );
    }
}

