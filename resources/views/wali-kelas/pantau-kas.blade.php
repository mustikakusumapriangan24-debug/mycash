@extends('layouts.wali-kelas')

@section('title', 'Pantau Kas - MyCash')

@section('content')

<style>
    .cash-page { width: 100%; }

    .cash-topbar {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 30px;
    }

    .cash-eyebrow {
        color: #B59A63;
        text-transform: uppercase;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1.8px;
        margin-bottom: 7px;
    }

    .cash-title {
        font-family: "Playfair Display", serif;
        color: #1F1D20;
        font-size: 30px;
        margin-bottom: 7px;
    }

    .cash-subtitle {
        color: #756E69;
        font-size: 12px;
    }

    .cash-date {
        background: #FFFEFC;
        border: 1px solid #DED6CC;
        border-radius: 12px;
        padding: 12px 16px;
        text-align: right;
    }

    .cash-date span {
        display: block;
        font-size: 9px;
        color: #756E69;
        margin-bottom: 4px;
    }

    .cash-date strong {
        font-size: 12px;
        color: #54251F;
    }

    /* STATISTICS */

    .cash-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-bottom: 24px;
    }

    .cash-stat {
        background: #FFFEFC;
        border: 1px solid #DED6CC;
        border-radius: 15px;
        padding: 21px;
        position: relative;
        overflow: hidden;
    }

    .cash-stat::after {
        content: "";
        position: absolute;
        right: -30px;
        bottom: -30px;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: rgba(181,154,99,.08);
    }

    .cash-stat-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .cash-stat-label {
        font-size: 11px;
        color: #756E69;
    }

    .cash-stat-icon {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: #F1ECE4;
        color: #803E2F;
    }

    .cash-stat-value {
        font-size: 24px;
        font-weight: 700;
        color: #1F1D20;
    }

    .cash-stat.balance {
        background: linear-gradient(135deg, #803E2F, #54251F);
        border: none;
    }

    .cash-stat.balance .cash-stat-label { color: #E7D9D1; }
    .cash-stat.balance .cash-stat-value { color: white; }

    .cash-stat.balance .cash-stat-icon {
        background: rgba(255,255,255,.12);
        color: #E5C987;
    }

    /* CONTENT */

    .cash-content {
        display: grid;
        grid-template-columns: minmax(0, 1.7fr) minmax(280px, .9fr);
        gap: 22px;
    }

    .cash-panel {
        background: #FFFEFC;
        border: 1px solid #DED6CC;
        border-radius: 16px;
        overflow: hidden;
        min-width: 0;
    }

    .cash-panel-header {
        padding: 19px 21px;
        border-bottom: 1px solid #ECE5DD;
    }

    .cash-panel-header.transactions-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .cash-panel-heading {
        min-width: 0;
    }

    .cash-section-nav {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        justify-content: flex-start;
        margin-bottom: 16px;
    }

    .cash-content[hidden],
    .cash-panel[hidden] {
        display: none;
    }

    .cash-panel-title {
        font-family: "Playfair Display", serif;
        font-size: 17px;
        color: #1F1D20;
    }

    .cash-panel-subtitle {
        font-size: 10px;
        color: #756E69;
        margin-top: 3px;
    }

    /* FILTER */

    .cash-filter {
        padding: 18px 21px;
        background: #FCFAF6;
        border-bottom: 1px solid #ECE5DD;
    }

    .cash-filter-grid {
        display: grid;
        grid-template-columns: minmax(160px, 1.5fr) repeat(3, minmax(120px, 1fr));
        gap: 10px;
        align-items: end;
    }

    .cash-filter-group label {
        display: block;
        font-size: 9px;
        font-weight: 700;
        color: #756E69;
        margin-bottom: 6px;
    }

    .cash-filter-group input,
    .cash-filter-group select {
        width: 100%;
        height: 38px;
        padding: 0 10px;
        border: 1px solid #DED6CC;
        border-radius: 8px;
        background: #FFFEFC;
        color: #54251F;
        font-size: 10px;
        outline: none;
    }

    .cash-filter-group input:focus,
    .cash-filter-group select:focus {
        border-color: #B59A63;
        box-shadow: 0 0 0 2px rgba(181,154,99,.12);
    }

    .cash-filter-actions {
        display: flex;
        gap: 8px;
        margin-top: 12px;
    }

    .cash-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 9px 14px;
        border-radius: 8px;
        border: none;
        font-size: 10px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
    }

    .cash-btn-primary {
        background: #54251F;
        color: white;
    }

    .cash-btn-primary:hover {
        background: #803E2F;
        color: white;
    }

    .cash-btn-reset {
        background: #F1ECE4;
        color: #54251F;
    }

    .cash-btn-reset:hover {
        background: #E8DFD2;
        color: #54251F;
    }

    /* TABLE */

    .cash-table-wrapper { overflow-x: auto; }

    .cash-table {
        width: 100%;
        border-collapse: collapse;
    }

    .cash-table th {
        padding: 13px 18px;
        text-align: left;
        font-size: 9px;
        text-transform: uppercase;
        letter-spacing: .8px;
        color: #756E69;
        background: #FAF8F4;
        border-bottom: 1px solid #DED6CC;
    }

    .cash-table td {
        padding: 15px 18px;
        font-size: 11px;
        border-bottom: 1px solid #EEE8E0;
    }

    .cash-table tbody tr:last-child td { border-bottom: none; }

    .checklist-table-scroll {
        display: block;
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        overscroll-behavior-x: contain;
        -webkit-overflow-scrolling: touch;
        scrollbar-color: #B59A63 #F1ECE4;
        scrollbar-width: thin;
    }

    .checklist-table-scroll::-webkit-scrollbar {
        height: 8px;
    }

    .checklist-table-scroll::-webkit-scrollbar-track {
        border-radius: 8px;
        background: #F1ECE4;
    }

    .checklist-table-scroll::-webkit-scrollbar-thumb {
        border-radius: 8px;
        background: #B59A63;
    }

    .checklist-table {
        width: 100%;
        min-width: 1120px;
        border-collapse: collapse;
    }

    .checklist-table th,
    .checklist-table td {
        padding: 11px 9px;
        border-bottom: 1px solid #EEE8E0;
        font-size: 10px;
        text-align: center;
        white-space: nowrap;
    }

    .checklist-table th {
        color: #756E69;
        background: #FAF8F4;
        font-size: 9px;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .checklist-table .checklist-student {
        min-width: 150px;
        text-align: left;
        white-space: normal;
    }

    .checklist-month-status {
        display: grid;
        justify-items: center;
        gap: 4px;
    }

    .checklist-month-icon.paid {
        color: #56856c;
    }

    .checklist-month-icon.unpaid {
        color: #B9B0A5;
    }

    .checklist-month-amount {
        color: #756E69;
        font-size: 9px;
    }

    .checklist-month-amount.paid,
    .checklist-total {
        color: #54251F;
        font-weight: 700;
    }

    .checklist-year-form {
        display: flex;
        align-items: center;
        gap: 7px;
        color: #756E69;
        font-size: 10px;
    }

    .checklist-year-form select {
        height: 34px;
        padding: 0 9px;
        border: 1px solid #DED6CC;
        border-radius: 7px;
        background: #FFFEFC;
        color: #54251F;
        font-size: 10px;
    }

    .cash-date-cell {
        color: #756E69;
        white-space: nowrap;
    }

    .cash-category {
        font-weight: 600;
        color: #1F1D20;
    }

    .cash-description {
        color: #756E69;
        font-size: 10px;
        margin-top: 3px;
        max-width: 280px;
    }

    .cash-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 8px;
        border-radius: 20px;
        font-size: 9px;
        font-weight: 600;
    }

    .cash-badge.in {
        background: #E9F1EC;
        color: #56856c;
    }

    .cash-badge.out {
        background: #F5E8E6;
        color: #9B5750;
    }

    .cash-amount-in {
        color: #56856c;
        font-weight: 700;
        white-space: nowrap;
    }

    .cash-amount-out {
        color: #9B5750;
        font-weight: 700;
        white-space: nowrap;
    }

    .cash-empty {
        text-align: center;
        padding: 40px 20px !important;
        color: #756E69;
        font-size: 11px;
    }

    .cash-empty i {
        font-size: 22px;
        margin-bottom: 10px;
    }

    /* PAGINATION */

    .cash-pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        padding: 16px 20px;
        border-top: 1px solid #ECE5DD;
    }

    .cash-pagination-info {
        font-size: 10px;
        color: #756E69;
    }

    .cash-page-links {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 5px;
    }

    .cash-page-links-scroll {
        max-width: 100%;
        flex-wrap: nowrap;
        overflow-x: auto;
        overflow-y: hidden;
        padding-bottom: 4px;
        overscroll-behavior-x: contain;
        -webkit-overflow-scrolling: touch;
        scrollbar-color: #B59A63 #F1ECE4;
        scrollbar-width: thin;
    }

    .cash-page-links-scroll::-webkit-scrollbar {
        height: 6px;
    }

    .cash-page-links-scroll::-webkit-scrollbar-track {
        border-radius: 6px;
        background: #F1ECE4;
    }

    .cash-page-links-scroll::-webkit-scrollbar-thumb {
        border-radius: 6px;
        background: #B59A63;
    }

    .cash-page-link,
    .cash-page-current,
    .cash-page-disabled,
    .cash-page-ellipsis {
        display: inline-flex;
        flex: 0 0 auto;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        padding: 0 8px;
        border: 1px solid #DED6CC;
        border-radius: 8px;
        font-size: 10px;
    }

    .cash-page-link {
        color: #54251F;
        background: #FFFEFC;
        text-decoration: none;
        transition: .2s ease;
    }

    .cash-page-link:hover {
        border-color: #B59A63;
        background: #F1ECE4;
    }

    .cash-page-current {
        border-color: #54251F;
        color: #fff;
        background: #54251F;
        font-weight: 700;
    }

    .cash-page-disabled {
        color: #B9B0A5;
        background: #F8F5F0;
    }

    .cash-page-ellipsis {
        border: 1px solid #DED6CC;
        color: #756E69;
        background: transparent;
    }

    /* INFO */

    .cash-info-list {
        padding: 7px 21px 20px;
    }

    .cash-info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #EEE8E0;
    }

    .cash-info-item:last-child { border-bottom: none; }

    .cash-info-label {
        font-size: 10px;
        color: #756E69;
    }

    .cash-info-value {
        font-size: 11px;
        font-weight: 700;
        color: #54251F;
    }

    .cash-notice {
        margin: 0 21px 21px;
        padding: 14px;
        background: #F7F1E7;
        border-left: 3px solid #B59A63;
        border-radius: 8px;
    }

    .cash-notice-title {
        font-size: 10px;
        font-weight: 700;
        color: #54251F;
        margin-bottom: 5px;
    }

    .cash-notice-text {
        font-size: 9px;
        line-height: 1.6;
        color: #756E69;
    }

    /* RESPONSIVE */

    @media (max-width: 1100px) {
        .cash-filter-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 1000px) {
        .cash-stats { grid-template-columns: 1fr; }
        .cash-content { grid-template-columns: 1fr; }
    }

    @media (max-width: 700px) {
        .cash-topbar {
            flex-direction: column;
            gap: 15px;
        }

        .cash-date { text-align: left; }

        .cash-filter-grid {
            grid-template-columns: 1fr;
        }

        .cash-panel-header.transactions-header {
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .cash-section-nav {
            justify-content: flex-start;
        }

        .cash-pagination {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>


<div class="cash-page">

    <!-- HEADER -->

    <header class="cash-topbar">
        <div>
            <div class="cash-eyebrow">
                Monitoring Keuangan
            </div>

            <h1 class="cash-title">
                Pantau Kas
            </h1>

            <p class="cash-subtitle">
                Pantau kondisi dan riwayat keuangan kelas XI RPL 1.
            </p>
        </div>

        <div class="cash-date">
            <span>Tahun Ajaran</span>
            <strong>2026 / 2027</strong>
        </div>
    </header>


    <!-- STATISTIK -->

    <section class="cash-stats">

        <div class="cash-stat">
            <div class="cash-stat-top">
                <span class="cash-stat-label">Total Pemasukan</span>
                <div class="cash-stat-icon">
                    <i class="fa-solid fa-arrow-down"></i>
                </div>
            </div>

            <div class="cash-stat-value">
                Rp {{ number_format($totalPemasukan ?? 0, 0, ',', '.') }}
            </div>
        </div>


        <div class="cash-stat">
            <div class="cash-stat-top">
                <span class="cash-stat-label">Total Pengeluaran</span>
                <div class="cash-stat-icon">
                    <i class="fa-solid fa-arrow-up"></i>
                </div>
            </div>

            <div class="cash-stat-value">
                Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}
            </div>
        </div>


        <div class="cash-stat balance">
            <div class="cash-stat-top">
                <span class="cash-stat-label">Saldo Kas</span>
                <div class="cash-stat-icon">
                    <i class="fa-solid fa-wallet"></i>
                </div>
            </div>

            <div class="cash-stat-value">
                Rp {{ number_format($totalSaldo ?? 0, 0, ',', '.') }}
            </div>
        </div>

    </section>


    <!-- CONTENT -->

    <nav class="cash-section-nav" aria-label="Pilih tabel laporan" role="tablist">
        <button type="button"
            class="cash-btn {{ $activeReportTable === 'transactions' ? 'cash-btn-primary' : 'cash-btn-reset' }}"
            id="transactionsTab"
            role="tab"
            aria-controls="transactionReport"
            aria-selected="{{ $activeReportTable === 'transactions' ? 'true' : 'false' }}"
            onclick="showReportTable('transactions')">
            <i class="fa-solid fa-list"></i>
            Riwayat Transaksi
        </button>
        <button type="button"
            class="cash-btn {{ $activeReportTable === 'payments' ? 'cash-btn-primary' : 'cash-btn-reset' }}"
            id="paymentsTab"
            role="tab"
            aria-controls="paymentReport"
            aria-selected="{{ $activeReportTable === 'payments' ? 'true' : 'false' }}"
            onclick="showReportTable('payments')">
            <i class="fa-solid fa-clipboard-check"></i>
            Ceklis Pembayaran Siswa
        </button>
    </nav>

    <section class="cash-content" id="transactionReport"
        role="tabpanel"
        aria-labelledby="transactionsTab"
        @if($activeReportTable !== 'transactions') hidden @endif>

        <!-- RIWAYAT TRANSAKSI -->

        <div class="cash-panel">

            <div class="cash-panel-header">
                <div class="cash-panel-heading">
                    <div class="cash-panel-title">
                        Riwayat Transaksi
                    </div>

                    <div class="cash-panel-subtitle">
                        Informasi transaksi kas kelas
                    </div>
                </div>

            </div>


            <!-- FILTER TRANSAKSI -->

            <form
                action="{{ route('wali-kelas.kas') }}"
                method="GET"
                class="cash-filter"
            >
                <input type="hidden"
                    name="payment_year"
                    value="{{ $paymentYear }}">
                <input type="hidden" name="report_table" value="transactions">

                <div class="cash-filter-grid">

                    <div class="cash-filter-group">
                        <label for="search">Cari Transaksi</label>

                        <input
                            type="text"
                            id="search"
                            name="search"
                            placeholder="Cari kategori atau keterangan..."
                            value="{{ $search ?? '' }}"
                        >
                    </div>


                    <div class="cash-filter-group">
                        <label for="type">Jenis Transaksi</label>

                        <select name="type" id="type">
                            <option value="">Semua Transaksi</option>

                            <option
                                value="in"
                                {{ ($type ?? '') === 'in' ? 'selected' : '' }}
                            >
                                Pemasukan
                            </option>

                            <option
                                value="out"
                                {{ ($type ?? '') === 'out' ? 'selected' : '' }}
                            >
                                Pengeluaran
                            </option>
                        </select>
                    </div>


                    <div class="cash-filter-group">
                        <label for="start_date">Tanggal Awal</label>

                        <input
                            type="date"
                            id="start_date"
                            name="start_date"
                            value="{{ $startDate ?? '' }}"
                        >
                    </div>


                    <div class="cash-filter-group">
                        <label for="end_date">Tanggal Akhir</label>

                        <input
                            type="date"
                            id="end_date"
                            name="end_date"
                            value="{{ $endDate ?? '' }}"
                        >
                    </div>

                </div>


                <div class="cash-filter-actions">

                    <button type="submit" class="cash-btn cash-btn-primary">
                        <i class="fa-solid fa-filter"></i>
                        Terapkan Filter
                    </button>

                    <a
                        href="{{ route('wali-kelas.kas') }}"
                        class="cash-btn cash-btn-reset"
                    >
                        <i class="fa-solid fa-rotate-left"></i>
                        Reset
                    </a>

                </div>

            </form>


            <!-- TABEL TRANSAKSI -->

            <div class="cash-table-wrapper">

                <table class="cash-table">

                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>


                    <tbody>

                        @forelse ($transactions as $transaction)

                            <tr>

                                <td class="cash-date-cell">
                                    {{ $transaction->created_at?->format('d/m/Y') ?? '-' }}
                                </td>


                                <td>
                                    @if ($transaction->type === 'in')

                                        <span class="cash-badge in">
                                            <i class="fa-solid fa-arrow-down"></i>
                                            Pemasukan
                                        </span>

                                    @else

                                        <span class="cash-badge out">
                                            <i class="fa-solid fa-arrow-up"></i>
                                            Pengeluaran
                                        </span>

                                    @endif
                                </td>


                                <td>
                                    <div class="cash-category">
                                        {{ $transaction->category ?? 'Transaksi' }}
                                    </div>

                                    @if ($transaction->description)
                                        <div class="cash-description">
                                            {{ $transaction->description }}
                                        </div>
                                    @endif
                                </td>


                                <td>
                                    @if ($transaction->type === 'in')

                                        <span class="cash-amount-in">
                                            + Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </span>

                                    @else

                                        <span class="cash-amount-out">
                                            - Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </span>

                                    @endif
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="cash-empty">
                                    <i class="fa-regular fa-folder-open"></i>
                                    <br>
                                    Tidak ada transaksi yang sesuai dengan pencarian.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <!-- PAGINATION -->

            @if ($transactions->total() > 0)

                <div class="cash-pagination">

                    <div class="cash-pagination-info">
                        Menampilkan
                        {{ $transactions->firstItem() ?? 0 }}
                        -
                        {{ $transactions->lastItem() ?? 0 }}
                        dari
                        {{ $transactions->total() }}
                        transaksi
                    </div>

                    <nav class="cash-page-links cash-page-links-scroll"
                        aria-label="Halaman riwayat transaksi"
                        tabindex="0">
                        @if($transactions->previousPageUrl())
                            <a class="cash-page-link"
                                href="{{ $transactions->previousPageUrl() }}"
                                aria-label="Halaman sebelumnya">
                                <i class="fa-solid fa-chevron-left"></i>
                            </a>
                        @else
                            <span class="cash-page-disabled" aria-disabled="true">
                                <i class="fa-solid fa-chevron-left"></i>
                            </span>
                        @endif

                        @foreach($transactions->getUrlRange(1, $transactions->lastPage()) as $page => $url)
                            @if($page === $transactions->currentPage())
                                <span class="cash-page-current" aria-current="page">{{ $page }}</span>
                            @else
                                <a class="cash-page-link" href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if($transactions->nextPageUrl())
                            <a class="cash-page-link"
                                href="{{ $transactions->nextPageUrl() }}"
                                aria-label="Halaman berikutnya">
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        @else
                            <span class="cash-page-disabled" aria-disabled="true">
                                <i class="fa-solid fa-chevron-right"></i>
                            </span>
                        @endif
                    </nav>

                </div>

            @endif

        </div>


        <!-- INFORMASI KAS -->

        <div class="cash-panel">

            <div class="cash-panel-header">
                <div class="cash-panel-title">
                    Informasi Kas
                </div>

                <div class="cash-panel-subtitle">
                    Ringkasan kondisi kas kelas
                </div>
            </div>


            <div class="cash-info-list">

                <div class="cash-info-item">
                    <span class="cash-info-label">Kelas</span>
                    <span class="cash-info-value">XI RPL 1</span>
                </div>


                <div class="cash-info-item">
                    <span class="cash-info-label">Wali Kelas</span>
                    <span class="cash-info-value">Bu Lilis</span>
                </div>


                <div class="cash-info-item">
                    <span class="cash-info-label">
                        Iuran per {{ $periodType === 'Mingguan' ? 'Minggu' : 'Bulan' }}
                    </span>
                    <span class="cash-info-value">
                        {{ $periodFee !== null ? 'Rp ' . number_format($periodFee, 0, ',', '.') : 'Belum ditentukan' }}
                    </span>
                </div>


                <div class="cash-info-item">
                    <span class="cash-info-label">Total Transaksi</span>
                    <span class="cash-info-value">
                        {{ $totalTransaksi ?? $transactions->total() }}
                    </span>
                </div>

            </div>


            <div class="cash-notice">

                <div class="cash-notice-title">
                    <i class="fa-solid fa-circle-info"></i>
                    &nbsp; Informasi
                </div>

                <div class="cash-notice-text">
                    Halaman ini bersifat monitoring.
                    Wali Kelas dapat melihat kondisi kas
                    dan riwayat transaksi tanpa melakukan
                    perubahan terhadap data keuangan.
                </div>

            </div>

        </div>

    </section>

    <section class="cash-panel" id="paymentReport"
        role="tabpanel"
        aria-labelledby="paymentsTab"
        @if($activeReportTable !== 'payments') hidden @endif>
        <div class="cash-panel-header transactions-header">
            <div class="cash-panel-heading">
                <div class="cash-panel-title">
                    Ceklis Pembayaran Siswa
                </div>
                <div class="cash-panel-subtitle">
                    @if($periodFee !== null)
                        Centang menandakan lunas Rp {{ number_format($periodFee, 0, ',', '.') }} per {{ $periodType === 'Mingguan' ? 'minggu' : 'bulan' }}. Geser tabel untuk melihat semua periode.
                    @else
                        Tarif kas belum ditentukan, sehingga status lunas belum bisa dihitung. Geser tabel untuk melihat semua periode.
                    @endif
                </div>
            </div>

            <form method="GET"
                action="{{ route('wali-kelas.kas') }}"
                class="checklist-year-form">
                <input type="hidden" name="search" value="{{ $search ?? '' }}">
                <input type="hidden" name="type" value="{{ $type ?? '' }}">
                <input type="hidden" name="start_date" value="{{ $startDate ?? '' }}">
                <input type="hidden" name="end_date" value="{{ $endDate ?? '' }}">
                <input type="hidden" name="report_table" value="payments">
                <label for="payment_year">Tahun:</label>
                <select name="payment_year"
                    id="payment_year"
                    onchange="this.form.submit()">
                    @for($year = now()->year; $year >= now()->year - 5; $year--)
                        <option value="{{ $year }}" {{ $paymentYear === $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endfor
                </select>
            </form>
        </div>

        <div class="checklist-table-scroll"
            role="region"
            aria-label="Daftar ceklis pembayaran siswa, geser ke samping untuk melihat seluruh periode"
            tabindex="0">
            <table class="checklist-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th class="checklist-student">Nama Siswa</th>
                        @foreach($studentPayments->first()['periods'] ?? [] as $period)
                            <th title="{{ $period['month_label'] }}">{{ $period['label'] }}</th>
                        @endforeach
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($studentPayments as $index => $data)
                        <tr>
                            <td>{{ ($paymentStudents->firstItem() ?? 1) + $index }}</td>
                            <td>{{ $data['student']->nis ?? '-' }}</td>
                            <td class="checklist-student">{{ $data['student']->name }}</td>
                            @foreach($data['periods'] as $period)
                                <td>
                                    <div class="checklist-month-status">
                                        <i class="fa-solid {{ $period['paid'] ? 'fa-circle-check checklist-month-icon paid' : 'fa-circle-minus checklist-month-icon unpaid' }}"
                                            aria-label="{{ $period['paid'] ? 'Lunas' : 'Belum lunas' }}"></i>
                                        <span class="checklist-month-amount {{ $period['paid'] ? 'paid' : '' }}">
                                            Rp {{ number_format($period['amount'], 0, ',', '.') }}
                                        </span>
                                    </div>
                                </td>
                            @endforeach
                            <td class="checklist-total">
                                Rp {{ number_format($data['total'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($paymentPeriods) + 4 }}" class="cash-empty">
                                Belum ada data siswa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($paymentStudents->hasPages())
            <div class="cash-pagination">
                <div class="cash-pagination-info">
                    Menampilkan {{ $paymentStudents->firstItem() ?? 0 }}
                    - {{ $paymentStudents->lastItem() ?? 0 }}
                    dari {{ $paymentStudents->total() }} siswa
                </div>
                <nav class="cash-page-links cash-page-links-scroll"
                    aria-label="Halaman ceklis pembayaran siswa"
                    tabindex="0">
                    @if($paymentStudents->previousPageUrl())
                        <a class="cash-page-link"
                            href="{{ $paymentStudents->previousPageUrl() }}"
                            aria-label="Halaman sebelumnya">
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>
                    @else
                        <span class="cash-page-disabled" aria-disabled="true">
                            <i class="fa-solid fa-chevron-left"></i>
                        </span>
                    @endif

                    @foreach($paymentStudents->getUrlRange(1, $paymentStudents->lastPage()) as $page => $url)
                        @if($page === $paymentStudents->currentPage())
                            <span class="cash-page-current" aria-current="page">{{ $page }}</span>
                        @else
                            <a class="cash-page-link" href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if($paymentStudents->nextPageUrl())
                        <a class="cash-page-link"
                            href="{{ $paymentStudents->nextPageUrl() }}"
                            aria-label="Halaman berikutnya">
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="cash-page-disabled" aria-disabled="true">
                            <i class="fa-solid fa-chevron-right"></i>
                        </span>
                    @endif
                </nav>
            </div>
        @endif
    </section>

</div>

<script>
    function showReportTable(table) {
        const showTransactions = table === 'transactions';
        const transactionReport = document.getElementById('transactionReport');
        const paymentReport = document.getElementById('paymentReport');
        const transactionsTab = document.getElementById('transactionsTab');
        const paymentsTab = document.getElementById('paymentsTab');

        transactionReport.hidden = !showTransactions;
        paymentReport.hidden = showTransactions;

        transactionsTab.classList.toggle('cash-btn-primary', showTransactions);
        transactionsTab.classList.toggle('cash-btn-reset', !showTransactions);
        transactionsTab.setAttribute('aria-selected', String(showTransactions));

        paymentsTab.classList.toggle('cash-btn-primary', !showTransactions);
        paymentsTab.classList.toggle('cash-btn-reset', showTransactions);
        paymentsTab.setAttribute('aria-selected', String(!showTransactions));
    }
</script>

@endsection
