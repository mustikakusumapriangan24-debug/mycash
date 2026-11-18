<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // Menyimpan transaksi baru (Pemasukan / Pengeluaran)
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:in,out',
            'amount' => 'required|numeric',
            'category' => 'required_if:type,in|nullable|string|in:Kas Siswa,Lainnya',
            'description' => 'nullable|string',
        ]);

        Transaction::create([
            'type' => $request->type,
            'amount' => $request->amount,
            'category' => $request->type === 'out'
                ? null
                : $request->category,
            'description' => $request->description,
        ]);

        return redirect()->back()->with(
            'success',
            'Transaksi berhasil ditambahkan!'
        );
    }
}
