<?php

namespace App\Services;

use App\Models\Bendahara;
use App\Models\LogTransaksiKas;
use App\Models\StudentPayment;
use App\Models\Transaction;
use App\Models\User;

class TransactionAuditLogger
{
    public function snapshot(Transaction $transaction): array
    {
        $allocations = StudentPayment::query()
            ->with('student')
            ->where('transaction_id', $transaction->id)
            ->orderBy('payment_month')
            ->get()
            ->map(function (StudentPayment $payment) {
                return [
                    'siswa' => $payment->student->name ?? '-',
                    'nis' => $payment->student->nis ?? '-',
                    'bulan' => $payment->payment_month?->format('F Y'),
                    'nominal' => number_format(
                        (float) $payment->amount,
                        0,
                        ',',
                        '.'
                    ),
                ];
            })
            ->values()
            ->all();
        $weeklyAllocations = $transaction->weeklyPayments()
            ->with('student')
            ->orderBy('school_year')
            ->orderBy('week_number')
            ->get()
            ->map(function ($payment) {
                return [
                    'siswa' => $payment->student->name ?? '-',
                    'nis' => $payment->student->nis ?? '-',
                    'tahun_ajaran' => $payment->school_year,
                    'minggu' => 'M' . $payment->week_number,
                    'nominal' => number_format(
                        (float) $payment->amount,
                        0,
                        ',',
                        '.'
                    ),
                ];
            })
            ->values()
            ->all();

        return [
            'no_transaksi' => $this->receiptNumber($transaction->id),
            'jenis' => $transaction->type === 'in'
                ? 'Pemasukan'
                : 'Pengeluaran',
            'kategori' => $transaction->category ?? '-',
            'nominal' => number_format(
                (float) $transaction->amount,
                0,
                ',',
                '.'
            ),
            'keterangan' => $transaction->description ?? '-',
            'bukti' => $transaction->receipt_path ?? '-',
            'alokasi_pembayaran' => $allocations,
            'alokasi_mingguan' => $weeklyAllocations,
        ];
    }

    public function record(
        User $actor,
        Transaction $transaction,
        string $activity,
        array $oldData,
        ?array $newData,
        string $description
    ): void {
        $kelasId = $transaction->bendahara_id
            ? Bendahara::query()
                ->whereKey($transaction->bendahara_id)
                ->value('kelas_id')
            : null;

        $kelasId = $kelasId ?? $actor->bendahara?->kelas_id;

        LogTransaksiKas::create([
            'transaksi_kas_id' => $transaction->id,
            'no_nota' => $this->receiptNumber($transaction->id),
            'kelas_id' => $kelasId,
            'user_id' => $actor->id,
            'aktivitas' => $activity,
            'data_lama' => $oldData,
            'data_baru' => $newData,
            'keterangan' => $description,
            'ip_address' => request()->ip(),
        ]);
    }

    private function receiptNumber(int $transactionId): string
    {
        return 'TRX-' . str_pad(
            (string) $transactionId,
            6,
            '0',
            STR_PAD_LEFT
        );
    }
}
