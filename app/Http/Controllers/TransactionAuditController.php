<?php

namespace App\Http\Controllers;

use App\Models\LogTransaksiKas;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionAuditController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $kelasIds = collect();

        if ($user->hasRole('bendahara')) {
            $kelasId = $user->bendahara?->kelas_id;
            if ($kelasId) {
                $kelasIds->push($kelasId);
            }
        } elseif ($user->hasRole('wali_kelas') && $user->waliKelas) {
            $kelasIds = $user->waliKelas->kelas()->pluck('kelas.id');
        }

        abort_if(
            $kelasIds->isEmpty(),
            403,
            'Akun ini belum terhubung dengan kelas.'
        );

        $activity = $request->query('aktivitas', 'all');
        if (!in_array($activity, ['all', 'tambah', 'edit', 'hapus', 'riwayat_lama'], true)) {
            $activity = 'all';
        }

        $search = trim((string) $request->query('search', ''));

        $query = LogTransaksiKas::query()
            ->with('user')
            ->whereIn('kelas_id', $kelasIds)
            ->latest();

        if ($activity === 'riwayat_lama') {
            $query->whereRaw('1 = 0');
        } elseif ($activity !== 'all') {
            $query->where('aktivitas', $activity);
        }

        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder->where('no_nota', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $logs = $query->paginate(15)->withQueryString();

        $legacyQuery = Transaction::query()
            ->with([
                'studentPayments.student',
                'weeklyPayments.student',
            ])
            ->whereHas('bendahara', function ($builder) use ($kelasIds) {
                $builder->whereIn('kelas_id', $kelasIds);
            })
            ->whereDoesntHave('auditLogs')
            ->latest();

        if ($activity !== 'all' && $activity !== 'riwayat_lama') {
            $legacyQuery->whereRaw('1 = 0');
        }

        if ($search !== '') {
            $transactionId = preg_replace('/\D+/', '', $search);
            $legacyQuery->where(function ($builder) use ($search, $transactionId) {
                $builder->where('description', 'like', "%{$search}%")
                    ->orWhere('amount', 'like', "%{$search}%");

                if ($transactionId !== '') {
                    $builder->orWhereKey((int) $transactionId);
                }

                $builder->orWhereHas('studentPayments.student', function ($studentQuery) use ($search) {
                    $studentQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('nis', 'like', "%{$search}%");
                });
                $builder->orWhereHas('weeklyPayments.student', function ($studentQuery) use ($search) {
                    $studentQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('nis', 'like', "%{$search}%");
                });
            });
        }

        $legacyTransactions = $legacyQuery
            ->paginate(10, ['*'], 'legacy_page')
            ->withQueryString();

        $layout = $user->hasRole('bendahara')
            ? 'layouts.bendahara'
            : 'layouts.wali-kelas';

        return view('transactions.audit', compact(
            'logs',
            'legacyTransactions',
            'activity',
            'search',
            'layout'
        ));
    }
}
