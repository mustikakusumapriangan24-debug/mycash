@extends($layout)

@section('title', 'Riwayat Log Transaksi - MyCash')

@section('content')
<style>
    .audit-page { width: 100%; color: #3E3D38; }
    .audit-header { margin-bottom: 22px; }
    .audit-eyebrow {
        margin-bottom: 7px;
        color: #B59A63;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1.6px;
        text-transform: uppercase;
    }
    .audit-title {
        margin: 0;
        color: #1F1D20;
        font-family: "Playfair Display", serif;
        font-size: 29px;
    }
    .audit-subtitle { margin-top: 7px; color: #756E69; font-size: 12px; }
    .audit-panel {
        overflow: hidden;
        border: 1px solid #DED6CC;
        border-radius: 15px;
        background: #FFFEFC;
        box-shadow: 0 10px 26px rgba(31, 29, 32, .04);
    }
    .audit-panel + .audit-panel { margin-top: 16px; }
    .audit-section-header {
        padding: 17px 18px;
        border-bottom: 1px solid #ECE5DD;
        background: #FCFAF6;
    }
    .audit-section-header h2 {
        margin: 0;
        color: #1F1D20;
        font-family: "Playfair Display", serif;
        font-size: 16px;
    }
    .audit-section-header p { margin-top: 5px; color: #756E69; font-size: 10px; }
    .audit-filter {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: end;
        padding: 16px 18px;
        border-bottom: 1px solid #ECE5DD;
        background: #FCFAF6;
    }
    .audit-filter label {
        display: block;
        margin-bottom: 5px;
        color: #756E69;
        font-size: 10px;
        font-weight: 700;
    }
    .audit-filter input,
    .audit-filter select {
        min-height: 36px;
        padding: 8px 10px;
        border: 1px solid #DED6CC;
        border-radius: 8px;
        background: #FFFEFC;
        color: #3E3D38;
        font: inherit;
        font-size: 11px;
    }
    .audit-search { flex: 1 1 230px; }
    .audit-filter select { min-width: 150px; }
    .audit-button {
        min-height: 36px;
        padding: 8px 13px;
        border: 1px solid #803E2F;
        border-radius: 8px;
        background: #803E2F;
        color: #fff;
        font: inherit;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
    }
    .audit-reset {
        display: inline-flex;
        min-height: 36px;
        align-items: center;
        padding: 8px 12px;
        border: 1px solid #DED6CC;
        border-radius: 8px;
        color: #756E69;
        font-size: 11px;
        text-decoration: none;
    }
    .audit-table-wrap { overflow-x: auto; }
    .audit-table { width: 100%; border-collapse: collapse; min-width: 850px; }
    .audit-table th {
        padding: 12px 14px;
        background: #F7F4EF;
        color: #756E69;
        font-size: 9px;
        letter-spacing: .5px;
        text-align: left;
        text-transform: uppercase;
    }
    .audit-table td {
        padding: 13px 14px;
        border-top: 1px solid #F0EBE5;
        color: #3E3D38;
        font-size: 10px;
        vertical-align: top;
    }
    .audit-date { white-space: nowrap; }
    .audit-actor { font-weight: 700; }
    .audit-badge {
        display: inline-flex;
        padding: 5px 8px;
        border-radius: 99px;
        font-size: 9px;
        font-weight: 800;
        white-space: nowrap;
    }
    .audit-badge.tambah { background: #EAF3EC; color: #3F7652; }
    .audit-badge.edit { background: #FFF3D9; color: #8A641D; }
    .audit-badge.hapus { background: #F9E8E5; color: #9B463A; }
    .audit-badge.riwayat_lama { background: #EEEAE4; color: #625B54; }
    .audit-details summary {
        color: #803E2F;
        font-weight: 800;
        cursor: pointer;
    }
    .audit-snapshots {
        display: grid;
        grid-template-columns: repeat(2, minmax(230px, 1fr));
        gap: 10px;
        margin-top: 10px;
    }
    .audit-snapshot {
        min-width: 0;
        padding: 10px;
        border: 1px solid #ECE5DD;
        border-radius: 8px;
        background: #FCFAF6;
    }
    .audit-snapshot strong { display: block; margin-bottom: 7px; font-size: 9px; }
    .audit-snapshot pre {
        overflow: auto;
        max-width: 100%;
        margin: 0;
        color: #5D5751;
        font-family: Consolas, monospace;
        font-size: 9px;
        line-height: 1.5;
        white-space: pre-wrap;
        overflow-wrap: anywhere;
    }
    .audit-ip { margin-top: 8px; color: #756E69; font-size: 9px; }
    .audit-empty { padding: 44px 20px; color: #756E69; text-align: center; }
    .audit-empty strong { display: block; margin-bottom: 6px; color: #3E3D38; font-size: 13px; }
    .audit-pagination { padding: 16px 18px; }
    .audit-pagination nav { display: flex; justify-content: flex-end; gap: 6px; }
    .audit-pagination a,
    .audit-pagination span {
        min-width: 30px;
        padding: 7px 9px;
        border: 1px solid #DED6CC;
        border-radius: 7px;
        color: #756E69;
        font-size: 10px;
        text-align: center;
        text-decoration: none;
    }
    .audit-pagination span[aria-current="page"] {
        border-color: #803E2F;
        background: #803E2F;
        color: #fff;
    }
    @media (max-width: 700px) {
        .audit-title { font-size: 24px; }
        .audit-snapshots { grid-template-columns: 1fr; }
    }
</style>

<div class="audit-page">
    <header class="audit-header">
        <p class="audit-eyebrow">Transparansi Kas Kelas</p>
        <h1 class="audit-title">Riwayat Log Transaksi</h1>
        <p class="audit-subtitle">Audit trail seluruh perubahan data transaksi kas kelas secara transparan.</p>
    </header>

    <section class="audit-panel">
        <form class="audit-filter" method="GET" action="{{ route('transactions.audit') }}">
            <div class="audit-search">
                <label for="auditSearch">Cari transaksi atau petugas</label>
                <input
                    id="auditSearch"
                    type="search"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Nomor transaksi, keterangan, nama petugas"
                >
            </div>
            <div>
                <label for="auditActivity">Aktivitas</label>
                <select id="auditActivity" name="aktivitas">
                    <option value="all" @selected($activity === 'all')>Semua aktivitas</option>
                    <option value="tambah" @selected($activity === 'tambah')>Ditambahkan</option>
                    <option value="edit" @selected($activity === 'edit')>Diperbarui</option>
                    <option value="hapus" @selected($activity === 'hapus')>Dihapus</option>
                    <option value="riwayat_lama" @selected($activity === 'riwayat_lama')>Riwayat awal</option>
                </select>
            </div>
            <button type="submit" class="audit-button">
                <i class="fa-solid fa-magnifying-glass"></i> Terapkan
            </button>
            @if($search !== '' || $activity !== 'all')
                <a class="audit-reset" href="{{ route('transactions.audit') }}">Reset</a>
            @endif
        </form>

        @if($logs->count())
            <div class="audit-table-wrap">
                <table class="audit-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Waktu</th>
                            <th>Petugas</th>
                            <th>Aktivitas</th>
                            <th>No. Transaksi</th>
                            <th>Perubahan</th>
                            <th>Data Tercatat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $index => $log)
                            @php
                                $activityLabels = [
                                    'tambah' => 'Ditambahkan',
                                    'edit' => 'Diperbarui',
                                    'hapus' => 'Dihapus',
                                ];
                            @endphp
                            <tr>
                                <td>{{ ($logs->firstItem() ?? 1) + $index }}</td>
                                <td class="audit-date">{{ $log->created_at?->format('d M Y, H:i:s') ?? '-' }}</td>
                                <td class="audit-actor">{{ $log->user->name ?? 'Akun dihapus' }}</td>
                                <td>
                                    <span class="audit-badge {{ $log->aktivitas }}">
                                        {{ $activityLabels[$log->aktivitas] ?? $log->aktivitas }}
                                    </span>
                                </td>
                                <td>{{ $log->no_nota }}</td>
                                <td>{{ $log->keterangan ?? '-' }}</td>
                                <td>
                                    <details class="audit-details">
                                        <summary>Lihat data</summary>
                                        <div class="audit-snapshots">
                                            @if(!empty($log->data_lama))
                                                <div class="audit-snapshot">
                                                    <strong>Data sebelum</strong>
                                                    <pre>{{ json_encode($log->data_lama, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) }}</pre>
                                                </div>
                                            @endif
                                            @if(!empty($log->data_baru))
                                                <div class="audit-snapshot">
                                                    <strong>Data sesudah</strong>
                                                    <pre>{{ json_encode($log->data_baru, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) }}</pre>
                                                </div>
                                            @endif
                                        </div>
                                        <p class="audit-ip">Alamat IP: {{ $log->ip_address ?? '-' }}</p>
                                    </details>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($logs->hasPages())
                <div class="audit-pagination">{{ $logs->links() }}</div>
            @endif
        @else
            <div class="audit-empty">
                <strong>Belum ada log perubahan yang tercatat</strong>
                <p>Aktivitas perubahan yang baru akan muncul setelah transaksi ditambah, diperbarui, atau dihapus.</p>
            </div>
        @endif
    </section>

    @if(in_array($activity, ['all', 'riwayat_lama'], true))
        <section class="audit-panel">
            <header class="audit-section-header">
                <h2>Riwayat Awal Transaksi Lama</h2>
                <p>Transaksi yang sudah ada sebelum fitur audit aktif. Data yang ditampilkan adalah data tersimpan saat ini; riwayat edit/hapus sebelumnya tidak tersedia.</p>
            </header>

            @if($legacyTransactions->count())
                <div class="audit-table-wrap">
                    <table class="audit-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Waktu Transaksi</th>
                                <th>Petugas</th>
                                <th>Status Riwayat</th>
                                <th>No. Transaksi</th>
                                <th>Keterangan</th>
                                <th>Data Tersimpan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($legacyTransactions as $index => $transaction)
                                @php
                                    $legacyData = [
                                        'jenis' => $transaction->type === 'in' ? 'Pemasukan' : 'Pengeluaran',
                                        'kategori' => $transaction->category ?? '-',
                                        'nominal' => 'Rp ' . number_format((float) $transaction->amount, 0, ',', '.'),
                                        'keterangan' => $transaction->description ?? '-',
                                        'bukti' => $transaction->receipt_path ?? '-',
                                        'alokasi_pembayaran' => $transaction->studentPayments
                                            ->map(function ($payment) {
                                                return [
                                                    'siswa' => $payment->student->name ?? '-',
                                                    'nis' => $payment->student->nis ?? '-',
                                                    'bulan' => $payment->payment_month?->format('F Y'),
                                                    'nominal' => number_format((float) $payment->amount, 0, ',', '.'),
                                                ];
                                            })
                                            ->values()
                                            ->all(),
                                        'alokasi_mingguan' => $transaction->weeklyPayments
                                            ->map(function ($payment) {
                                                return [
                                                    'siswa' => $payment->student->name ?? '-',
                                                    'nis' => $payment->student->nis ?? '-',
                                                    'tahun_ajaran' => $payment->school_year,
                                                    'minggu' => 'M' . $payment->week_number,
                                                    'nominal' => number_format((float) $payment->amount, 0, ',', '.'),
                                                ];
                                            })
                                            ->values()
                                            ->all(),
                                    ];
                                @endphp
                                <tr>
                                    <td>{{ ($legacyTransactions->firstItem() ?? 1) + $index }}</td>
                                    <td class="audit-date">{{ $transaction->created_at?->format('d M Y, H:i:s') ?? '-' }}</td>
                                    <td>Tidak tercatat pada log lama</td>
                                    <td><span class="audit-badge riwayat_lama">Riwayat awal</span></td>
                                    <td>TRX-{{ str_pad((string) $transaction->id, 6, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $transaction->description ?? '-' }}</td>
                                    <td>
                                        <details class="audit-details">
                                            <summary>Lihat data tersimpan</summary>
                                            <div class="audit-snapshots">
                                                <div class="audit-snapshot">
                                                    <strong>Data saat ini (bukan riwayat perubahan)</strong>
                                                    <pre>{{ json_encode($legacyData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) }}</pre>
                                                </div>
                                            </div>
                                            <p class="audit-ip">Petugas dan perubahan sebelum audit aktif tidak tercatat.</p>
                                        </details>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($legacyTransactions->hasPages())
                    <div class="audit-pagination">{{ $legacyTransactions->links() }}</div>
                @endif
            @else
                <div class="audit-empty">
                    <strong>Tidak ada transaksi lama untuk filter ini</strong>
                    <p>Transaksi lama yang dapat dihubungkan dengan kelas akan ditampilkan di sini.</p>
                </div>
            @endif
        </section>
    @endif
</div>
@endsection
