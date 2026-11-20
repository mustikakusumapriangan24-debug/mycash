<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\TransactionAuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function __construct(
        private readonly TransactionAuditLogger $auditLogger
    ) {
    }

    // Menyimpan transaksi baru (Pemasukan / Pengeluaran)
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:in,out',
            'amount' => 'required|numeric|min:1',
            'category' => 'required_if:type,in|nullable|string|in:Kas Siswa,Lainnya',
            'description' => 'nullable|string',
        ]);

        $bendahara = $request->user()->bendahara;

        if (!$bendahara) {
            return redirect()->back()->with(
                'error',
                'Data Bendahara tidak ditemukan. Transaksi tidak dapat disimpan.'
            );
        }

        $actor = $request->user();
        DB::transaction(function () use ($request, $bendahara, $actor) {
            $transaction = Transaction::create([
                'bendahara_id' => $bendahara->id,
                'type' => $request->type,
                'amount' => $request->amount,
                'category' => $request->type === 'out'
                    ? null
                    : $request->category,
                'description' => $request->description,
            ]);

            $this->auditLogger->record(
                $actor,
                $transaction,
                'tambah',
                [],
                $this->auditLogger->snapshot($transaction),
                'Transaksi kas ditambahkan.'
            );
        });

        return redirect()->back()->with(
            'success',
            'Transaksi berhasil ditambahkan!'
        );
    }
}
