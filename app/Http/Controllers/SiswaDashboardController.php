<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class SiswaDashboardController extends Controller
{
    public function index()
    {
        // Total pemasukan kas kelas
        $totalPemasukan = Transaction::where('type', 'in')
            ->sum('amount');

        // Total pengeluaran kas kelas
        $totalPengeluaran = Transaction::where('type', 'out')
            ->sum('amount');

        // Saldo kas kelas
        $totalSaldo = $totalPemasukan - $totalPengeluaran;

        // Ambil 5 transaksi terbaru
        $transactions = Transaction::latest()
            ->take(5)
            ->get();

        return view('siswa.dashboard', compact(
            'totalPemasukan',
            'totalPengeluaran',
            'totalSaldo',
            'transactions'
        ));
    }
}