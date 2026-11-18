<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TransactionExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize
{
    protected Collection $transactions;

    public function __construct(Collection $transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection(): Collection
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Tipe',
            'Kategori',
            'Keterangan',
            'Jumlah',
        ];
    }

    public function map($transaction): array
    {
        $tipe = $transaction->type === 'in'
            ? 'Pemasukan'
            : ($transaction->type === 'out'
                ? 'Pengeluaran'
                : $transaction->type);

        return [
            $transaction->created_at
                ? $transaction->created_at->format('d/m/Y')
                : '-',

            $tipe,

            $transaction->getAttribute('category')
                ?? $transaction->getAttribute('kategori')
                ?? '-',

            $transaction->getAttribute('description')
                ?? $transaction->getAttribute('keterangan')
                ?? $transaction->getAttribute('note')
                ?? '-',

            (float) $transaction->amount,
        ];
    }
}
