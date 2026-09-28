<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Student;
use App\Models\StudentPayment;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // =====================================================
        // FILTER BULAN & TAHUN
        // =====================================================

        $selectedMonth = $request->get('month', 'all');
        $selectedYear = (int) $request->get('year', now()->year);

        if ($selectedYear < 2020 || $selectedYear > 2100) {
            $selectedYear = now()->year;
        }

        // =====================================================
        // QUERY TRANSAKSI
        // =====================================================

        $transactionQuery = Transaction::query();

        if ($selectedMonth !== 'all') {
            $transactionQuery->whereMonth(
                'created_at',
                (int) $selectedMonth
            );
        }

        $transactionQuery->whereYear(
            'created_at',
            $selectedYear
        );

        // Ambil transaksi sesuai filter
        $transactions = $transactionQuery
            ->latest('created_at')
            ->get();

        // =====================================================
        // TOTAL PEMASUKAN
        // =====================================================

        $totalPemasukan = (clone $transactionQuery)
            ->where('type', 'in')
            ->sum('amount');

        // =====================================================
        // TOTAL PENGELUARAN
        // =====================================================

        $totalPengeluaran = (clone $transactionQuery)
            ->where('type', 'out')
            ->sum('amount');

        // =====================================================
        // SALDO BERSIH
        // =====================================================

        $totalSaldo = $totalPemasukan - $totalPengeluaran;

        // =====================================================
        // TOTAL TRANSAKSI
        // =====================================================

        $totalTransaksi = $transactions->count();

        // =====================================================
        // DATA SISWA
        // =====================================================

        $students = Student::orderBy('name', 'asc')
            ->get()
            ->keyBy('id');

        // =====================================================
        // DETAIL PEMBAYARAN KAS SISWA
        // =====================================================

        $transactionIds = $transactions
            ->pluck('id');

        $paymentDetails = StudentPayment::whereIn(
                'transaction_id',
                $transactionIds
            )
            ->orderBy('payment_month', 'asc')
            ->get()
            ->groupBy('transaction_id');

        // =====================================================
        // TOTAL KAS SISWA
        // =====================================================

        $paymentQuery = StudentPayment::query();

        if ($selectedMonth !== 'all') {
            $paymentQuery->whereMonth(
                'payment_month',
                (int) $selectedMonth
            );
        }

        $paymentQuery->whereYear(
            'payment_month',
            $selectedYear
        );

        $totalKasSiswa = $paymentQuery->sum('amount');

        // =====================================================
        // KIRIM DATA KE VIEW
        // =====================================================

        return view('laporan.index', [
            'transactions' => $transactions,

            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,

            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'totalSaldo' => $totalSaldo,
            'totalTransaksi' => $totalTransaksi,
            'totalKasSiswa' => $totalKasSiswa,

            // Dibutuhkan oleh Blade laporan
            'students' => $students,
            'paymentDetails' => $paymentDetails,
        ]);
    }
}