<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Notification;
use Illuminate\Http\Request;

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

        // Ambil notifikasi milik siswa yang sedang login
        $notifications = Notification::where(
            'user_id',
            auth()->id()
        )
            ->latest()
            ->take(5)
            ->get();

        // Hitung jumlah notifikasi yang belum dibaca
        $unreadNotifications = Notification::where(
            'user_id',
            auth()->id()
        )
            ->whereNull('read_at')
            ->count();

        return view('siswa.dashboard', compact(
            'totalPemasukan',
            'totalPengeluaran',
            'totalSaldo',
            'transactions',
            'notifications',
            'unreadNotifications'
        ));
    }

    /**
     * Menandai notifikasi sebagai sudah dibaca.
     */
    public function markNotificationAsRead(Request $request, $id)
    {
        $notification = Notification::where(
            'user_id',
            auth()->id()
        )->findOrFail($id);

        // Tandai sudah dibaca
        $notification->update([
            'read_at' => now(),
        ]);

        return redirect()->back();
    }
}
