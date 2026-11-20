<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Notification;
use App\Models\AnnouncementRecipient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Gabungkan notifikasi sistem dengan pengumuman yang ditujukan ke siswa.
        $systemNotifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get()
            ->map(function (Notification $notification) {
                return (object) [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at,
                    'is_announcement' => false,
                    'priority' => null,
                    'priority_label' => null,
                ];
            });

        $announcementNotifications = DB::table('pengumuman_penerima')
            ->join(
                'pengumuman',
                'pengumuman.id',
                '=',
                'pengumuman_penerima.pengumuman_id'
            )
            ->where('pengumuman_penerima.user_id', auth()->id())
            ->orderByDesc('pengumuman_penerima.created_at')
            ->take(5)
            ->get([
                'pengumuman_penerima.id as id',
                'pengumuman_penerima.dibaca_at as read_at',
                'pengumuman_penerima.created_at as created_at',
                'pengumuman.judul as title',
                'pengumuman.isi as message',
                'pengumuman.prioritas as priority',
            ])
            ->map(function ($announcement) {
                $priority = $announcement->priority ?? 'normal';

                return (object) [
                    'id' => $announcement->id,
                    'type' => 'pengumuman',
                    'title' => $announcement->title,
                    'message' => $announcement->message,
                    'read_at' => $announcement->read_at,
                    'created_at' => Carbon::parse($announcement->created_at),
                    'is_announcement' => true,
                    'priority' => $priority,
                    'priority_label' => [
                        'normal' => 'Normal',
                        'important' => 'Penting',
                        'urgent' => 'Mendesak',
                    ][$priority] ?? 'Normal',
                ];
            });

        $notifications = $systemNotifications
            ->concat($announcementNotifications)
            ->sortByDesc('created_at')
            ->take(5)
            ->values();

        $unreadAnnouncements = DB::table('pengumuman_penerima')
            ->where('user_id', auth()->id())
            ->whereNull('dibaca_at')
            ->count();

        return view('siswa.dashboard', compact(
            'totalPemasukan',
            'totalPengeluaran',
            'totalSaldo',
            'transactions',
            'notifications',
            'unreadAnnouncements'
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

        return redirect()->to(route('siswa.dashboard') . '#notifikasi');
    }

    public function markAnnouncementAsRead(Request $request, $id)
    {
        $recipient = AnnouncementRecipient::where(
            'user_id',
            auth()->id()
        )->findOrFail($id);

        $recipient->update([
            'dibaca_at' => now(),
        ]);

        return redirect()->to(route('siswa.dashboard') . '#notifikasi');
    }
}
