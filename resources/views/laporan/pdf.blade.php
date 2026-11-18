
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan MyCash</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #3E3D38;
        }

        h1 {
            color: #54251F;
            text-align: center;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            margin-bottom: 20px;
        }

        .summary {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .summary td {
            border: 1px solid #D9CBA7;
            padding: 10px;
            width: 25%;
        }

        .summary strong {
            display: block;
            color: #54251F;
            margin-top: 5px;
        }

        table.transactions {
            width: 100%;
            border-collapse: collapse;
        }

        .transactions th {
            background: #54251F;
            color: white;
            padding: 8px;
        }

        .transactions td {
            border: 1px solid #DDD5C8;
            padding: 7px;
        }

        .amount {
            text-align: right;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            color: #777;
        }
    </style>
</head>

<body>
    <h1>MYCASH</h1>

    <div class="subtitle">
        Laporan Keuangan Kelas<br>
        Periode: {{ $selectedMonthName }} {{ $selectedYear }}
    </div>

    <table class="summary">
        <tr>
            <td>
                Total Pemasukan
                <strong>
                    Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                </strong>
            </td>

            <td>
                Total Pengeluaran
                <strong>
                    Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                </strong>
            </td>

            <td>
                Saldo Bersih
                <strong>
                    Rp {{ number_format($totalSaldo, 0, ',', '.') }}
                </strong>
            </td>

            <td>
                Total Kas Siswa
                <strong>
                    Rp {{ number_format($totalKasSiswa, 0, ',', '.') }}
                </strong>
            </td>
        </tr>
    </table>

    <p>
        Jumlah transaksi: {{ $totalTransaksi }}
    </p>

    <table class="transactions">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Tipe</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th>Jumlah</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($transactions as $transaction)
                <tr>
                    <td>
                        {{ $transaction->created_at
                            ? $transaction->created_at->format('d/m/Y')
                            : '-' }}
                    </td>

                    <td>
                        @if ($transaction->type === 'in')
                            Pemasukan
                        @elseif ($transaction->type === 'out')
                            Pengeluaran
                        @else
                            {{ $transaction->type }}
                        @endif
                    </td>

                    <td>
                        {{ $transaction->getAttribute('category')
                            ?? $transaction->getAttribute('kategori')
                            ?? '-' }}
                    </td>

                    <td>
                        {{ $transaction->getAttribute('description')
                            ?? $transaction->getAttribute('keterangan')
                            ?? $transaction->getAttribute('note')
                            ?? '-' }}
                    </td>

                    <td class="amount">
                        Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;">
                        Belum ada transaksi pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
